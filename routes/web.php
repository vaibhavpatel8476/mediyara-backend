<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\TestResultController as AdminTestResultController;
use App\Http\Controllers\Admin\UserController as AdminUserListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
        Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
        Route::post('bookings/{booking}/test-result', [AdminBookingController::class, 'createTestResult'])->name('bookings.test-result');

        Route::get('test-results', [AdminTestResultController::class, 'index'])->name('test-results.index');
        Route::patch('test-results/{test_result}', [AdminTestResultController::class, 'update'])->name('test-results.update');
        Route::post('test-results/{test_result}/upload', [AdminTestResultController::class, 'upload'])->name('test-results.upload');
        Route::delete('test-results/{test_result}', [AdminTestResultController::class, 'destroy'])->name('test-results.destroy');

        Route::get('enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('users', [AdminUserListController::class, 'index'])->name('users.index');

        Route::get('admins', [AdminUserController::class, 'index'])->name('admins.index');
        Route::post('admins', [AdminUserController::class, 'store'])->name('admins.store');
        Route::delete('admins/{admin}', [AdminUserController::class, 'destroy'])->name('admins.destroy');
    });
});
