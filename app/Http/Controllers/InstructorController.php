<?php
// app/Http/Controllers/InstructorController.php
namespace App\Http\Controllers;

use App\Services\DashboardService;

class InstructorController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}

    public function index()
    {
        return view('instructor.dashboard', $this->dashboard->instructorStats(auth()->user()));
    }
}
