@extends('admin.layout')

@section('title', 'Booking ' . $booking->registration_id)
@section('header_title', 'Booking Details')

@section('content')
    <div class="page-header">
        <h1>Booking Details</h1>
        <p>Registration ID: {{ $booking->registration_id }}</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display:grid; gap:0.75rem;">
                <p style="margin:0;"><strong>Patient:</strong> {{ $booking->patient_name }}</p>
                <p style="margin:0;"><strong>Email:</strong> {{ $booking->patient_email }}</p>
                <p style="margin:0;"><strong>Phone:</strong> {{ $booking->patient_phone }}</p>
                <p style="margin:0;"><strong>Test:</strong> {{ $booking->test_type }}</p>
                <p style="margin:0;"><strong>Date & time:</strong> {{ $booking->preferred_date->format('F d, Y') }} at {{ $booking->preferred_time }}</p>
                <p style="margin:0;"><strong>Collection:</strong> {{ $booking->collection_type }}</p>
                @if($booking->address)
                    <p style="margin:0;"><strong>Address:</strong> {{ $booking->address }}</p>
                @endif
                @if($booking->notes)
                    <p style="margin:0;"><strong>Notes:</strong> {{ $booking->notes }}</p>
                @endif
                <p style="margin:0;"><strong>Status:</strong> <span class="badge badge-{{ $booking->status }}">{{ $booking->status }}</span></p>
            </div>

            <div class="flex gap-2 flex-wrap" style="margin-top:1.5rem;">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">Back to list</a>
                @if(!$booking->testResults->count())
                    <form action="{{ route('admin.bookings.test-result', $booking) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Create Test Result</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
