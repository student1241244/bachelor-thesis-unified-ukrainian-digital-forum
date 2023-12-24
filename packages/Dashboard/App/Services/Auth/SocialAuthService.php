<?php

namespace Packages\Dashboard\App\Services\Auth;

use Packages\Dashboard\App\Models\User;
use Packages\Dashboard\App\Services\Base\BaseService;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Media\Services\MediaService;
use Media\Models\Mediable;

class SocialAuthService extends BaseService
{
    private $driver;

    private $userPic;

    private $isNewUser = false;

    public function __construct()
    {
        $this->driver = request()->driver;
    }

    public function execute($listener)
    {
        if ($this->driver != 'vkontakte' && !request()->has('code')) {
            return $this->getAuthorizationFirst();
        }

        $user = $this->findByEmailOrCreate();

        if (!$this->isNewUser || !config('tpx_dashboard.activations')) {
            Auth::loginUsingId($user->id, true);

            return $listener->userHasLoggedIn($user);
        }

        return $listener->registerSuccess($user);
    }

    private function getAuthorizationFirst()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    private function findByEmailOrCreate()
    {
        $data = $this->getUserData();

        return $this->getUser($data);
    }

    private function getUser(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $authService = new AuthService();

            $user = $authService->registerAndActivate($data);

            $this->attachUserPic($user);

            $this->isNewUser = true;
        }

        return $user;
    }

    private function attachUserPic($user)
    {
        $media = MediaService::uploadFromExternalSource($this->userPic, 0, User::class);

        Mediable::create([
            'media_id' => $media->id,
            'mediable_id' => $user->id,
            'mediable_type' => 'Packages\Dashboard\App\Models\User'
        ]);
    }

    private function getFacebookUser($data)
    {
        $name = explode(' ', $data->name);

        $this->userPic = $data->avatar_original;

        return [
            'facebook' => $data->id,
            'name' => array_get($name, 0),
            'email' => $data->email
        ];
    }

    private function getVkontakteUser()
    {
        $authorization = file_get_contents('http://ulogin.ru/token.php?token=' . request()->token . '&host=' . $_SERVER['HTTP_HOST']);
        $data = json_decode($authorization, true);

        $this->userPic = $data['photo_big'];

        return [
            'vkontakte' => $data['uid'],
            'name' => $data['name'],
            'email' => $data['email']
        ];
    }

    private function getUserData()
    {
        $data = $this->driver == 'vkontakte' ? [] : Socialite::driver($this->driver)->user();

        $getUserFunction = 'get' . ucfirst($this->driver) . 'User';

        return $this->{$getUserFunction}($data);
    }
}
