<?php

namespace Packages\Dashboard\App\Controllers;

use Packages\Dashboard\App\Models\Role;
use Packages\Dashboard\App\Requests\Role\FormRequest;
use Packages\Dashboard\App\Services\DataTables\RoleDataTableService;

class BaseRoleController extends BaseController
{
    /**
     * @param RoleDataTableService $dataTable
     * @return mixed
     */
    public function index(RoleDataTableService $dataTable)
    {
        return $dataTable->render('tpx_dashboard::dashboard.index');
    }

    /**
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Role $role)
    {
        $locCfg = $this->locCfg($role);

        return view('tpx_dashboard::dashboard.form', compact('locCfg', 'role'));
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $role = Role::create($request->validated());
        $role->permissions()->sync($request->permissions);

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        if ($this->hasRecordProtected($role, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($role);

        return view('tpx_dashboard::dashboard.form', compact( 'locCfg', 'role'));
    }

    /**
     * @param Role $role
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, FormRequest $request)
    {
        if ($this->hasRecordProtected($role, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $role->update($request->validated());
        $role->permissions()->sync($request->permissions);

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        if ($this->hasRecordProtected($role, 'destroy')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $role->delete();

        flash()->success($this->getSuccessMessage('deleted'));

        return redirect()->route($this->getIndexRouteName());
    }
}
