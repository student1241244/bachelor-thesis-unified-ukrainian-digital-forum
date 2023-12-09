<?php

namespace App\Http\Controllers;


use App\Http\Requests\Report\CleanRequest;
use App\Http\Requests\Report\StoreRequest;
use App\Services\ReportService;
use Packages\Warnings\App\Models\Warning;

class WarningController extends Controller
{
    public function destroy(int $id)
    {
        if (auth()->check()) {
            $warning = Warning::query()
                ->where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();

            if ($warning) {
                $warning->delete();
            }
        }

        return redirect()->back();
    }
}
