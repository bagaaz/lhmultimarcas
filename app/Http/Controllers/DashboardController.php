<?php

namespace App\Http\Controllers;

use App\Http\Resources\DashboardResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardResource;

    public function __construct(DashboardResource $dashboardResource)
    {
        $this->dashboardResource = $dashboardResource;
    }

    public function index(Request $request)
    {
        $period = $request->query('period', '24h');
        $data = $this->dashboardResource->getData($period);

        return view('pages.dashboard', ['data' => $data, 'period' => $period]);
    }
}
