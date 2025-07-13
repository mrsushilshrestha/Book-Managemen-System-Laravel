@extends('layout')

@section('title', 'Edit User')

@section('content')
<h2>Edit User</h2>

<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf @method('PUT')
    <input name="name" class="form-control mb-2" value="{{ $user->name }}" required>
    <input name="email" type="email" class="form-control mb-2" value="{{ $user->email }}" required>
    <input name="password" type="password" class="form-control mb-2" placeholder="New Password (optional)">

    <select name="role" class="form-select mb-2" required>
        <option value="user" @selected($user->role === 'user')>User</option>
        <option value="admin" @selected($user->role === 'admin')>Admin</option>
    </select>

    <select name="status" class="form-select mb-3" required>
        <option value="active" @selected($user->status === 'active')>Active</option>
        <option value="inactive" @selected($user->status === 'inactive')>Inactive</option>
    </select>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
