<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show()
    {
        $settings = Setting::pluck('setting_status', 'setting_name');
        return view('test-settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = ['user_registration_enabled', 'content_creation_enabled'];
    
        foreach ($keys as $key) {
            $value = $request->input($key, 'off');
            Setting::setSetting($key, $value);
        }
    
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
