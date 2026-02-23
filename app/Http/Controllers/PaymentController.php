<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('checkout', compact('course'));
    }

    /**
     * Process payment (simplified - you'll integrate with actual payment gateway)
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_method' => 'required|string'
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
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'paid', // In real scenario, this would be 'pending' until payment confirmation
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

            // Create enrollment
            Enrollment::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'order_id' => $order->id,
                'enrollment_date' => now(),
                'status' => 'active',
                'progress' => 0
            ]);

            // Increment total students count
            $course->increment('total_students');

            DB::commit();

            return redirect()->route('payment.success', ['order' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Payment processing failed. Please try again.');
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
        // Handle payment gateway webhooks
        // Verify payment and update order status
        // Create enrollment if payment successful
    }
}
