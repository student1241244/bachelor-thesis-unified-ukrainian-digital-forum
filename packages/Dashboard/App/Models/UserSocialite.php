<?php

namespace Packages\Dashboard\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\User as UserProvider;

class UserSocialite extends Model
{
    public $timestamps = false;

    protected $table = 'users_socialite';

    protected $fillable = [
        'user_id',
        'provider_id',
        'provider_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param string $provider
     * @return User
     */
    public static function getUserFromProvider(string $provider,  UserProvider $userProvider): User
    {
        $user = User::where('email', $userProvider->getEmail())->first();

        $userSocialite = self::query()
            ->where('provider_name', $provider)
            ->where('provider_id', $userProvider->getId())
            ->first();

        if ($userSocialite) {
            return $userSocialite->user;
        }

        if (!$user) {
            $user = User::create([
                'email' => $userProvider->getEmail(),
                'name' => $userProvider->getName(),
                'role_id' => Role::getUser()->id,
            ]);

            if (!empty($userProvider->getAvatar())) {
                $user->addMediaFromUrl($userProvider->getAvatar())->toMediaCollection('image');
            }
        }

        UserSocialite::create([
            'user_id' => $user->id,
            'provider_id' => $userProvider->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }
}
