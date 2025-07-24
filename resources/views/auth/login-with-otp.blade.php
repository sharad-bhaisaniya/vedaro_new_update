@extends('layouts.main')

@section('title', 'Login with OTP')

@section('content')
@if(session('error'))
    <div class="error-message">
        {{ session('error') }}
        @if(config('app.debug'))
            <div class="debug-info" style="margin-top: 10px; font-size: 12px; color: #666;">
                Debug Info: {{ session('debug_error') }}
            </div>
        @endif
    </div>
@endif
<div class="user_login_form">
    <h2>Login with WhatsApp OTP</h2>
    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('send-otp') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" name="phone" class="form-control" required 
                   placeholder="Enter your registered phone number" 
                   value="{{ old('phone') }}">
            <small class="form-text text-muted">
                Enter the phone number registered with your account (with country code)
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Send OTP via WhatsApp</button>
    </form>

    <div class="auth-links mt-3">
        <a href="{{ route('login') }}">Login with Email</a> | 
        <a href="{{ route('register') }}">Create new account</a>
    </div>
</div>
@endsection