<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use App\Http\Requests\Admin\UpdateTestResultRequest;
use App\Http\Requests\Admin\UploadReportRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestResultController extends Controller
{
    public function index(): View
    {
        $testResults = TestResult::with('booking')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.test-results.index', compact('testResults'));
    }

    public function update(UpdateTestResultRequest $request, TestResult $test_result): RedirectResponse
    {
        $test_result->update($request->validated());

        return back()->with('success', 'Test result status updated.');
    }

    public function upload(UploadReportRequest $request, TestResult $test_result): RedirectResponse
    {
        $file = $request->file('file');
        $filename = $test_result->registration_id . '_' . now()->timestamp . '.pdf';
        $path = $file->storeAs('test-reports', $filename, 'public');

        $url = Storage::disk('public')->url($path);
        $test_result->update([
            'result_file_url' => $url,
            'status' => 'completed',
            'report_date' => now(),
        ]);

        return back()->with('success', 'Report uploaded successfully.');
    }

    public function destroy(TestResult $test_result): RedirectResponse
    {
        if ($test_result->result_file_url) {
            $path = parse_url($test_result->result_file_url, PHP_URL_PATH);
            $path = $path ? ltrim($path, '/') : '';
            $path = str_replace('storage/', '', $path);
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $test_result->delete();

        return redirect()->route('admin.test-results.index')->with('success', 'Test result deleted.');
    }
}
