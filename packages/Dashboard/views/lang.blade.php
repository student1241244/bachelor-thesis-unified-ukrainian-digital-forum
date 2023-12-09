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
        'menu' => '{{ $modelNamePlural }}',
        'index' => 'List {{ $modelNamePlural }}',
        'create' => 'Creating {{ strtolower($modelNameSingular )}}',
        'edit' => 'Updating {{ strtolower($modelNameSingular )}}',
    ],
    'breadcrumbs' => [
        'index' => '{{ $modelNamePlural }}',
        'create' => 'Creating {{ strtolower($modelNameSingular )}}',
        'update' => 'Updating {{ strtolower($modelNameSingular )}}',
    ],
    'btn' => [
        'add' => 'Create {{ strtolower($modelNameSingular )}}',
        'edit' => 'Edit',
        'delete' => 'delete',
    ],
    'successfully' => [
        'created' => '{{ $modelNameSingular }} was successfully deleted',
        'updated' => '{{ $modelNameSingular }} was successfully updated',
        'deleted' => '{{ $modelNameSingular }} was successfully deleted',
    ],
];
