@extends('layout')

@section('title', 'User Management')

@section('content')
<h2>Total Users ({{ count($users) }})</h2>
<a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">➕ Add New User/Admin</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered text-center">
    <thead>
        <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td><td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>{{ ucfirst($user->status) }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline-block;" onsubmit="return confirm('Confirm delete?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">🗑️ Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
