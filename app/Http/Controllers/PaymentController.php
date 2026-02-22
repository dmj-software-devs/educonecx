<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Enrollment;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Show checkout page.
     */
    public function checkout(Request $request, Course $course)
    {
        $user = Auth::user();

        // Check if already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.learn', $course)
                ->with('info', 'You are already enrolled in this course.');
        }

        $coupon = null;
        $discountAmount = 0;
        $total = $course->current_price;

        if ($request->has('coupon')) {
            $coupon = Coupon::where('code', $request->coupon)->active()->first();
            
            if ($coupon) {
                // Check if coupon applies to this course
                if ($coupon->courses->isNotEmpty() && !$coupon->courses->contains($course->id)) {
                    return back()->with('error', 'This coupon does not apply to this course.');
                }

                // Calculate discount
                if ($coupon->discount_type === 'percentage') {
                    $discountAmount = ($total * $coupon->discount_value) / 100;
                    if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                        $discountAmount = $coupon->max_discount_amount;
                    }
                } else {
                    $discountAmount = $coupon->discount_value;
                }

                $total = max(0, $total - $discountAmount);
            } else {
                return back()->with('error', 'Invalid or expired coupon code.');
            }
        }

        return view('checkout', compact('course', 'coupon', 'discountAmount', 'total'));
    }

    /**
     * Process payment.
     */
    public function process(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_method' => 'required|in:stripe,paypal',
            'coupon_code' => 'nullable|string|exists:coupons,code',
        ]);

        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);

        // Check if already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.learn', $course)
                ->with('info', 'You are already enrolled in this course.');
        }

        $coupon = null;
        $discountAmount = 0;
        $subtotal = $course->current_price;
        $total = $subtotal;

        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->active()->first();
            
            if ($coupon) {
                if ($coupon->courses->isNotEmpty() && !$coupon->courses->contains($course->id)) {
                    return back()->with('error', 'This coupon does not apply to this course.');
                }

                if ($coupon->discount_type === 'percentage') {
                    $discountAmount = ($subtotal * $coupon->discount_value) / 100;
                    if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                        $discountAmount = $coupon->max_discount_amount;
                    }
                } else {
                    $discountAmount = $coupon->discount_value;
                }

                $total = max(0, $subtotal - $discountAmount);
            }
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'coupon_code' => $request->coupon_code,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'billing_name' => $user->name,
                'billing_email' => $user->email,
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'course_title' => $course->title,
                'price' => $course->price,
                'discount_amount' => $discountAmount,
                'total' => $total,
            ]);

            // Update coupon usage
            if ($coupon) {
                $coupon->increment('total_used');
            }

            // Here you would integrate with payment gateway
            // For now, we'll simulate successful payment
            
            $order->update([
                'payment_status' => 'paid',
                'transaction_id' => 'TXN-' . strtoupper(uniqid())
            ]);

            // Create enrollment
            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'order_id' => $order->id,
                'status' => 'active',
                'progress' => 0
            ]);

            // Update course student count
            $course->increment('total_students');

            // Create notification
            $user->notifications()->create([
                'type' => 'course_enrolled',
                'title' => 'Course Enrolled',
                'message' => "You have successfully enrolled in '{$course->title}'.",
                'data' => json_encode([
                    'course_id' => $course->id,
                    'order_id' => $order->id
                ])
            ]);

            DB::commit();

            return redirect()->route('payment.success', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment processing failed. Please try again.');
        }
    }

    /**
     * Payment success page.
     */
    public function success(Request $request)
    {
        $order = Order::with('items.course')
            ->where('user_id', Auth::id())
            ->findOrFail($request->order);

        return view('payment.success', compact('order'));
    }

    /**
     * Payment cancel page.
     */
    public function cancel()
    {
        return view('payment.cancel');
    }

    /**
     * Payment webhook (for payment gateways).
     */
    public function webhook(Request $request)
    {
        // Handle payment gateway webhook
        // This would be implemented based on your payment gateway
        return response()->json(['status' => 'received']);
    }
}