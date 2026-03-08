@extends('admin.layout')

@section('title', 'Enquiries')
@section('header_title', 'Enquiries')

@section('content')
    <div class="page-header">
        <h1>Enquiries</h1>
        <p>Contact form submissions from the website</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>All Enquiries ({{ $enquiries->count() }})</h2>
        </div>
        <div class="card-body">
            @if($enquiries->isEmpty())
                <p style="text-align:center; color:var(--text-muted);">No enquiries yet.</p>
            @else
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enquiries as $enquiry)
                                <tr>
                                    <td style="white-space:nowrap;">{{ $enquiry->created_at->format('M d, Y H:i') }}</td>
                                    <td>{{ $enquiry->name }}</td>
                                    <td><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                                    <td>{{ $enquiry->phone ?? '—' }}</td>
                                    <td>{{ $enquiry->subject }}</td>
                                    <td style="max-width:320px;">{{ Str::limit($enquiry->message, 100) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
