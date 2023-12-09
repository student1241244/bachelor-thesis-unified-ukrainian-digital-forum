<?php

namespace Packages\Dashboard\App\Controllers;

use Packages\Dashboard\App\Requests\Account\{
    UpdateRequest,
    PasswordRequest
};

class BaseAccountController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user();

        $values = [];
        $old = old();
        foreach ($user->getAttributes() as $key => $val) {
            $user->$key = isset($old[$key]) ? $old[$key] : $val;
        }

        $locCfg = $this->locCfg($user);

        return view('tpx_dashboard::dashboard.form', compact( 'locCfg', 'user'));
    }

    /**
     * @param AccountUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        auth()->user()->update($request->validated());

        if(request()->hasFile('image')) {
            auth()->user()->addMediaFromRequest('image')->toMediaCollection('image');
        }
        flash()->success(trans('dashboard::account.successfully.updated'));

        return back();
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => $request->password]);

        flash()->success(trans('dashboard::account.successfully.password'));

        return back();
    }
}
