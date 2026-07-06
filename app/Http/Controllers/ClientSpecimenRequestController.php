<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SpecimenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ClientSpecimenRequestController extends Controller
{
    public function index()
    {
        $requests = SpecimenRequest::with('latestPayment')
            ->where('client_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('client.requests.index', compact('requests'));
    }

    public function show(SpecimenRequest $request)
    {
        $this->authorizeClient($request);
        $request->load('payments');

        return view('client.requests.show', compact('request'));
    }

    public function confirm(SpecimenRequest $request)
    {
        $this->authorizeClient($request);

        if (! $request->isPaid()) {
            return redirect()->route('client.requests.pay', $request)
                ->with('error', 'Please complete payment before confirming delivery.');
        }

        return view('client.requests.confirm', compact('request'));
    }

    public function submitConfirmation(Request $httpRequest, SpecimenRequest $request)
    {
        $this->authorizeClient($request);

        if (! $request->isPaid()) {
            return redirect()->route('client.requests.pay', $request)
                ->with('error', 'Please complete payment before confirming delivery.');
        }

        $validated = $httpRequest->validate([
            'recipient_name' => 'required|string|max:200',
            'notes' => 'nullable|string',
            'signature' => 'nullable|string',
        ]);

        $request->update([
            'status' => 'completed',
            'completed_at' => now(),
            'recipient_name' => $validated['recipient_name'],
            'delivery_notes' => $validated['notes'] ?? null,
            'signature' => $validated['signature'] ?? null,
        ]);

        return redirect()->route('client.requests.show', $request)
            ->with('success', 'Delivery confirmed successfully! Thank you.');
    }

    public function pay(SpecimenRequest $request)
    {
        $this->authorizeClient($request);

        if ($request->isPaid()) {
            return redirect()->route('client.requests.show', $request)->with('success', 'This request is already paid.');
        }

        if (! in_array($request->status, ['in_transit', 'delivered'], true)) {
            return redirect()->route('client.requests.show', $request)
                ->with('error', 'Payment opens once the request is in transit.');
        }

        return view('client.requests.pay', compact('request'));
    }

    public function checkout(SpecimenRequest $request)
    {
        $this->authorizeClient($request);

        if ($request->isPaid()) {
            return redirect()->route('client.requests.show', $request)->with('success', 'This request is already paid.');
        }

        if (! in_array($request->status, ['in_transit', 'delivered'], true)) {
            return back()->with('error', 'Payment opens once the request is in transit.');
        }

        $amount = max((float) $request->quoted_amount, 0.50);

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'SPEC-' . now()->format('YmdHis') . '-' . $request->id,
            'order_type' => 'specimen_delivery',
            'subtotal' => $amount,
            'discount_amount' => 0,
            'total' => $amount,
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'specimen_request_id' => $request->id,
            'billing_name' => Auth::user()->name ?? trim((Auth::user()->first_name ?? '') . ' ' . (Auth::user()->last_name ?? '')),
            'billing_email' => Auth::user()->email,
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => config('cashier.currency', 'usd'),
                    'product_data' => ['name' => 'Specimen delivery #' . ($request->request_number ?? $request->id)],
                    'unit_amount' => (int) round($amount * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id,
                'specimen_request_id' => $request->id,
                'type' => 'specimen_delivery',
            ],
            'success_url' => route('client.requests.payment.success', $request) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('client.requests.pay', $request),
        ]);

        $order->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }

    public function paymentSuccess(Request $httpRequest, SpecimenRequest $request)
    {
        $this->authorizeClient($request);

        $sessionId = $httpRequest->query('session_id');
        abort_unless($sessionId, 400);

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($sessionId);

        $order = Order::where('stripe_session_id', $sessionId)
            ->where('specimen_request_id', $request->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($session->payment_status === 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'transaction_id' => $session->payment_intent ?? $sessionId,
                'stripe_payment_intent' => $session->payment_intent ?? null,
                'stripe_response' => json_encode($session),
            ]);

            $request->update(['payment_status' => 'paid', 'paid_at' => now()]);

            return redirect()->route('client.requests.confirm', $request)
                ->with('success', 'Payment successful. You can now confirm delivery.');
        }

        $order->update(['payment_status' => 'failed', 'stripe_response' => json_encode($session)]);

        return redirect()->route('client.requests.pay', $request)->with('error', 'Payment was not completed.');
    }

    public function payments()
    {
        $payments = Order::with('specimenRequest')
            ->where('user_id', Auth::id())
            ->where('order_type', 'specimen_delivery')
            ->latest()
            ->paginate(15);

        return view('client.payments.index', compact('payments'));
    }

    private function authorizeClient(SpecimenRequest $request): void
    {
        abort_unless((int) $request->client_id === (int) Auth::id(), 403);
    }
}
