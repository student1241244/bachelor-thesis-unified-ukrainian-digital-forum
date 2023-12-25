<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PasscodeFeaturesController extends Controller
{
    private function validatePasscode() {
        $passcodeSession = session('passcode');
        if (!$passcodeSession || empty($passcodeSession['value']) || empty($passcodeSession['activated_at'])) {
            return false;
        }
        Log::error("1", ['1' => $passcodeSession]);
        if (now()->diffInMinutes($passcodeSession['activated_at']) > 120) {
            return false;
        }
        Log::error("2", ['2' => '2']);
        $secureToken = $passcodeSession['secure_token'] ?? null;
        if (!$secureToken) {
            return false;
        }
        Log::error("3", ['3' => $secureToken]);
        $payment = Payment::where('secure_token', $secureToken)->where('status', 'completed')->first();
        if (!$payment) {
            return false;
        }
        Log::error("4", ['4' => $payment]);
        return true;
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
