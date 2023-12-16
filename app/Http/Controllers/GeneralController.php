<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function showAbout() {
        return view('general.about', ['title' => 'Passcode feature']);
    }

    public function showPrivacyPolicy() {
        return view('/general.privacy-policy');
    }

    public function showContentPolicy() {
        return view('/general.content-policy');
    }

    public function showCookiePolicy() {
        return view('/general.content-policy');
    }

    public function showContact() {
        return view('/general.contact');
    }

    public function showSupport() {
        return view('/general.support');
    }
}
