@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2>✅ Registration Complete</h2>
        <p>Your email is now verified. You can log in below.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
    </div>
@endsection
