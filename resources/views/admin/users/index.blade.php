@extends('admin.layout')

@section('title', 'Users')
@section('header_title', 'Users')

@section('content')
    <div class="page-header">
        <h1>Users</h1>
        <p>Registered customers (frontend users)</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>All Users ({{ $users->count() }})</h2>
        </div>
        <div class="card-body">
            @if($users->isEmpty())
                <p style="text-align:center; color:var(--text-muted);">No users yet.</p>
            @else
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ optional($user->profile)->full_name ?? $user->name }}</td>
                                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    <td>{{ optional($user->profile)->phone ?? '—' }}</td>
                                    <td style="white-space:nowrap;">{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
