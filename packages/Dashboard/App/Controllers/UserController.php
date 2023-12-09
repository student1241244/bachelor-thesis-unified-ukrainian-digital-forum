<?php

namespace Packages\Dashboard\App\Controllers;

use App\Services\LogService;
use Packages\Dashboard\App\Models\Role;
use Packages\Dashboard\App\Models\User;
use Packages\Dashboard\App\Requests\User\FormRequest;
use Packages\Dashboard\App\Requests\User\IndexFilter;
use Packages\Dashboard\App\Services\DataTables\UserDataTableService;

class UserController extends BaseController
{
    /**
     * @param IndexFilter $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(IndexFilter $request)
    {
        if ($request->ajax()) {
            return $request->getData();
        }

        return view('tpx_dashboard::dashboard.index', get_defined_vars());
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        $roles = Role::get()->pluck('title', 'id')->toArray();
        $locCfg = $this->locCfg($user);

        return view('tpx_dashboard::dashboard.form', compact('locCfg', 'user', 'roles'));
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        if($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('image');
        }

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        if ($this->hasRecordProtected($user, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $roles = Role::get()->pluck('title', 'id')->toArray();
        $locCfg = $this->locCfg($user);

        return view('tpx_dashboard::dashboard.form', compact( 'locCfg', 'roles', 'user'));
    }

    /**
     * @param User $user
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, FormRequest $request)
    {
        if ($this->hasRecordProtected($user, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $user->update($request->validated());

        if($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('image');
        }

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        if ($this->hasRecordProtected($user, 'destroy')) {
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        $user->delete();

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }

}
