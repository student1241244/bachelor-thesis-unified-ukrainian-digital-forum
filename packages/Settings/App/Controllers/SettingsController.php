<?php

namespace Packages\Settings\App\Controllers;

use App\Models\Setting;
use Packages\Dashboard\App\Controllers\BaseController;
use Packages\Settings\App\Models\Settings;
use Packages\Settings\App\Requests\Settings\IndexRequest;
use Packages\Settings\App\Services\Crud\SettingsCrudService;
use Packages\Settings\App\Requests\Settings\FormRequest;

class SettingsController extends BaseController
{
    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function index(IndexRequest $request)
    {
        $formView = 'settings.custom';
        $settings = Setting::pluck('setting_status', 'setting_name');
        return view('tpx_dashboard::dashboard.index_simple', get_defined_vars());
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

    /**
     * @param Settings $settings
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Settings $settings, FormRequest $request)
    {
        if ($this->hasRecordProtected($settings, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        (new SettingsCrudService)->update($settings, $request->validated());

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Settings $settings
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Settings $settings)
    {
        if ($this->hasRecordProtected($settings, 'destroy')) {
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        (new SettingsCrudService)->delete($settings);

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }
}
