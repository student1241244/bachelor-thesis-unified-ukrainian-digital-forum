<?php
namespace Packages\Threads\App\Controllers;

use Packages\Dashboard\App\Controllers\BaseController;
use Packages\Threads\App\Models\Thread;
use Packages\Threads\App\Requests\Thread\IndexRequest;
use Packages\Threads\App\Services\Crud\ThreadCrudService;
use Packages\Threads\App\Requests\Thread\FormRequest;

class ThreadController extends BaseController
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

    /**
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Thread $thread)
    {
        $locCfg = $this->locCfg($thread);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $thread = (new ThreadCrudService)->store($request->validated());

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Thread $thread)
    {
        if ($this->hasRecordProtected($thread, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($thread);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param Thread $thread
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Thread $thread, FormRequest $request)
    {
        if ($this->hasRecordProtected($thread, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        (new ThreadCrudService)->update($thread, $request->validated());

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Thread $thread)
    {
        if ($this->hasRecordProtected($thread, 'destroy')) {
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        (new ThreadCrudService)->delete($thread);

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }
}
