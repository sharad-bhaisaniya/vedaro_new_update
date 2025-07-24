@extends('layouts.main')

@section('title', 'Verify OTP')

@section('content')
<div class="user_login_form">
    <h2>Verify OTP</h2>
    
    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif
    
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <p>We've sent a 6-digit OTP to your WhatsApp number ending with 
    <strong>{{ substr(Session::get('otp_phone'), -4) }}</strong>.</p>
    
    <p>This code will expire in 10 minutes.</p>

    <form action="{{ route('verify-otp') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="otp">Enter 6-digit OTP:</label>
            <input type="text" name="otp" id="otp" class="form-control" required 
                   placeholder="Enter OTP sent to your WhatsApp"
                   maxlength="6" pattern="\d{6}" inputmode="numeric">
        </div>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>

    <div class="mt-3">
        <form action="{{ route('resend-otp') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link p-0">Didn't receive OTP? Resend</button>
        </form>
    </div>
    
    @if(Session::has('registration_data'))
        <div class="mt-3">
            <p>Registering new account with:</p>
            <ul>
                <li>Name: {{ Session::get('registration_data.name') }}</li>
                <li>Phone: {{ Session::get('registration_data.phone') }}</li>
                @if(Session::get('registration_data.email'))
                    <li>Email: {{ Session::get('registration_data.email') }}</li>
                @endif
            </ul>
        </div>
    @endif
</div>
@endsection