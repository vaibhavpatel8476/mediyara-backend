@extends('admin.layout')

@section('title', 'Test Results')
@section('header_title', 'Test Results')

@section('content')
    <div class="page-header">
        <h1>Test Results</h1>
        <p>Upload reports and manage test result status</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>All Test Results</h2>
        </div>
        <div class="card-body">
            @if($testResults->isEmpty())
                <p style="text-align:center; color:#64748b;">No test results found. Create one from a booking.</p>
            @else
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Reg ID</th>
                                <th>Test Name</th>
                                <th>Status</th>
                                <th>Report</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testResults as $result)
                                <tr>
                                    <td style="font-family:monospace; font-size:0.875rem;">{{ $result->registration_id }}</td>
                                    <td>{{ $result->test_name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $result->status }}">{{ $result->status }}</span>
                                    </td>
                                    <td>
                                        @if($result->result_file_url)
                                            <a href="{{ $result->result_file_url }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">View PDF</a>
                                        @else
                                            <span style="color:#64748b;">Not uploaded</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2 flex-wrap items-center">
                                            <form action="{{ route('admin.test-results.update', $result) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit();" style="min-width:7rem;">
                                                    <option value="processing" {{ $result->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="completed" {{ $result->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="pending" {{ $result->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                </select>
                                            </form>
                                            <form action="{{ route('admin.test-results.upload', $result) }}" method="POST" enctype="multipart/form-data" class="inline" style="display:inline-flex; align-items:center; gap:0.25rem;">
                                                @csrf
                                                <input type="file" name="file" accept=".pdf" required style="width:auto; margin:0;">
                                                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                                            </form>
                                            <form action="{{ route('admin.test-results.destroy', $result) }}" method="POST" class="inline" onsubmit="return confirm('Delete this test result and its file?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
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
