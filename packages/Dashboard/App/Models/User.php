<?php

namespace Packages\Dashboard\App\Models;

use App\Models\Question;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Packages\Dashboard\App\Interfaces\HasMedia;
use Packages\Dashboard\App\Services\Search\SearchableContract;
use Packages\Dashboard\App\Services\Search\SearchableTrait;
use Packages\Dashboard\App\Traits\HasMediaTrait;
use Packages\Dashboard\App\Traits\HasPermissionsTrait;

class User extends Authenticatable implements HasMedia, SearchableContract
{
    use HasPermissionsTrait, Notifiable, HasMediaTrait, SearchableTrait;

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
        'ban_to',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function activate()
    {
        return $this->update([
            'activation_token' => null,
        ]);
    }

    /**
     * Set the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->new_password = $value;
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo('Packages\Dashboard\App\Models\Role');
    }

    /**
     * @return array
     */
    public function searchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public function bookmarkQuestions()
    {
        return $this->belongsToMany(Question::class, 'questions_bookmark', 'user_id', 'question_id');
    }

    public static function getList()
    {
        return self::select('id', 'email')->get()->pluck('email', 'id')->toArray();
    }

    public function checkIsBan()
    {
        if ($this->ban_to && strtotime($this->ban_to) > strtotime('now')) {
            return true;
        }
        return false;
    }
}
