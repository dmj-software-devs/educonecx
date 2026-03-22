<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Enrollment;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    /**
     * Show subscription plans page
     */
    public function subscriptionPlans()
    {
        $plans = SubscriptionPlan::active()
            ->ordered()
            ->get();

        return view('subscription-plans', compact('plans'));
    }

    /**
     * Show subscription checkout
     */
    public function subscriptionCheckout($planId)
    {
        $plan = SubscriptionPlan::active()->findOrFail($planId);

        // Check if user already has active subscription
        if (Auth::user()->has_active_subscription) {
            return redirect()->route('dashboard')
                ->with('info', 'You already have an active subscription.');
        }

        return view('subscription-checkout', compact('plan'));
    }

    /**
     * Process subscription payment
     */
    public function processSubscription(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method_id' => 'required|string'
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['plan_id']);
        $user = Auth::user();

        // Check if user already has active subscription
        if ($user->has_active_subscription) {
            return response()->json([
                'success' => false,
                'error' => 'You already have an active subscription.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = 'SUB-' . strtoupper(uniqid());

            // Create order - REMOVED the 'status' field
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'order_type' => 'subscription',
                'subscription_id' => $plan->id,
                'subtotal' => $plan->price,
                'total' => $plan->price,
                'payment_method' => 'stripe',
                'payment_status' => 'pending',
                'billing_name' => $user->name,
                'billing_email' => $user->email
                // 'discount_amount' will use default 0
                // 'coupon_code' will be null
                // other fields will use defaults
            ]);

            // Create order item - explicitly set course_id to null
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => null, // Explicitly set to null for subscription
                'subscription_id' => $plan->id,
                'subscription_name' => $plan->name,
                'price' => $plan->price,
                'total' => $plan->price
            ]);

            // Initialize Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create Payment Intent
            $paymentIntent = PaymentIntent::create([
                'amount' => round($plan->price * 100),
                'currency' => 'usd',
                'payment_method' => $validated['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.subscription.success'),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                    'user_id' => $user->id
                ]
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Update order
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $paymentIntent->id,
                    'stripe_payment_intent' => $paymentIntent->id
                ]);

                // Create user subscription
                $subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'order_id' => $order->id,
                    'start_date' => now(),
                    'end_date' => $plan->calculateEndDate(),
                    'status' => 'active',
                    'payment_status' => 'paid',
                    'auto_renew' => true
                ]);

                // Enroll user in all paid courses
                $this->enrollInAllPaidCourses($user, $subscription);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('payment.subscription.success', ['order' => $order->id])
                ]);
            } else {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'error' => 'Payment failed. Please try again.'
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enroll user in all paid courses
     */
    private function enrollInAllPaidCourses($user, $subscription)
    {
        $paidCourses = Course::where('is_free', false)->get();

        foreach ($paidCourses as $course) {
            // Check if already enrolled
            $existingEnrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            if (!$existingEnrollment) {
                Enrollment::create([
                    'user_id' => $user->id,
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
     * Subscription success page
     */
    public function subscriptionSuccess(Request $request)
    {
        $order = Order::with(['items', 'subscription', 'userSubscription'])
            ->where('user_id', Auth::id())
            ->where('order_type', 'subscription')
            ->findOrFail($request->order);

        return view('subscription-success', compact('order'));
    }

    /**
     * Payment cancel page
     */
    public function cancel()
    {
        return view('payment-cancel');
    }

    /**
     * Payment webhook (for payment gateway callbacks)
     */
    public function webhook(Request $request)
    {
        return app(StripePaymentController::class)->handleWebhook($request);
    }
}
