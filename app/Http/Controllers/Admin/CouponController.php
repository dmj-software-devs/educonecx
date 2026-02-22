<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(Request $request)
    {
        $query = Coupon::with('creator');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%");
        }

        $coupons = $query->latest()->paginate(15);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show form for creating a new coupon.
     */
    public function create()
    {
        $courses = Course::where('status', 'published')->get();
        return view('admin.coupons.create', compact('courses'));
    }

    /**
     * Store a newly created coupon.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|max:50|unique:coupons',
            'description' => 'nullable',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id'
        ]);

        $coupon = Coupon::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'usage_limit' => $request->usage_limit,
            'usage_per_user' => $request->usage_per_user ?? 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'created_by' => auth()->id()
        ]);

        if ($request->has('courses')) {
            $coupon->courses()->sync($request->courses);
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    /**
     * Show form for editing coupon.
     */
    public function edit(Coupon $coupon)
    {
        $courses = Course::where('status', 'published')->get();
        return view('admin.coupons.edit', compact('coupon', 'courses'));
    }

    /**
     * Update the specified coupon.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id'
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'usage_limit' => $request->usage_limit,
            'usage_per_user' => $request->usage_per_user ?? 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
        ]);

        if ($request->has('courses')) {
            $coupon->courses()->sync($request->courses);
        } else {
            $coupon->courses()->detach();
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified coupon.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->courses()->detach();
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }
}