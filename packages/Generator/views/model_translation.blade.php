<?= '<?php'?>

namespace Packages\{{ $packageName }}\App\Models;

@foreach($uses as $use)
use {!! $use !!};
@endforeach

class {{ $modelName }}Translation extends Model
{
@if (count($traits))
    use {!! implode(', ', $traits) !!};

@endif
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = '{{ $tableName }}';

    /**
    * @var bool
    */
    public $timestamps = false;

    /**
     * @var array
    */
    protected $fillable = [
@foreach($translatableAttributes as $item)
        '{{ $item }}',
@endforeach
    ];
}
