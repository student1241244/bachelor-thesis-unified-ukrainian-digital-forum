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
    
        $payments = Payment::all();
        $isValidPasscode = false;
        $validPayment = null;
    
        foreach ($payments as $payment) {
            if (password_verify($request->passcode, $payment->passcode)) {
                $isValidPasscode = true;
                $validPayment = $payment;
                break;
            }
        }
    
        if ($isValidPasscode) {
            if ($validPayment->isExpired()) {
                return redirect('/passcode')->with('error', 'Invalid or expired Passcode.');
            }
            session([
                'passcode' => [
                    'value' => $request->passcode,
                    'activated_at' => now(),
                    'theme' => 'light',
                    'secure_token' => $validPayment->secure_token
                ]
            ]);
    
            return redirect('/threads-home')->with('success', 'Passcode activated successfully.');
        } else {
            return back()->with('error', 'Invalid Passcode.');
        }
    }    

    public function createCheckoutSession()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Generate a unique, secure token
        $secureToken = Str::uuid();
        $price = 4000;
        // Create the Stripe Checkout session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'uah',
                    'product_data' => ['name' => 'Passcode - 1 month'],
                    'unit_amount' => $price, // price in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/passcode/success?token=' . $secureToken . '#pc'),
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
        $secureToken = $request->query('token');
        Log::info('Accessing Success Page', ['token' => $secureToken]);
    
        if (!$secureToken) {
            Log::error('Error: Token not provided in Success Page');
            return redirect()->route('passcode.cancel');
        }
    
        $startTime = time();
        $timeout = 30;
        $interval = 2;
    
        while (time() - $startTime < $timeout) {
            $payment = Payment::where('secure_token', $secureToken)->first();
    
            if ($payment && $payment->status == 'completed') {
                $rawPasscode = Cache::get('raw_passcode_for_user_' . $payment->id);
                Cache::forget('raw_passcode_for_user_' . $payment->id);
    
                $payment->update(['passcode_displayed' => true]);
    
                return view('passcode.passcode-home', ['passcode' => $rawPasscode, 'title' => 'Passcode feature']);
            }
    
            sleep($interval);
        }
    
        Log::error('Payment not completed in time', ['token' => $secureToken]);
        return redirect()->route('passcode.cancel');
    }    

    public function cancel()
    {
        return redirect('/')->with('error', 'We regret to inform you that an error occurred during the payment transaction. Should there be any deduction from your account without successful completion of the transaction, and if the amount has not been automatically refunded, please do not hesitate to reach out to us at info@lemyk.com for assistance or via our Support page.');
    }

    public function handleWebhook(Request $request)
    {
        print("success +");
    }
}
