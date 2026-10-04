<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Services\Instructor\InstructorDashboardService;

class DashboardController extends Controller
{
    public function __construct(private InstructorDashboardService $dashboardService) {}

    public function index()
    {
        return view('instructor.dashboard', $this->dashboardService->stats(auth()->user()));
    }
}
