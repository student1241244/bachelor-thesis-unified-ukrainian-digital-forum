<?php
namespace Packages\Settings\App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'settings';

    /**
     * @var array
    */
    protected $fillable = [
        'user_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
