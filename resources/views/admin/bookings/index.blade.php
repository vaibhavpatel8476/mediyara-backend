@extends('admin.layout')

@section('title', 'Bookings')
@section('header_title', 'Bookings')

@section('content')
    <div class="page-header">
        <h1>Bookings</h1>
        <p>Manage patient bookings and update status</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>All Bookings</h2>
        </div>
        <div class="card-body">
            @if($bookings->isEmpty())
                <p style="text-align:center; color:#64748b;">No bookings found.</p>
            @else
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Reg ID</th>
                                <th>Patient</th>
                                <th>Test</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td style="font-family:monospace; font-size:0.875rem;">{{ $booking->registration_id }}</td>
                                    <td>
                                        <div>{{ $booking->patient_name }}</div>
                                        <div style="font-size:0.875rem; color:#64748b;">{{ $booking->patient_email }}</div>
                                    </td>
                                    <td>{{ $booking->test_type }}</td>
                                    <td>
                                        {{ $booking->preferred_date->format('M d, Y') }}
                                        <div style="font-size:0.875rem; color:#64748b;">{{ $booking->preferred_time }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status }}">{{ $booking->status }}</span>
                                    </td>
                                    <td>
                                        <div class="flex gap-2 flex-wrap items-center">
                                            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" id="status-{{ $booking->id }}" value="{{ $booking->status }}">
                                                <select onchange="this.form.querySelector('input[name=status]').value=this.value; this.form.submit();" style="min-width:7rem;">
                                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-outline btn-sm">Details</a>
                                            @if(!$booking->testResults->count())
                                                <form action="{{ route('admin.bookings.test-result', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">Create Test Result</button>
                                                </form>
                                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Delete this booking?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            @else
                                                <span style="font-size:0.875rem; color:#64748b;">Test result exists</span>
                                                <span style="font-size:0.75rem; color:#64748b;">(delete result first to delete booking)</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
