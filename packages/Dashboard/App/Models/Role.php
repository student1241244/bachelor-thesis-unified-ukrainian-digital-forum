<?php

namespace Packages\Dashboard\App\Models;

use Illuminate\Database\Eloquent\Model;
use Packages\Dashboard\App\Services\Search\SearchableContract;
use Packages\Dashboard\App\Services\Search\SearchableTrait;
use Packages\Dashboard\App\Traits\Sluggable;

class Role extends Model implements SearchableContract
{
    use Sluggable, SearchableTrait;

    const SLUG_ADMIN = 'admin';
    const SLUG_USER = 'user';
    const SLUG_MODERATOR = 'moderator';

    protected $fillable = [
        'title',
        'slug',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    /**
     * @return array
     */
    public function searchableAttributes(): array
    {
        return ['title', 'slug'];
    }

    /**
     * @return User
     */
    public static function getAdmin(): self
    {
        return self::query()->where('slug', self::SLUG_ADMIN)->first();
    }

    public static function getUser(): self
    {
        return self::query()->where('slug', self::SLUG_USER)->first();
    }

    public static function getModerator(): self
    {
        return self::query()->where('slug', self::SLUG_MODERATOR)->first();
    }

    public static function getList(): array
    {
        return self::query()->get()->pluck('title', 'id')->toArray();
    }
}
