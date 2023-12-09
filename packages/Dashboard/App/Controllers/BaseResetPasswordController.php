<?php

namespace Packages\Dashboard\App\Controllers;

use App\Http\Controllers\Controller;
use Packages\Dashboard\App\Mail\ResetPasswordMail;
use Packages\Dashboard\App\Models\PasswordReset;
use Packages\Dashboard\App\Requests\ResetPassword\SendRequest;
use Illuminate\Support\Facades\Mail;
use Packages\Dashboard\App\Models\{Role, User};

class BaseResetPasswordController extends Controller
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
    public function index()
    {
        return view('tpx_dashboard::auth.reset_password');
    }

    /**
     * @params SendRequest $request
     * @return
     */
    public function send(SendRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $role = Role::find($user->role_id);
        if (empty($role) || !in_array($role->slug, config('tpx_dashboard.access.roles', [Role::SLUG_ADMIN]))) {
            return back()->withErrors(['email' => trans('validation.exists', ['attribute'=>'E-mail'])]);
        }

        $passwordReset = PasswordReset::firstOrCreate(
            ['email' => $request->email],
            ['email' => $request->email, 'token' => md5($request->email . time())]
        );

        Mail::to($request->email)->send(new ResetPasswordMail([
            'token' => $passwordReset->token,
        ]));

        return view('tpx_dashboard::auth.message', [
            'title' => trans('dashboard::auth.reset_title'),
            'message' => trans('dashboard::auth.password_sent'),
        ]);
    }
}
