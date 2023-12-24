<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Mail;

class ContactController extends Controller
{
    public function sendContactMail(Request $request)
    {
        $data = $request->only('name', 'email', 'message');
        
        Mail::to('hebamit665@dabeixin.com')->send(new ContactMail($data));

        return back()->with('success', 'Thank you for your message!');
    }
}
