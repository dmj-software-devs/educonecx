<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout(Course $course)
    {
        // Check if user is already enrolled
        $existingEnrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.learning', $course->slug)
                ->with('info', 'You are already enrolled in this course.');
        }

        // Check if it's a free course
        if ($course->is_free) {
            return redirect()->route('courses.enroll', $course);
        }

        // Use the new Stripe checkout view
        return view('checkout-stripe', compact('course'));
    }

    /**
     * Process payment with Stripe
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_method_id' => 'required|string'
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // Check if it's a free course
        if ($course->is_free) {
            return redirect()->route('courses.enroll', $course);
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $course->current_price,
                'total' => $course->current_price,
                'payment_method' => 'stripe',
                'payment_status' => 'pending',
                'billing_name' => Auth::user()->name,
                'billing_email' => Auth::user()->email
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'course_title' => $course->title,
                'price' => $course->current_price,
                'total' => $course->current_price
            ]);

            // Initialize Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create Payment Intent
            $paymentIntent = PaymentIntent::create([
                'amount' => round($course->current_price * 100),
                'currency' => 'usd',
                'payment_method' => $validated['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success'),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'course_id' => $course->id,
                    'user_id' => Auth::id()
                ]
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Update order
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $paymentIntent->id
                ]);

                // Create enrollment
                Enrollment::create([
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                    'order_id' => $order->id,
                    'enrollment_date' => now(),
                    'status' => 'active',
                    'progress' => 0
                ]);

                $course->increment('total_students');

                DB::commit();

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('payment.success', ['order' => $order->id])
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
     * Payment success page
     */
    public function success(Request $request)
    {
        $order = Order::with('items.course')
            ->where('user_id', Auth::id())
            ->findOrFail($request->order);

        return view('payment-success', compact('order'));
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
        // You can keep this for backward compatibility
        // Or delegate to the StripePaymentController
        return app(StripePaymentController::class)->handleWebhook($request);
    }
}