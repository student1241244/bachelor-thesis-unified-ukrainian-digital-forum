<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PasscodeFeaturesController extends Controller
{
    private function validatePasscode() {
        $rawPasscode = session('passcode');
        if (!$rawPasscode) {
            return false;
        }
        $payment = Payment::where('status', 'completed')->first();
        if ($payment && password_verify($rawPasscode, $payment->passcode)) {
            $activatedAt = $passcodeSession['activated_at'] ?? null;
            if (!$activatedAt || now()->diffInMinutes($activatedAt) > 120) {
                return false;
            }
            return true;
        }

        return false;
    }
    
    public function switchTheme(Request $request)
    {
        if ($this->validatePasscode()) {
            $theme = $request->input('theme');
            session(['theme' => $theme]);
    
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
