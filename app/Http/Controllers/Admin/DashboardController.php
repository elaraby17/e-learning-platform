<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminDashboardService;

class DashboardController extends Controller
{
    public function __construct(private AdminDashboardService $dashboardService) {}

    public function index()
    {
        return view('admins.dashboard', $this->dashboardService->stats());
    }
}
