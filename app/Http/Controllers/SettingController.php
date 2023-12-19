<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;
use Packages\Warnings\App\Models\Warning;

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

    public function destroy(int $id)
    {
        if (auth()->check()) {
            $warning = Warning::query()
                ->where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();

            if ($warning) {
                $warning->delete();
            }
        }

        return redirect()->back();
    }
}
