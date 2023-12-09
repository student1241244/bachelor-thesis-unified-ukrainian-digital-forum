<?php

namespace Packages\Dashboard\App\Controllers;

use Packages\Dashboard\App\Models\User;
use App\Http\Controllers\Controller;
use Packages\Dashboard\App\Requests\SetPassword\SendRequest;
use Packages\Dashboard\App\Models\PasswordReset;

class BaseSetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        if (config('translatable.is_enabled')) {
            $this->middleware('localeSessionRedirect');
            $this->middleware('localizationRedirect');
            $this->middleware('localeViewPath');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(string $token)
    {
        return view('tpx_dashboard::auth.set_password', compact('token'));
    }

    /**
     * @param string $token
     * @param SendRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(string $token, SendRequest $request)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            abort(404);
        }

        $user = User::where('email', $passwordReset->getAttributes()['email'])->first();

        $user->password = $request->password;
        $user->save();
        $passwordReset->delete();

        auth()->login($user);

        return redirect()->route('dashboard.dashboard.index');
    }

}
