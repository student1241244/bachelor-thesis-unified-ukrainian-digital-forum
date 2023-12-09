<?php
namespace Packages\Warnings\App\Controllers;

use Packages\Dashboard\App\Controllers\BaseController;
use Packages\Warnings\App\Models\Warning;
use Packages\Warnings\App\Requests\Warning\IndexRequest;
use Packages\Warnings\App\Services\Crud\WarningCrudService;
use Packages\Warnings\App\Requests\Warning\FormRequest;

class WarningController extends BaseController
{
    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function index(IndexRequest $request)
    {
        if ($request->ajax()) {
            return $request->getData();
        }

        return view('tpx_dashboard::dashboard.index', get_defined_vars());
    }

    /**
     * @param Warning $warning
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Warning $warning)
    {
        $locCfg = $this->locCfg($warning);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $warning = (new WarningCrudService)->store($request->validated());

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Warning $warning
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Warning $warning)
    {
        if ($this->hasRecordProtected($warning, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($warning);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param Warning $warning
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Warning $warning, FormRequest $request)
    {
        if ($this->hasRecordProtected($warning, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        (new WarningCrudService)->update($warning, $request->validated());

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Warning $warning
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Warning $warning)
    {
        if ($this->hasRecordProtected($warning, 'destroy')) {
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        (new WarningCrudService)->delete($warning);

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }
}
