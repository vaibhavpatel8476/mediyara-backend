<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TestResult;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $reportsReady = TestResult::where('status', 'completed')->count();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'completedBookings',
            'reportsReady'
        ));
    }
}
