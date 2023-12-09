<?php
namespace Packages\Threads\App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'threads_categories';
    /**
    * @var bool
    */
    public $timestamps = false;

    /**
     * @var array
    */
    protected $fillable = [
        'title',
    ];

    public static function getList(): array
    {
        return self::get()->pluck('title', 'id')->toArray();
    }
}
