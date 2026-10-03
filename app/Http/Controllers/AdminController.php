<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Services\DashboardService;

class AdminController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}

    public function index()
    {
        return view('admins.dashboard', $this->dashboard->adminStats());
    }
}
