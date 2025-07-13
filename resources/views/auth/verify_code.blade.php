<!-- resources/views/auth/verify_code.blade.php -->
@extends('layout')

@section('content')
<h3>Verify your email</h3>
<p>We have sent a code to your email: <strong>{{ $email }}</strong></p>

<form action="{{ route('register.complete') }}" method="POST">
    @csrf
    <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">
    <label>Enter Verification Code:</label>
    <input type="text" name="code" required>
    <button type="submit">Verify & Register</button>
</form>

@endsection
