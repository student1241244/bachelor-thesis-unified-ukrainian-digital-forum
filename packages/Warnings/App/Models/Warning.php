<?php
namespace Packages\Warnings\App\Models;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'warnings';

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
