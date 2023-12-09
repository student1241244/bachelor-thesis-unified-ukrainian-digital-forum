<?= '<?php'?>

namespace {{ $packageName }}\Models;

@foreach($uses as $use)
use {!! $use !!};
@endforeach

{{ $signature }}
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
@if ($imagesConversions !== '')

    /*
    * @var array
    */
{!! $imagesConversions !!}

@endif
@if (!$timestamps)
    /**
    * @var bool
    */
    public $timestamps = false;

@endif
    /**
     * @var array
    */
    protected $fillable = [
@foreach($fillable as $item)
        '{{ $item }}',
@endforeach
    ];
@if (count($translatableAttributes))

    /*
    * Translated attributes
    *
    * @var array
    */
    public $translatedAttributes = [
@foreach($translatableAttributes as $item)
        '{{ $item }}',
@endforeach
    ];
@endif
}
