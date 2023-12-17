<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Jobs\StripeWebhooks\ChargeSucceededJob;

class PasscodeController extends Controller
{
    public function passcodeHome()
    {
        return view('passcode.passcode-home', ['title' => 'Passcode feature']);
    }

    public function passcodeActivate(Request $request)
    {
        $request->validate([
            'passcode' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    
        // Retrieve all passcodes (hashed) from the database
        $payments = Payment::all();
    
        // Flag to check if passcode is found and valid
        $isValidPasscode = false;
    
        foreach ($payments as $payment) {
            // Use password_verify to check if the provided passcode matches the hashed one
            if (password_verify($request->passcode, $payment->passcode)) {
                $isValidPasscode = true;
                break; // Stop the loop as we found the valid passcode
            }
        }
    
        // Check if valid passcode is found
        if ($isValidPasscode) {
            // Check if Passcode is not expired, not used, etc.
            if ($payment->isExpired() || $payment->isUsed()) {
                return back()->with('error', 'Invalid or expired Passcode.');
            }
    
            // Embed the Passcode in the user's session
            session(['passcode' => $request->passcode]);
    
            return redirect('/')->with('success', 'Passcode activated successfully.');
        } else {
            return back()->with('error', 'Invalid Passcode.');
        }
    }    

    public function createCheckoutSession()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Generate a unique, secure token
        $secureToken = Str::uuid();
        $price = 100;
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
            'success_url' => url('/passcode/success?token=' . $secureToken . '#anchor-your-passcode'),
            'cancel_url' => route('passcode.cancel'),
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
        sleep(2);
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
        
        $rawPasscode = Cache::get('raw_passcode_for_user_' . $payment->id);
        Cache::forget('raw_passcode_for_user_' . $payment->id);
    
        if (!$payment) {
            Log::error('Error: No completed payment found for the provided token', ['token' => $secureToken]);
            abort(404); // Or return a custom error view
        }
    
        // Optionally mark the passcode as displayed or invalidate the token, if necessary
        $payment->update(['passcode_displayed' => true]); // Commented out if not needed
    
        // Return the success view with the passcode
        return view('passcode.passcode-home', ['passcode' => $rawPasscode, 'title' => 'Passcode feature']);
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
