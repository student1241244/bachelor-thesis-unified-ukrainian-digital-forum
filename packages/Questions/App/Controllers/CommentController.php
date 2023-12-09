<?php
namespace Packages\Questions\App\Controllers;

use Packages\Dashboard\App\Controllers\BaseController;
use App\Models\Comment;
use Packages\Questions\App\Requests\Comment\IndexRequest;
use Packages\Questions\App\Services\Crud\CommentCrudService;
use Packages\Questions\App\Requests\Comment\FormRequest;

class CommentController extends BaseController
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
     * @param Comment $comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Comment $comment)
    {
        $locCfg = $this->locCfg($comment);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $comment = (new CommentCrudService)->store($request->validated());

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Comment $comment)
    {
        if ($this->hasRecordProtected($comment, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($comment);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param Comment $comment
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Comment $comment, FormRequest $request)
    {
        if ($this->hasRecordProtected($comment, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        (new CommentCrudService)->update($comment, $request->validated());

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        if ($this->hasRecordProtected($comment, 'destroy')) {
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        (new CommentCrudService)->delete($comment);

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }
}
