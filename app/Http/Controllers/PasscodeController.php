<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\StripeWebhooks\ChargeSucceededJob;

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
        sleep(10);
        Log::info('Session ID in Success Page', ['session_id' => session()->getId()]);
        $paymentId = session('payment_id');
        Log::info("Payment id", ['charge' => $paymentId]);
        if (!$paymentId) {
            print("Erorr 1");
        }

        $payment = Payment::find($paymentId);
        if (!$payment || $payment->passcode_displayed) {
            print("Erorr 2");
        }

        // Mark the passcode as displayed
        $payment->update(['passcode_displayed' => true]);

        return view('passcode-success', ['passcode' => $payment->passcode]);
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
