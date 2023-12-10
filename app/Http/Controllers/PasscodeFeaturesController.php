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
    
        // Retrieve the hashed passcode from the database
        $payment = Payment::where('status', 'completed')->first();
    
        // Assuming the hashed passcode is stored in a column named 'passcode'
        if ($payment && password_verify($rawPasscode, $payment->passcode)) {
            return true;
        }
    
        return false;
    }
    
    public function switchTheme(Request $request)
    {
        $passcode = session('passcode');
        
        if ($this->validatePasscode($passcode) == True) {
            $theme = $request->input('theme');

            // Optionally, update session with the selected theme
            session(['theme' => $theme]);

            return response()->json(['success' => true]);
        
        } else {
            return response()->json(['success' => true]);
        }
    }
    
}
