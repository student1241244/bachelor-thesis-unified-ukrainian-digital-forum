<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'website_settings';

    protected $fillable = ['setting_name', 'setting_status'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public static function setSetting($key, $value)
    {
        $value = $value === 'on' ? 'on' : 'off';
        self::updateOrCreate(['setting_name' => $key], ['setting_status' => $value]);
    }
}
