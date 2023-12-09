<?php

/**
 * @package     Dashboard
 * @version     0.1.0
 * @author      LLC Studio <hello@digitalp.co>
 * @license     MIT
 * @copyright   2015, LLC
 * @link        https://digitalp.com
 */

namespace Packages\Dashboard\App\Services\Auth;

use Packages\Dashboard\App\Mail\Auth\ActivationEmail;
use Packages\Dashboard\App\Models\User;
use Packages\Dashboard\App\Services\Base\BaseService;

class AuthService extends BaseService
{
    /**
     * Get active user.
     *
     * @return mixed
     */
    public function getActiveUser()
    {
        return auth()->user();
    }

    /**
     * Check if user is logged in.
     *
     * @return mixed
     */
    public function check()
    {
        return auth()->check();
    }

    /**
     * Register and activate user if activations are false.
     *
     * @param array $data
     * @param bool $validate
     *
     * @return User
     */
    public function registerAndActivate(array $data, $validate = false)
    {
        $this->validation($data, $validate);

        $user = $this->createUser($data);

        if (config('tpx_dashboard.activations') && !session()->has('invite')) {
            $this->sendActivationEmail($user);
        }

        return $user;
    }

    protected function createUser(array $data)
    {
        $user = User::create($data);

        $user->active = !config('tpx_dashboard.activations');
        $user->activation_token = config('tpx_dashboard.activations') ? str_random(60) : null;

        $user->save();

        return $user;
    }

    protected function validation(array $data, $validate = true)
    {
        $this->rules = [
            'email'                 => 'required|unique:users',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ];

        if ($validate) {
            $this->validate($data);
        }
    }

    protected function sendActivationEmail($user)
    {
        \Mail::to($user->email)->send(new ActivationEmail($user));
    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}
