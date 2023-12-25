<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PasscodeFeaturesController extends Controller
{
    private function validatePasscode() {
        $passcodeSession = session('passcode_data');
        if (!$passcodeSession || empty($passcodeSession['value']) || empty($passcodeSession['activated_at'])) {
            return false;
        }
    
        if (now()->diffInMinutes($passcodeSession['activated_at']) > 120) {
            return false;
        }
    
        $secureToken = $passcodeSession['secure_token'] ?? null;
        if (!$secureToken) {
            return false;
        }
    
        $payment = Payment::where('secure_token', $secureToken)->where('status', 'completed')->first();
        if (!$payment) {
            return false;
        }

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
