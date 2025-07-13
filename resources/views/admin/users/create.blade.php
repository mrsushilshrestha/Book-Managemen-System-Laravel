@extends('layout')

@section('title', 'Register User/Admin')

@section('content')
<h2>Register New User</h2>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <input name="name" class="form-control mb-2" placeholder="Name" required>
    <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
    <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>

    <select name="role" class="form-select mb-2" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <select name="status" class="form-select mb-3" required>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>

    <button class="btn btn-primary">Create</button>
</form>
@endsection
