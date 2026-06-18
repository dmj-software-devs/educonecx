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
use Stripe\Webhook;
use App\Services\PracticeCreditService;
use Exception;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe Checkout Session
     */
    public function createCheckoutSession(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $user = Auth::user();

        // Check if user is already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'error' => 'You are already enrolled in this course.'
            ], 400);
        }

        // Check if it's a free course
        if ($course->is_free) {
            return response()->json([
                'redirect_url' => route('courses.enroll', $course)
            ]);
        }

        try {
            // Generate unique order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // Create a pending order in database
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'subtotal' => $course->current_price,
                'total' => $course->current_price,
                'payment_method' => 'stripe',
                'payment_status' => 'pending',
                'billing_name' => $user->name,
                'billing_email' => $user->email
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'course_title' => $course->title,
                'price' => $course->current_price,
                'total' => $course->current_price
            ]);

            // Create Stripe Checkout Session
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $course->title,
                            'description' => $course->excerpt ?? $course->short_description,
                            'images' => $course->thumbnail_url ? [$course->thumbnail_url] : [],
                        ],
                        'unit_amount' => round($course->current_price * 100), // Stripe uses cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
                'client_reference_id' => $order->id,
                'customer_email' => $user->email,
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $orderNumber,
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                ],
            ]);

            // Update order with Stripe session ID
            $order->update([
                'transaction_id' => $checkoutSession->id
            ]);

            return response()->json([
                'session_id' => $checkoutSession->id,
                'checkout_url' => $checkoutSession->url
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create checkout session: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('payment.cancel');
        }

        try {
            // Retrieve the session from Stripe
            $session = Session::retrieve($sessionId);
            
            // Get the order
            $order = Order::with('items.course')
                ->where('transaction_id', $sessionId)
                ->first();

            if (!$order) {
                // Try to find by client_reference_id if transaction_id not matched
                $order = Order::with('items.course')
                    ->find($session->client_reference_id);
            }

            if (!$order) {
                return redirect()->route('payment.cancel')
                    ->with('error', 'Order not found.');
            }

            // If order is already processed, redirect to success page
            if ($order->payment_status === 'paid') {
                return redirect()->route('payment.success', ['order' => $order->id]);
            }

            // Check payment status
            if ($session->payment_status === 'paid') {
                DB::beginTransaction();

                try {
                    // Update order status
                    $order->update([
                        'payment_status' => 'paid',
                        'transaction_id' => $session->payment_intent ?? $sessionId
                    ]);

                    // Create enrollment for each course in the order
                    foreach ($order->items as $item) {
                        if ($item->course) {
                            // Check if enrollment already exists
                            $existingEnrollment = Enrollment::where('user_id', $order->user_id)
                                ->where('course_id', $item->course_id)
                                ->first();

                            if (!$existingEnrollment) {
                                Enrollment::create([
                                    'user_id' => $order->user_id,
                                    'course_id' => $item->course_id,
                                    'order_id' => $order->id,
                                    'enrollment_date' => now(),
                                    'status' => 'active',
                                    'progress' => 0
                                ]);

                                // Increment total students count
                                $item->course->increment('total_students');
                            }
                        }
                    }

                    DB::commit();

                    return redirect()->route('payment.success', ['order' => $order->id]);

                } catch (Exception $e) {
                    DB::rollBack();
                    \Log::error('Stripe payment processing error: ' . $e->getMessage());
                    
                    return redirect()->route('payment.cancel')
                        ->with('error', 'Payment was successful but enrollment failed. Please contact support.');
                }
            } else {
                // Payment not successful
                $order->update(['payment_status' => 'failed']);
                
                return redirect()->route('payment.cancel')
                    ->with('error', 'Payment was not successful.');
            }

        } catch (Exception $e) {
            \Log::error('Stripe success handler error: ' . $e->getMessage());
            
            return redirect()->route('payment.cancel')
                ->with('error', 'Error processing payment. Please contact support.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function cancel()
    {
        return redirect()->route('payment.cancel')
            ->with('error', 'Payment was cancelled.');
    }

    /**
     * Stripe webhook handler
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentFailed($paymentIntent);
                break;
            
            default:
                // Unexpected event type
                return response()->json(['error' => 'Unexpected event type'], 400);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle checkout.session.completed event
     */
    protected function handleCheckoutSessionCompleted($session)
    {
        if ((string) data_get($session, 'metadata.type') === 'practice_sessions') {
            app(PracticeCreditService::class)->processPracticeSessionCheckout($session);
            return;
        }

        // Find the order
        $order = Order::find($session->client_reference_id);
        
        if (!$order || $order->payment_status === 'paid') {
            return;
        }

        DB::beginTransaction();

        try {
            // Update order status
            $order->update([
                'payment_status' => 'paid',
                'transaction_id' => $session->payment_intent
            ]);

            // Create enrollments
            foreach ($order->items as $item) {
                if ($item->course) {
                    $existingEnrollment = Enrollment::where('user_id', $order->user_id)
                        ->where('course_id', $item->course_id)
                        ->first();

                    if (!$existingEnrollment) {
                        Enrollment::create([
                            'user_id' => $order->user_id,
                            'course_id' => $item->course_id,
                            'order_id' => $order->id,
                            'enrollment_date' => now(),
                            'status' => 'active',
                            'progress' => 0
                        ]);

                        $item->course->increment('total_students');
                    }
                }
            }

            DB::commit();

            // TODO: Send email notification to user

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Webhook processing error: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment_intent.succeeded event
     */
    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        // Find order by transaction_id and update if needed
        Order::where('transaction_id', $paymentIntent->id)
            ->where('payment_status', '!=', 'paid')
            ->update(['payment_status' => 'paid']);
    }

    /**
     * Handle payment_intent.payment_failed event
     */
    protected function handlePaymentIntentFailed($paymentIntent)
    {
        // Find order by transaction_id and update status
        Order::where('transaction_id', $paymentIntent->id)
            ->update(['payment_status' => 'failed']);
    }
}