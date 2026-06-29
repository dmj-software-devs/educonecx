<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SpecimenPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'specimenRequest'])
            ->where('order_type', 'specimen_delivery');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                    ->orWhereHas('specimenRequest', fn ($r) => $r->where('request_number', 'like', "%{$search}%"));
            });
        }

        $payments = $query->latest()->paginate(20)->withQueryString();

        return view('admin.specimen-payments.index', compact('payments'));
    }

    public function show(Order $payment)
    {
        abort_unless($payment->order_type === 'specimen_delivery', 404);

        $payment->load(['user', 'specimenRequest']);

        return view('admin.specimen-payments.show', compact('payment'));
    }
}
