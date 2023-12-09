<?php

namespace Packages\Dashboard\App\Models;

use Illuminate\Database\Eloquent\Model;
use Packages\Dashboard\App\Services\Config\ConfigService;

class Permission extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug'
    ];
}
