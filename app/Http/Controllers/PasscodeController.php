<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Http\Request;

class PasscodeController extends Controller
{
    public function passcodeHome()
    {
        return view('passcode.passcode-home', ['title' => 'Passcode feature']);
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Passcode'],
                    'unit_amount' => 1000, // price in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('passcode.success'),
            'cancel_url' => route('passcode.cancel'),
        ]);

        return redirect($session->url, 303);
    }

    public function success()
    {
        $paymentId = session('payment_id');
        if (!$paymentId) {
            return redirect('/')->with('error', 'No valid payment found.');
        }

        $payment = Payment::find($paymentId);
        if (!$payment || $payment->passcode_displayed) {
            return redirect('/')->with('error', 'Invalid or already displayed passcode.');
        }

        // Mark the passcode as displayed
        $payment->update(['passcode_displayed' => true]);

        return view('success', ['passcode' => $payment->passcode]);
    }

    public function cancel(Request $request)
    {
        print("cancel");
    }

    public function handleWebhook(Request $request)
    {
        print("success +");
    }
}
