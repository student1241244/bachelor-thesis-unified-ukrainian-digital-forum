<?php

namespace Packages\Dashboard\App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /*
     * @var string
     */
    public $table = 'password_resets';

    /**
     * @var string
     */
    protected $primaryKey = 'email';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'token',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }
}
