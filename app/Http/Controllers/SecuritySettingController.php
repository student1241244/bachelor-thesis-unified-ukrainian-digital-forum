<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\DiagnosticService;
use Illuminate\Support\Facades\Artisan;

class SecuritySettingController extends Controller
{
    protected $diagnosticService;

    public function __construct(DiagnosticService $diagnosticService)
    {
        $this->diagnosticService = $diagnosticService;
    }

    public function show()
    {
        $results = $this->runDiagnostics();
        $frequency = $this->showBackupSettings();

        return view('admin.settings-security', compact('results', 'frequency'));
    }

    public function runDiagnostics()
    {
        $results = [];
        $results['Database'] = $this->diagnosticService->checkDatabaseConnection();
        $results['Stripe status'] = $this->diagnosticService->checkStripe();
        $results['Composer dependencies'] = $this->diagnosticService->checkComposerDependencies();

        return $results;
    }
    
    public function toggleMaintenance()
    {
        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            $message = 'Maintenance mode disabled.';
        } else {
            Artisan::call('down', ['--redirect' => '/maintenance', '--retry' => 60]);
            $message = 'Maintenance mode enabled.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function updateBackupFrequency(Request $request)
    {
        $frequency = $request->input('backup_frequency', 'daily');
        
        Setting::setSettingBackup('backup_frequency', $frequency);
    
        return redirect()->back()->with('success', 'Backup frequency updated successfully.');
    }

    public function showBackupSettings()
    {
        $settings = Setting::pluck('setting_status', 'setting_name')->toArray();
        $frequency = $settings['backup_frequency'] ?? 'default_value';
        return $frequency;
    }    
}
