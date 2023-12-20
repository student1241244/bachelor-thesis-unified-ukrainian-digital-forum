<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    public $new_password;

    /**
     * @var array
     */
    protected $conversions = [
        'image' => ['100x100'],
    ];

    /**
     * @var array
     */
    protected $mediaRules = [
        'image' => [
            'max_size' => '10M',
            'min_width' => '100',
            'min_height' => '100',
            'mimes' => 'jpg,jpeg,png',
        ],
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'email',
        'password',
        'username',
        'is_admin',
        'ban_to'
    ];

    protected function avatar(): Attribute {
        return Attribute::make(get: function($value) {
            return $value ? '/storage/avatars/' . $value : '/standard-avatar.jpg';
        });
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checkIsBan()
    {
        if ($this->ban_to && strtotime($this->ban_to) > strtotime('now')) {
            return true;
        }
        return false;
    }

    public function feedQuestions() {
        return $this->hasManyThrough(Question::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser');
    }

    public function bookmarkQuestions()
    {
        return $this->belongsToMany(Question::class, 'questions_bookmark', 'user_id', 'question_id');
    }

    public function followers() {
        return $this->hasMany(Follow::class, 'followeduser');
    }

    public function following() {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function questions() {
        return $this->hasMany(Question::class, 'user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function favourites() {
        return $this->hasMany(Favourites::class, 'user_id');
    }
}
