<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PasscodeFeaturesController extends Controller
{
    private function validatePasscode() {
        $passcodeSession = session('passcode');
        if (!$passcodeSession) {
            return false;
        }
        Log::error("PASSCODE ACTIVATION", ['0' => '0']);
        $rawPasscode = $passcodeSession['value'] ?? null;
        Log::error("PASSCODE", ['PASSCODE' => $rawPasscode]);
        if (!$rawPasscode) {
            return false;
        }
        Log::error("PASSCODE ACTIVATION", ['0.1' => '0.1']);
        $payment = Payment::where('status', 'completed')->first();
        if ($payment && password_verify($rawPasscode, $payment->passcode)) {
            Log::error("PASSCODE ACTIVATION", ['1' => '1']);
            $activatedAt = $passcodeSession['activated_at'] ?? null;
            Log::error("PASSCODE ACTIVATION", ['2' => '2']);
            if (!$activatedAt || now()->diffInMinutes($activatedAt) > 120) {
                Log::error("PASSCODE ACTIVATION", ['3' => '3']);
                return false;
            }
            return true;
        }
        Log::error("PASSCODE ACTIVATION", ['4' => '4']);
        return false;
    }
    
    public function switchTheme(Request $request)
    {
        if ($this->validatePasscode()) {
            $theme = $request->input('theme');
            session([
                'passcode' => array_merge(session('passcode', []), ['theme' => $theme])
            ]);
    
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
