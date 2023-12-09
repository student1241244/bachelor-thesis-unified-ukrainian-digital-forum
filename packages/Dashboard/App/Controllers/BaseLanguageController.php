<?php

namespace Packages\Dashboard\App\Controllers;

use Packages\Dashboard\App\Models\Language;
use Packages\Dashboard\App\Requests\Language\FormRequest;
use Packages\Dashboard\App\Services\DataTables\LanguageDataTableService;

class BaseLanguageController extends BaseController
{
    /**
     * @param LanguageDataTableService $dataTable
     * @return mixed
     */
    public function index(LanguageDataTableService $dataTable)
    {
        return $dataTable->render('tpx_dashboard::dashboard.index');
    }

    /**
     * @param Language $language
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Language $language)
    {
        $locCfg = $this->locCfg($language);

        return view('tpx_dashboard::dashboard.form', compact('locCfg', 'language'));
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $language = Language::create($request->validated());

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Language $language
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Language $language)
    {
        if ($this->hasRecordProtected($language, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($language);

        return view('tpx_dashboard::dashboard.form', compact( 'locCfg', 'language'));
    }

    /**
     * @param Language $language
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Language $language, FormRequest $request)
    {
        if ($this->hasRecordProtected($language, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $language->update($request->validated());

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Language $language
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Language $language)
    {
        if ($this->hasRecordProtected($language, 'destroy')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $language->delete();

        flash()->success($this->getSuccessMessage('deleted'));

        return redirect()->route($this->getIndexRouteName());
    }
}
