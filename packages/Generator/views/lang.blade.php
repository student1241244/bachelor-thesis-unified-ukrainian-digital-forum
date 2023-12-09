<?= '<?php'?>

return [
    'attributes' => [
@foreach($attributesLabels as $attr => $label)
        '{{ $attr }}' => '{{ $label }}',
@endforeach
    ],
    'description' => [
    ],
    'title' => [
        'menu' => '{{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNamePlural))) }}',
        'index' => '{{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNamePlural))) }} List',
        'create' => 'Creating {{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }}',
        'edit' => 'Updating {{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }}',
    ],
    'breadcrumbs' => [
        'index' => '{{ $packageName }} -> {{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNamePlural))) }}',
        'create' => 'Creating {{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }}',
        'update' => 'Updating {{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }}',
    ],
    'successfully' => [
        'created' => '{{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }} was successfully deleted',
        'updated' => '{{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }} was successfully updated',
        'deleted' => '{{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }} was successfully deleted',
    ],
    'btn' => [
        'add' => 'Create {{ \Illuminate\Support\Str::title(str_replace('_', ' ', \Illuminate\Support\Str::snake($modelNameSingular))) }}',
        'edit' => 'Edit',
        'delete' => 'delete',
    ],
];
