<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
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

        switch ($request->get('sort', 'latest')) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'expiring_soon':
                $query->where('status', 'active')->orderBy('end_date');
                break;
            case 'recently_expired':
                $query->where('status', 'expired')->latest('end_date');
                break;
        }

        $subscriptions = $query->paginate(20)->withQueryString();
        $users = User::where('role', 'student')->orderBy('name')->get();
        $plans = SubscriptionPlan::orderBy('name')->get();
        $statuses = ['active', 'expired', 'cancelled', 'pending'];

        return view('admin.subscriptions.index', compact('subscriptions', 'users', 'plans', 'statuses'));
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        $users = User::where('role', 'student')->orderBy('name')->get();
        $plans = SubscriptionPlan::active()->ordered()->get();

        return view('admin.subscriptions.create', compact('users', 'plans'));
    }

    /**
     * Store a manually-created subscription.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,pending,expired,cancelled',
            'payment_status' => 'required|in:paid,pending,failed',
            'auto_renew' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            $subscription = UserSubscription::create([
                'user_id' => $validated['user_id'],
                'plan_id' => $validated['plan_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'auto_renew' => $request->boolean('auto_renew', false),
            ]);

            if ($subscription->status === 'active') {
                UserSubscription::where('user_id', $subscription->user_id)
                    ->where('id', '!=', $subscription->id)
                    ->where('status', 'active')
                    ->update(['status' => 'expired', 'auto_renew' => false]);

                $subscription->user->enrollInAllPaidCourses($subscription->id);

                $subscription->user->enrollments()
                    ->where('access_type', 'subscription')
                    ->update([
                        'status' => 'active',
                        'expiry_date' => $subscription->end_date,
                    ]);
            }

            DB::commit();

            return redirect()->route('admin.subscriptions.show', $subscription)
                ->with('success', 'Manual subscription created successfully and course access has been granted.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create subscription: ' . $e->getMessage());
        }
    }

    /**
     * Display a single subscription.
     */
    public function show(UserSubscription $subscription)
    {
        $subscription->load(['user', 'plan', 'order.items']);

        $enrollments = $subscription->user->enrollments()
            ->where('access_type', 'subscription')
            ->with('course')
            ->latest('updated_at')
            ->get();

        return view('admin.subscriptions.show', compact('subscription', 'enrollments'));
    }

    /**
     * Show edit form.
     */
    public function edit(UserSubscription $subscription)
    {
        $subscription->load('user', 'plan');
        $plans = SubscriptionPlan::ordered()->get();

        return view('admin.subscriptions.edit', compact('subscription', 'plans'));
    }

    /**
     * Update subscription.
     */
    public function update(Request $request, UserSubscription $subscription)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,cancelled,pending',
            'payment_status' => 'required|in:paid,pending,failed',
            'auto_renew' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            $oldStatus = $subscription->status;

            $subscription->update([
                'plan_id' => $validated['plan_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'auto_renew' => $request->boolean('auto_renew', false),
            ]);

            if ($subscription->status === 'active') {
                UserSubscription::where('user_id', $subscription->user_id)
                    ->where('id', '!=', $subscription->id)
                    ->where('status', 'active')
                    ->update(['status' => 'expired', 'auto_renew' => false]);

                $subscription->user->enrollInAllPaidCourses($subscription->id);

                $subscription->user->enrollments()
                    ->where('access_type', 'subscription')
                    ->update([
                        'expiry_date' => $subscription->end_date,
                        'status' => 'active',
                    ]);
            } elseif ($oldStatus === 'active' && in_array($subscription->status, ['expired', 'cancelled'])) {
                $subscription->user->enrollments()
                    ->where('access_type', 'subscription')
                    ->update([
                        'expiry_date' => now(),
                        'status' => 'expired',
                    ]);
            }

            DB::commit();

            return redirect()->route('admin.subscriptions.show', $subscription)
                ->with('success', 'Subscription updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update subscription: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a subscription quickly.
     */
    public function cancel(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $subscription->update([
                'status' => 'cancelled',
                'auto_renew' => false,
            ]);

            $subscription->user->enrollments()
                ->where('access_type', 'subscription')
                ->where('expiry_date', '>', now())
                ->update([
                    'expiry_date' => now(),
                    'status' => 'expired',
                ]);

            DB::commit();

            return redirect()->back()->with('success', 'Subscription cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }

    /**
     * Renew a subscription manually.
     */
    public function renew(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'duration_days' => 'nullable|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $durationDays = $request->duration_days ?? $subscription->plan->duration_days;
            $newEndDate = now()->addDays($durationDays);

            $subscription->update([
                'end_date' => $newEndDate,
                'status' => 'active',
                'payment_status' => 'paid',
            ]);

            $subscription->user->enrollInAllPaidCourses($subscription->id);

            $subscription->user->enrollments()
                ->where('access_type', 'subscription')
                ->update([
                    'expiry_date' => $newEndDate,
                    'status' => 'active',
                ]);

            DB::commit();

            return redirect()->back()->with('success', 'Subscription renewed successfully until ' . $newEndDate->format('M d, Y'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to renew subscription: ' . $e->getMessage());
        }
    }

    /**
     * Delete a subscription.
     */
    public function destroy(UserSubscription $subscription)
    {
        DB::beginTransaction();

        try {
            $subscription->user->enrollments()
                ->where('access_type', 'subscription')
                ->delete();

            $subscription->delete();

            DB::commit();

            return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to delete subscription: ' . $e->getMessage());
        }
    }

    /**
     * Export subscriptions as CSV.
     */
    public function export(Request $request)
    {
        $query = UserSubscription::with(['user', 'plan']);

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

        $filename = 'subscriptions_' . now()->format('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w+');

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
            'Created At',
        ]);

        foreach ($subscriptions as $sub) {
            fputcsv($handle, [
                $sub->id,
                $sub->user->name,
                $sub->user->email,
                $sub->plan->name,
                $sub->plan->price,
                optional($sub->start_date)->format('Y-m-d'),
                optional($sub->end_date)->format('Y-m-d'),
                $sub->status,
                $sub->payment_status,
                $sub->auto_renew ? 'Yes' : 'No',
                optional($sub->created_at)->format('Y-m-d H:i:s'),
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