<?php
namespace Packages\Threads\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'threads_comments';
    /**
    * @var bool
    */

    /**
     * @var array
    */
    protected $fillable = [
        'thread_id',
        'body',
        'report_count',
        'report_data',
        'is_passcode_user'
    ];

    protected $casts = [
        'report_data' => 'array',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
