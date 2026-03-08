<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = TestResult::where('user_id', $request->user()->id)
            ->with('booking:id,patient_name,test_type,preferred_date')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reports);
    }

    public function show(Request $request, int $id)
    {
        $report = TestResult::where('user_id', $request->user()->id)
            ->with('booking')
            ->findOrFail($id);

        return response()->json($report);
    }
}
