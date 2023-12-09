<?php

namespace Packages\Dashboard\App\Controllers;

use Illuminate\Http\JsonResponse;
use Packages\Dashboard\App\Models\Language;
use Packages\Dashboard\App\Models\Translation;
use Packages\Dashboard\App\Requests\Translation\FormRequest;
use Packages\Dashboard\App\Requests\Translation\IndexFilter;
use Packages\Dashboard\App\Services\Translation\TranslationService;
use Illuminate\Support\Facades\Artisan;
use Packages\Pages\App\Models\Page;

class TranslationController extends BaseController
{
    /**
     * @param IndexFilter $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(IndexFilter $request)
    {
        if ($request->ajax()) {
            return $request->getData();
        }

        return view('tpx_dashboard::dashboard.index', get_defined_vars());
    }

    /**
     * @param Translation $translation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function edit(Translation $translation)
    {
        $locCfg = $this->locCfg((new Page()));

        return view('tpx_dashboard::dashboard.form', get_defined_vars());
    }


    /**
     * @param Translation $translation
     * @param FormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Translation $translation, FormRequest $request)
    {
        $translation->update($request->all());
        Artisan::call('cache:clear');

        flash()->success($this->getSuccessMessage('updated'));

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * @param ImportRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function import(ImportRequest $request)
    {
        (new TranslationService)->import($request->file->getPathname());

        return response([
            'message' => trans('dashboard::translation.successfully.imported'),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        return response()->streamDownload(function () {

            $fh = \fopen('php://output', 'wb');
            $head = [
                'Group',
                'Key',
                'Note',
            ];

            $locales = Language::getList();

            foreach ($locales as $locale => $localeTitle) {
                $head[] = $locale;
            }
            fputcsv($fh, $head);

            $blankRow = array_flip($head);
            $blankRow = array_map(function ($value) { return ''; }, $blankRow);

            foreach (Translation::get() as $i => $row) {
                $data = $blankRow;
                $data['Group'] = $row->group;
                $data['Key'] = $row->key;
                $data['Note'] = $row->note;

                foreach ($row->text as $lang => $text) {
                    if (isset($locales[$lang])) {
                        $data[$lang] = $text;
                    }
                }
                fputcsv($fh, $data);
            }
            flush();
            fclose($fh);

        }, 'translations.csv');
    }
}
