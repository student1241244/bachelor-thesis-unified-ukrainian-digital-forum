<?php
namespace Packages\Threads\App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Packages\Threads\App\Models\Comment;
use Packages\Dashboard\App\Interfaces\HasMedia;
use Packages\Dashboard\App\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model implements HasMedia
{
    use HasMediaTrait, HasFactory;

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

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public static function getTrendingThreads()
    {
        // Get the current date and the date 7 days ago
        $currentDate = Carbon::now();
        $sevenDaysAgo = $currentDate->copy()->subDays(7);

        return Thread::withCount('comments')
            ->where('created_at', '>=', $sevenDaysAgo)
            ->orderBy('comments_count', 'desc')
            ->take(3)
            ->get();
    }
}
