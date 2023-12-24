<?php

namespace Packages\Settings\App\Controllers;

use App\Models\Setting as AppSetting;
use Packages\Dashboard\App\Controllers\BaseController;
use Packages\Settings\App\Models\Settings;
use Packages\Settings\App\Requests\Settings\IndexRequest;
use Packages\Settings\App\Services\Crud\SettingsCrudService;
use Packages\Settings\App\Requests\Settings\FormRequest;
use Illuminate\Http\Request;
use App\Services\DiagnosticService;
use Illuminate\Support\Facades\Artisan;
use Packages\Warnings\App\Models\Warning;

class SettingsController extends BaseController
{
    protected $diagnosticService;

    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function index(IndexRequest $request)
    {
        $formView = 'settings.custom';
        $settings = AppSetting::pluck('setting_status', 'setting_name');
        $results = $this->runDiagnostics();
        $frequency = $this->showBackupSettings();

        return view('tpx_dashboard::dashboard.index_simple', get_defined_vars());
    }

    public function runDiagnostics()
    {
        $diagnosticService = new DiagnosticService();
        $this->diagnosticService = $diagnosticService;

        $results = [];
        $results['Database'] = $this->diagnosticService->checkDatabaseConnection();
        $results['Stripe status'] = $this->diagnosticService->checkStripe();
        $results['Composer dependencies'] = $this->diagnosticService->checkComposerDependencies();

        // Add more checks as needed

        return $results;
    }

    public function custom()
    {
        return dd('custom');
    }

    /**
     * @param Settings $settings
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Settings $settings)
    {
        $locCfg = $this->locCfg($settings);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $settings = (new SettingsCrudService)->store($request->validated());

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Settings $settings
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Settings $settings)
    {
        if ($this->hasRecordProtected($settings, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($settings);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
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
        
        AppSetting::setSettingBackup('backup_frequency', $frequency);
    
        return redirect()->back()->with('success', 'Backup frequency updated successfully.');
    }

    public function showBackupSettings()
    {
        $settings = AppSetting::pluck('setting_status', 'setting_name')->toArray();
        $frequency = $settings['backup_frequency'] ?? 'default_value'; // Replace 'default_value' with your desired default frequency
        return $frequency;
    }

    public function update(Request $request)
    {
        $keys = ['user_registration_enabled', 'content_creation_enabled'];
    
        foreach ($keys as $key) {
            $value = $request->input($key, 'off');
            AppSetting::setSetting($key, $value);
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
