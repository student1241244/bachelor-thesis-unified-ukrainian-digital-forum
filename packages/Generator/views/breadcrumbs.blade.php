@foreach($models as $modelName)
use Packages\{{ $packageName }}\App\Models\{{ $modelName }};
@endforeach

@foreach($modelsConfig as $modelName => $modelConfig)
@if ($modelConfig['actions']['index'])
// {{ $packageName }} > {{ $modelConfig['namePlural'] }}
Breadcrumbs::for('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('{{ $packageNameSnake }}::{{ $modelConfig['nameSnake'] }}.breadcrumbs.index'), route('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.index'));
});

@endif
@if ($modelConfig['actions']['create'])
// {{ $packageName }} > {{ $modelConfig['namePlural'] }} > Create
Breadcrumbs::for('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.create', function ($trail) {
    $trail->parent('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.index');
    $trail->push(trans('{{ $packageNameSnake }}::{{ $modelConfig['nameSnake'] }}.breadcrumbs.create'), route('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.create'));
});

@endif
@if ($modelConfig['actions']['update'])
// {{ $packageName }} > {{ $modelConfig['namePlural'] }} > Edit
Breadcrumbs::for('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.edit', function ($trail, {{ $modelName }} ${{ $modelConfig['nameCamel'] }}) {
    $trail->parent('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.index');
    $trail->push(trans('{{ $packageNameSnake }}::{{ $modelConfig['nameSnake'] }}.breadcrumbs.update') . ' #' . ${{ $modelConfig['nameCamel'] }}->id, route('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.edit', ${{ $modelConfig['nameCamel'] }}));
});

@endif
@if ($modelConfig['actions']['show'])
// {{ $packageName }} > {{ $modelConfig['namePlural'] }} > Show
Breadcrumbs::for('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.show', function ($trail, {{ $modelName }} ${{ $modelConfig['nameCamel'] }}) {
    $trail->parent('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.index');
    $trail->push(${{ $modelConfig['nameCamel'] }}->id, route('{{ $packageNameSnake }}.{{ $modelConfig['routeNameController'] }}.show', ${{ $modelConfig['nameCamel'] }}));
});

@endif
@endforeach
