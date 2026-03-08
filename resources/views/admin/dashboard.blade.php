@extends('admin.layout')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1>Admin Dashboard</h1>
        <p>Manage bookings, test results, and reports</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="label">Total Bookings</div>
            <div class="value">{{ $totalBookings }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Pending</div>
            <div class="value" style="color:#b45309;">{{ $pendingBookings }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Completed</div>
            <div class="value" style="color:#047857;">{{ $completedBookings }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Reports Ready</div>
            <div class="value" style="color:#0f172a;">{{ $reportsReady }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p style="margin:0 0 0.5rem;">Quick links</p>
            <div class="flex gap-4 flex-wrap">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">View Bookings</a>
                <a href="{{ route('admin.test-results.index') }}" class="btn btn-outline">View Test Results</a>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-outline">Manage Admins</a>
            </div>
        </div>
    </div>
@endsection
