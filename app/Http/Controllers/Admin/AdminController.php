<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class AdminController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}

    public function index()
    {
        return view('admins.dashboard', $this->dashboard->adminStats());
    }
}
