@extends('layouts.main')

@section('content')
<div class="container" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
    <!-- OTP Verification Section -->
    <div class="col-md-4 user_login_form">
        <h2 class="text-center">Verify OTP</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verify-otp') }}">
            @csrf
            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" value="{{ old('otp') }}" required>
                @error('otp')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        </form>

        <!-- Resend OTP Button: Show only if success message is present and OTP is not yet sent again -->
        @if(session('success') && !session('otp_sent'))
            <div class="resend-otp mt-3">
                <form action="{{ route('resend-otp') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning w-100">Resend OTP</button>
                </form>
            </div>
        @endif
    </div>
</div>

<!-- Login Section -->

<style>
    /* Center the forms on the page */
    .user_login_form {
        max-width: 400px;
        margin: 0 auto;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Header Styles */
    .user_login_form h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        color: #333;
    }

    /* Input Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-group input:focus {
        border-color: #4CAF50;
        outline: none;
    }

    /* Button Styles */
    .user_login_form button[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-bottom: 20px;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    /* Resend OTP Button Styles */
    .resend-otp button {
        background-color: #f39c12;
        color: white;
        border: none;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .resend-otp button:hover {
        background-color: #e67e22;
    }

    /* Error and Success Messages */
    .alert {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Link Styles */
    .user_login_form a {
        text-decoration: none;
        font-size: 14px;
        color: #007bff;
        display: block;
        text-align: center;
        margin-top: 10px;
    }

    .user_login_form a:hover {
        text-decoration: underline;
    }
</style>

@endsection
