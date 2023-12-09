<?= '<?php'?>

namespace Packages\{{ $packageName }}\App\Controllers;

@foreach($uses as $use)
use {!! $use !!};
@endforeach

class {{ $modelName }}Controller extends BaseController
{
    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function index(IndexRequest $request)
    {
        if ($request->ajax()) {
            return $request->getData();
        }

        return view('tpx_dashboard::dashboard.index', get_defined_vars());
    }
@if ($actionCreate)

    /**
     * @param {{ $modelName }} ${{ $modelNameVar }}
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create({{ $modelName }} ${{ $modelNameVar }})
    {
        $locCfg = $this->locCfg(${{ $modelNameVar }});

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        ${{ $modelNameVar }} = (new {{ $modelName }}CrudService)->store($request->validated());

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

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
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

        (new {{ $modelName }}CrudService)->update(${{ $modelNameVar }}, $request->validated());

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
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        (new {{ $modelName }}CrudService)->delete(${{ $modelNameVar }});

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }
@endif
}
