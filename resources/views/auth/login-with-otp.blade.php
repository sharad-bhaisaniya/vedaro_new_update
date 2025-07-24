@extends('layouts.main')

@section('title', 'Login/Register with WhatsApp')

@section('content')
<div class="user_login_form">
    <h2>Login/Register with WhatsApp</h2>
    
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

    <div class="otp-tabs">
        <button class="tab-button active" data-tab="login-tab">Login</button>
        <button class="tab-button" data-tab="register-tab">Register</button>
    </div>

    <div class="tab-content active" id="login-tab">
        <form action="{{ route('send-otp') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="login">
            <div class="form-group">
                <label for="login_phone">Registered Phone Number:</label>
                <input type="tel" name="phone" id="login_phone" class="form-control" required 
                       placeholder="Enter your registered phone number with country code (e.g., +911234567890)"
                       value="{{ old('phone') }}">
            </div>
            <button type="submit" class="btn btn-primary">Send OTP via WhatsApp</button>
        </form>
    </div>

    <div class="tab-content" id="register-tab">
        <form action="{{ route('send-otp') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="register">
            <div class="form-group">
                <label for="register_phone">New Phone Number:</label>
                <input type="tel" name="phone" id="register_phone" class="form-control" required 
                       placeholder="Enter phone number with country code (e.g., +911234567890)"
                       value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" class="form-control" required
                       placeholder="Enter your full name"
                       value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="email">Email (Optional):</label>
                <input type="email" name="email" id="email" class="form-control"
                       placeholder="Enter your email"
                       value="{{ old('email') }}">
            </div>
            <button type="submit" class="btn btn-primary">Register & Send OTP via WhatsApp</button>
        </form>
    </div>

    <div class="auth-links mt-3">
        <a href="{{ route('login') }}">Login with Email</a> | 
        <a href="{{ route('register') }}">Traditional Registration</a>
    </div>
</div>

<style>
    .otp-tabs {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }
    
    .tab-button {
        padding: 10px 20px;
        background: #f5f5f5;
        border: none;
        cursor: pointer;
        font-size: 16px;
        margin-right: 5px;
    }
    
    .tab-button.active {
        background: #007bff;
        color: white;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-button');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and content
                document.querySelectorAll('.tab-button').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>
@endsection