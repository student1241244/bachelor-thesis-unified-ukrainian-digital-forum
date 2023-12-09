<?= '<?php'?>

namespace {{ $packageName }}\Controllers;

@foreach($uses as $use)
use {!! $use !!};
@endforeach

class {{ $modelName }}Controller extends BaseController
{
    /**
     * @param {{ $modelName }}DataTableService $dataTable
     * @return mixed
     */
    public function index({{ $modelName }}DataTableService $dataTable)
    {
        return $dataTable->render('tpx_dashboard::dashboard.index');
    }
@if ($actionCreate)

    /**
     * @param {{ $modelName }} ${{ $modelNameVar }}
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create({{ $modelName }} ${{ $modelNameVar }})
    {
        $locCfg = $this->locCfg(${{ $modelNameVar }});

        return view('tpx_dashboard::dashboard.form', compact('locCfg', '{{ $modelNameVar }}'));
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        ${{ $modelNameVar }} = {{ $modelName }}::create($request->validated());

@foreach($imageAttributes as $attr)
        if($request->hasFile('{{ $attr }}')) {
            ${{ $modelNameVar }}->addMediaFromRequest('{{ $attr }}')->toMediaCollection('{{ $attr }}');
        }

@endforeach
        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }
@endif
@if ($actionUpdate)

    /**
     * @param {{ $modelName }} ${{ $modelNameVar }}
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit({{ $modelName }} ${{ $modelNameVar }})
    {
        if ($this->hasRecordProtected(${{ $modelNameVar }}, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg(${{ $modelNameVar }});

        return view('tpx_dashboard::dashboard.form', compact( 'locCfg', '{{ $modelNameVar }}'));
    }

    /**
     * @param {{ $modelName }} ${{ $modelNameVar }}
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update({{ $modelName }} ${{ $modelNameVar }}, FormRequest $request)
    {
        if ($this->hasRecordProtected(${{ $modelNameVar }}, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        ${{ $modelNameVar }}->update($request->validated());

@foreach($imageAttributes as $attr)
        if($request->hasFile('{{ $attr }}')) {
            ${{ $modelNameVar }}->addMediaFromRequest('{{ $attr }}')->toMediaCollection('{{ $attr }}');
        }

@endforeach
        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }
@endif
@if ($actionShow)

    /**
    * @param {{ $modelName }} ${{ $modelNameVar }}
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function show({{ $modelName }} ${{ $modelNameVar }})
    {
        return view('tpx_dashboard::dashboard.show', compact('{{ $modelNameVar }}'));
    }
@endif
@if ($actionDestroy)

    /**
     * @param {{ $modelName }} ${{ $modelNameVar }}
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy({{ $modelName }} ${{ $modelNameVar }})
    {
        if ($this->hasRecordProtected(${{ $modelNameVar }}, 'destroy')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        ${{ $modelNameVar }}->delete();

        flash()->success($this->getSuccessMessage('deleted'));

        return redirect()->route($this->getIndexRouteName());
    }
@endif
}
