<?php

namespace Packages\Dashboard\App\Controllers;

use Illuminate\Http\Request;
use Packages\Dashboard\App\Services\Config\ConfigService;

class DashboardController extends BaseController
{
    /**
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $formView = 'dashboard.statistic';
        return view('tpx_dashboard::dashboard.index_simple', get_defined_vars());
    }
}
