<?= '<?php'?>

namespace Packages\{{ $packageName }}\App\Models;

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

@if (isset($functions['getList']))
    /**
    * @return array
    */
    public static function getList(): array
    {
@if (in_array(array_get($functions, 'getList.label', 'title'), $translatableAttributes))
        return (new self)->getListTranslatable('{{ array_get($functions, 'getList.label', 'title') }}');
@else
        return self::query()->get()->pluck('{{ array_get($functions, 'getList.label', 'title') }}', 'id')->toArray();
@endif
    }
@endif
@foreach($fields as $field)
@if ($field['type'] === \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN)
    public function {{ array_get($field, 'relation.name', \Illuminate\Support\Str::camel(\Illuminate\Support\Str::afterLast($field['relation']['class'], "\\"))) }}()
    {
        return $this->belongsTo('{{ $field['relation']['class'] }}');
    }

@endif
@endforeach
@foreach($fields as $field)
@if ($field['type'] === \Packages\Generator\App\Generators\Base::FIELD_TYPE_VS_MULTIPLE)
    public function {{ $field['name'] }}()
    {
        return $this->belongsToMany('{{ $field['relation']['class'] }}', '{{ $field['relation']['vs_table'] }}', '{{ $field['relation']['self_id'] }}', '{{ $field['relation']['rel_id'] }}');
    }

@endif
@endforeach

@endif
}
