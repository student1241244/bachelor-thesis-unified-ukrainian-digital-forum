<?php
echo '<?php';
?>

declare( strict_types = 1 );

namespace Packages\{{ $packageName }}\App\Services\Crud;

use Packages\{{ $packageName }}\App\Models\{{ $modelName }};

/**
 * Class {{ $modelName }}CrudService
 */
class {{ $modelName }}CrudService
{
    public function store(array $data): {{ $modelName }}
    {
        ${{ $modelNameVar }} = {{ $modelName }}::create($data);
@if (count($imageAttributes))
        $this->attachMedia(${{ $modelNameVar }});
@endif
@if (count($vsMultipleFields))
        $this->syncRelations(${{ $modelNameVar }}, $data);
@endif

        return ${{ $modelNameVar }};
    }

    public function update({{ $modelName }} ${{ $modelNameVar }}, array $data): {{ $modelName }}
    {
        ${{ $modelNameVar }}->update($data);
@if (count($imageAttributes))
        $this->attachMedia(${{ $modelNameVar }});
@endif
@if (count($vsMultipleFields))
        $this->syncRelations(${{ $modelNameVar }}, $data);
@endif

        return ${{ $modelNameVar }};
    }

    public function delete({{ $modelName }} ${{ $modelNameVar }}): void
    {
        ${{ $modelNameVar }}->delete(${{ $modelNameVar }});
    }
@if (count($imageAttributes))

    public function attachMedia({{ $modelName }} ${{ $modelNameVar }})
    {
@foreach($imageAttributes as $attr)
        if(request()->hasFile('{{ $attr }}')) {
            ${{ $modelNameVar }}->addMediaFromRequest('{{ $attr }}')->toMediaCollection('{{ $attr }}');
        }
@endforeach
    }
@endif
@if (count($vsMultipleFields))

    public function syncRelations({{ $modelName }} ${{ $modelNameVar }}, array $data)
    {
@foreach($vsMultipleFields as $field)
        ${{ $modelNameVar }}->{{ $field['name'] }}()->sync(array_get($data, '{{ $field['name'] }}', []));
@endforeach
    }
@endif
}
