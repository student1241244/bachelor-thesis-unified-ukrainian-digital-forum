<?php
namespace Packages\Questions\App\Controllers;

use Packages\Dashboard\App\Controllers\BaseController;
use App\Models\Question;
use Packages\Questions\App\Requests\Question\IndexRequest;
use Packages\Questions\App\Services\Crud\QuestionCrudService;
use Packages\Questions\App\Requests\Question\FormRequest;

class QuestionController extends BaseController
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
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Question $question)
    {
        $locCfg = $this->locCfg($question);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $question = (new QuestionCrudService)->store($request->validated());

        flash()->success($this->getSuccessMessage('created'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Question $question)
    {
        if ($this->hasRecordProtected($question, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        $locCfg = $this->locCfg($question);

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }

    /**
     * @param Question $question
     * @param FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Question $question, FormRequest $request)
    {
        if ($this->hasRecordProtected($question, 'edit')) {
            flash()->warning(trans('dashboard::dashboard.record_protected'));
            return redirect()->route($this->getIndexRouteName());
        }

        (new QuestionCrudService)->update($question, $request->validated());

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question)
    {
        if ($this->hasRecordProtected($question, 'destroy')) {
            return response()->json(['error' => trans('dashboard::dashboard.record_protected')], 403);
        }

        (new QuestionCrudService)->delete($question);

        return response()->json(['message' => $this->getSuccessMessage('deleted')], 204);
    }
}
