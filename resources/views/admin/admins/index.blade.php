@extends('admin.layout')

@section('title', 'Admin Users')
@section('header_title', 'Admins')

@section('content')
    <div class="page-header">
        <h1>Admin Role Management</h1>
        <p>Add or remove admin accounts. You cannot remove yourself.</p>
    </div>

    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header">
            <h2>Add New Admin</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.admins.store') }}" method="POST" style="max-width:28rem;">
                @csrf
                <label class="block" for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                <label class="block" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                <label class="block" for="password">Password</label>
                <input id="password" type="password" name="password" required>
                <label class="block" for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
                <button type="submit" class="btn btn-primary">Add Admin</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Current Administrators ({{ $admins->count() }})</h2>
        </div>
        <div class="card-body">
            @if($admins->isEmpty())
                <p style="text-align:center; color:#64748b;">No admin users found.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td>
                                    {{ $admin->email }}
                                    @if($admin->id === $currentAdminId)
                                        <span class="badge badge-pending" style="margin-left:0.25rem;">You</span>
                                    @endif
                                </td>
                                <td>{{ $admin->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($admin->id === $currentAdminId)
                                        <span style="font-size:0.875rem; color:#64748b;">Cannot remove self</span>
                                    @else
                                        <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Remove admin privileges for {{ $admin->email }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
