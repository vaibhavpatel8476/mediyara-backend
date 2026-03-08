<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TestResult;
use App\Http\Requests\Admin\UpdateBookingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with('testResults')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load('testResults');

        return view('admin.bookings.show', compact('booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $booking->update($request->validated());

        return back()->with('success', 'Booking status updated.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        if ($booking->testResults()->exists()) {
            return back()->with('error', 'Cannot delete booking: it has a linked test result. Delete the test result first.');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted.');
    }

    public function createTestResult(Booking $booking): RedirectResponse
    {
        if ($booking->testResults()->exists()) {
            return back()->with('error', 'A test result already exists for this booking.');
        }

        TestResult::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'registration_id' => $booking->registration_id,
            'test_name' => $booking->test_type,
            'status' => 'processing',
        ]);

        return back()->with('success', 'Test result created. You can now upload the report.');
    }
}
