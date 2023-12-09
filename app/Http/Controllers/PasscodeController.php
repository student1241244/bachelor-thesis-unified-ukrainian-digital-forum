<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\StripeWebhooks\ChargeSucceededJob;

class PasscodeController extends Controller
{
    public function passcodeHome()
    {
        return view('passcode.passcode-home', ['title' => 'Passcode feature']);
    }

    // public function createCheckoutSession(Request $request)
    // {
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     $session = \Stripe\Checkout\Session::create([
    //         'payment_method_types' => ['card'],
    //         'line_items' => [[
    //             'price_data' => [
    //                 'currency' => 'usd',
    //                 'product_data' => ['name' => 'Passcode'],
    //                 'unit_amount' => 1000, // price in cents
    //             ],
    //             'quantity' => 1,
    //         ]],
    //         'mode' => 'payment',
    //         'success_url' => route('passcode.success', ['token' => $uniqueKey]),
    //         'cancel_url' => route('passcode.cancel'),
    //     ]);

    //     return redirect($session->url, 303);
    // }

    public function createCheckoutSession()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Generate a unique, secure token
        $secureToken = Str::uuid();
        $price = 1000;
        // Create the Stripe Checkout session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Passcode'],
                    'unit_amount' => $price, // price in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('passcode-success', ['token' => $secureToken]),
            'cancel_url' => route('passcode-cancel'),
        ]);
        print($session);
        Log::error("SESSION", ['session' => $session]);
        // Store the Stripe session ID and the secure token in your database
        Payment::create([
            'stripe_session_id' => $session->id,
            'secure_token' => $secureToken,
            'total' => $price
        ]);

        return redirect($session->url, 303);
    }

    public function success(Request $request)
    {
        // Retrieve the token from the query parameters
        sleep(10);
        $secureToken = $request->query('token');
        Log::info('Accessing Success Page', ['token' => $secureToken]);
    
        if (!$secureToken) {
            Log::error('Error: Token not provided in Success Page');
            abort(404); // Or return a custom error view
        }
    
        // Find the payment associated with this token
        $payment = Payment::where('secure_token', $secureToken)
                          ->where('status', 'completed')
                          ->first();
    
        if (!$payment) {
            Log::error('Error: No completed payment found for the provided token', ['token' => $secureToken]);
            abort(404); // Or return a custom error view
        }
    
        // Optionally mark the passcode as displayed or invalidate the token, if necessary
        // $payment->update(['passcode_displayed' => true]); // Commented out if not needed
    
        // Return the success view with the passcode
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
