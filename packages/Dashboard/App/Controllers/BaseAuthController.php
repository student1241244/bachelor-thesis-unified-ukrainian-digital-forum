<?php

namespace Packages\Dashboard\App\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Packages\Dashboard\App\Models\{User, Role};
use Packages\Dashboard\App\Requests\Auth\LoginRequest;

class BaseAuthController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

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
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendFailedActivationResponse(Request $request)
    {
        flash()->error(trans('dashboard::auth.not_activated'));

        return redirect()->route('dashboard.login')
            ->withInput($request->only($this->username()));
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('tpx_dashboard::auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();
        $role = Role::find($user->role_id);

        if (empty($role) || !in_array($role->slug, config('tpx_dashboard.access.roles', [Role::SLUG_ADMIN]))) {
            return back()->withErrors(['email' => trans('dashboard::auth.invalid_credentials')]);
        } else {
            if ($user->checkIsBan()) {
                return back()->withErrors(['email' => 'Your account is banned. Please contact administrator.',]);
            } elseif (Auth::attempt($credentials)) {
                return redirect()->intended(route('dashboard.dashboard.index'));
            } else {
                return back()->withErrors(['email' => trans('dashboard::auth.invalid_credentials')]);
            }
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        return redirect()->route('dashboard.login');
    }
}
