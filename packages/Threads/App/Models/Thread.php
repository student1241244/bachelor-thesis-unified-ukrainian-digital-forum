<?php
namespace Packages\Threads\App\Models;

use Illuminate\Database\Eloquent\Model;
use Packages\Dashboard\App\Interfaces\HasMedia;
use Packages\Dashboard\App\Traits\HasMediaTrait;

class Thread extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'threads';

    /*
    * @var array
    */
	protected $conversions = [
		'image' => [
			'100x100',
			'590x300',
		],
	];

    /**
     * @var array
    */
    protected $fillable = [
        'category_id',
        'title',
        'body',
        'report_count',
        'report_data',
        'is_passcode_user'
    ];

    protected $casts = [
        'report_data' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
