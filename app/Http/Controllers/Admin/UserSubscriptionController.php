<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSubscriptionController extends Controller
{
    /**
     * Display a listing of user subscriptions.
     */
    public function index(Request $request)
    {
        $query = UserSubscription::with(['user', 'plan']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        switch ($request->get('sort', 'latest')) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'expiring_soon':
                $query->where('status', 'active')
                    ->orderBy('end_date');
                break;
            case 'recently_expired':
                $query->where('status', 'expired')
                    ->latest('end_date');
                break;
        }

        $subscriptions = $query->paginate(20);
        
        // Get filter data
        $users = User::whereHas('subscriptions')->get();
        $plans = SubscriptionPlan::all();
        $statuses = ['active', 'expired', 'cancelled', 'pending'];

        return view('admin.subscriptions.index', compact('subscriptions', 'users', 'plans', 'statuses'));
    }

    /**
     * Display the specified subscription.
     */
    public function show(UserSubscription $subscription)
    {
        $subscription->load(['user', 'plan', 'order.items']);
        
        // Get enrollments from this subscription
        $enrollments = $subscription->user->enrollments()
            ->where('access_type', 'subscription')
            ->with('course')
            ->get();

        return view('admin.subscriptions.show', compact('subscription', 'enrollments'));
    }

    /**
     * Cancel a subscription.
     */
    public function cancel(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            // Cancel subscription
            $subscription->update([
                'status' => 'cancelled',
                'auto_renew' => false
            ]);

            // Update related enrollments - set expiry date to now
            $subscription->user->enrollments()
                ->where('access_type', 'subscription')
                ->where('expiry_date', '>', now())
                ->update([
                    'expiry_date' => now(),
                    'status' => 'expired'
                ]);

            // Log the cancellation
            activity()
                ->performedOn($subscription)
                ->causedBy(auth()->user())
                ->withProperties(['reason' => $request->reason])
                ->log('Subscription cancelled');

            DB::commit();

            return redirect()->back()
                ->with('success', 'Subscription cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }

    /**
     * Renew a subscription manually.
     */
    public function renew(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'duration_days' => 'nullable|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $durationDays = $request->duration_days ?? $subscription->plan->duration_days;
            
            // Calculate new end date
            $newEndDate = now()->addDays($durationDays);

            // Update subscription
            $subscription->update([
                'end_date' => $newEndDate,
                'status' => 'active',
                'payment_status' => 'paid' // Manual renewal by admin
            ]);

            // Update related enrollments expiry dates
            $subscription->user->enrollments()
                ->where('access_type', 'subscription')
                ->update([
                    'expiry_date' => $newEndDate,
                    'status' => 'active'
                ]);

            // Log the renewal
            activity()
                ->performedOn($subscription)
                ->causedBy(auth()->user())
                ->withProperties(['duration_days' => $durationDays])
                ->log('Subscription renewed manually');

            DB::commit();

            return redirect()->back()
                ->with('success', 'Subscription renewed successfully until ' . $newEndDate->format('M d, Y'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to renew subscription: ' . $e->getMessage());
        }
    }

    /**
     * Create a new subscription for a user manually.
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'plan_id' => 'required|exists:subscription_plans,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' => 'required|in:active,pending',
                'payment_status' => 'required|in:paid,pending',
                'auto_renew' => 'nullable|boolean'
            ]);

            DB::beginTransaction();

            try {
                // Create subscription
                $subscription = UserSubscription::create([
                    'user_id' => $validated['user_id'],
                    'plan_id' => $validated['plan_id'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'status' => $validated['status'],
                    'payment_status' => $validated['payment_status'],
                    'auto_renew' => $request->boolean('auto_renew', true)
                ]);

                // If active, enroll user in subscription courses
                if ($subscription->status === 'active') {
                    $this->enrollInSubscriptionCourses($subscription);
                }

                DB::commit();

                return redirect()->route('admin.subscriptions.show', $subscription)
                    ->with('success', 'Subscription created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()
                    ->with('error', 'Failed to create subscription: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // GET request - show form
        $users = User::where('role', 'student')->orderBy('name')->get();
        $plans = SubscriptionPlan::active()->get();

        return view('admin.subscriptions.create', compact('users', 'plans'));
    }

    /**
     * Edit a subscription.
     */
    public function edit(Request $request, UserSubscription $subscription)
    {
        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'plan_id' => 'required|exists:subscription_plans,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' => 'required|in:active,expired,cancelled,pending',
                'payment_status' => 'required|in:paid,pending,failed',
                'auto_renew' => 'nullable|boolean'
            ]);

            DB::beginTransaction();

            try {
                $oldStatus = $subscription->status;
                
                // Update subscription
                $subscription->update([
                    'plan_id' => $validated['plan_id'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'status' => $validated['status'],
                    'payment_status' => $validated['payment_status'],
                    'auto_renew' => $request->boolean('auto_renew', true)
                ]);

                // Handle status changes
                if ($oldStatus !== $subscription->status) {
                    if ($subscription->status === 'active') {
                        // Reactivated - enroll in courses
                        $this->enrollInSubscriptionCourses($subscription);
                    } elseif ($oldStatus === 'active' && in_array($subscription->status, ['expired', 'cancelled'])) {
                        // Deactivated - expire enrollments
                        $subscription->user->enrollments()
                            ->where('access_type', 'subscription')
                            ->update([
                                'expiry_date' => now(),
                                'status' => 'expired'
                            ]);
                    }
                }

                DB::commit();

                return redirect()->route('admin.subscriptions.show', $subscription)
                    ->with('success', 'Subscription updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()
                    ->with('error', 'Failed to update subscription: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // GET request - show form
        $subscription->load('user', 'plan');
        $plans = SubscriptionPlan::all();

        return view('admin.subscriptions.edit', compact('subscription', 'plans'));
    }

    /**
     * Delete a subscription.
     */
    public function destroy(UserSubscription $subscription)
    {
        DB::beginTransaction();

        try {
            // Remove related enrollments
            $subscription->user->enrollments()
                ->where('access_type', 'subscription')
                ->delete();

            // Delete subscription
            $subscription->delete();

            DB::commit();

            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'Subscription deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to delete subscription: ' . $e->getMessage());
        }
    }

    /**
     * Enroll user in all subscription-enabled courses.
     */
    private function enrollInSubscriptionCourses(UserSubscription $subscription)
    {
        $courses = \App\Models\Course::where('subscription_enabled', true)
            ->orWhere('subscription_required', true)
            ->get();

        foreach ($courses as $course) {
            // Check if user is already enrolled
            $existingEnrollment = \App\Models\Enrollment::where('user_id', $subscription->user_id)
                ->where('course_id', $course->id)
                ->first();

            if (!$existingEnrollment) {
                \App\Models\Enrollment::create([
                    'user_id' => $subscription->user_id,
                    'course_id' => $course->id,
                    'access_type' => 'subscription',
                    'enrollment_date' => now(),
                    'expiry_date' => $subscription->end_date,
                    'status' => 'active',
                    'progress' => 0
                ]);

                $course->increment('total_students');
            } elseif ($existingEnrollment->access_type === 'subscription') {
                // Update expiry date for existing subscription enrollment
                $existingEnrollment->update([
                    'expiry_date' => $subscription->end_date,
                    'status' => 'active'
                ]);
            }
        }
    }

    /**
     * Export subscriptions data.
     */
    public function export(Request $request)
    {
        $query = UserSubscription::with(['user', 'plan']);

        // Apply filters (same as index)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $subscriptions = $query->get();

        // Generate CSV
        $filename = 'subscriptions_' . now()->format('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w+');

        // Add headers
        fputcsv($handle, [
            'ID',
            'User Name',
            'User Email',
            'Plan Name',
            'Plan Price',
            'Start Date',
            'End Date',
            'Status',
            'Payment Status',
            'Auto Renew',
            'Created At'
        ]);

        // Add data
        foreach ($subscriptions as $sub) {
            fputcsv($handle, [
                $sub->id,
                $sub->user->name,
                $sub->user->email,
                $sub->plan->name,
                $sub->plan->price,
                $sub->start_date->format('Y-m-d'),
                $sub->end_date->format('Y-m-d'),
                $sub->status,
                $sub->payment_status,
                $sub->auto_renew ? 'Yes' : 'No',
                $sub->created_at->format('Y-m-d H:i:s')
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}