<?php
namespace Packages\Threads\App\Models;

use Packages\Dashboard\App\Controllers\BaseController;
use Packages\Threads\App\Models\Category;
use Packages\Threads\App\Requests\Category\IndexRequest;
use Packages\Threads\App\Services\Crud\CategoryCrudService;
use Packages\Threads\App\Requests\Category\FormRequest;

class CategoryController extends BaseController
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
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Category $category)
    {
        $locCfg = $this->locCfg($category);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $category = (new CategoryCrudService)->store($request->validated());

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        if ($this->hasRecordProtected($category, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($category);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param Category $category
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Category $category, FormRequest $request)
    {
        if ($this->hasRecordProtected($category, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        (new CategoryCrudService)->update($category, $request->validated());

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        if ($this->hasRecordProtected($category, 'destroy')) {
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        (new CategoryCrudService)->delete($category);

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }
}
