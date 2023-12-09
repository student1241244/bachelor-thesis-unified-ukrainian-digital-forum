<?php

namespace App\Http\Controllers;


use App\Http\Requests\Report\CleanRequest;
use App\Http\Requests\Report\StoreRequest;
use App\Services\ReportService;

class ReportController extends Controller
{
    public function store(StoreRequest $request)
    {
        (new ReportService)->addReport(
            $request->input('type'),
            $request->input('id'),
            $request->input('reason')
        );

        return response()->json([
            'message' => 'Report was successfully sent!',
        ]);
    }

    public function clean(CleanRequest $request)
    {
        (new ReportService)->cleanReport(
            $request->input('type'),
            $request->input('id')
        );

        return response()->json([
            'message' => 'Report was successfully cleaned!',
        ]);
    }
}
