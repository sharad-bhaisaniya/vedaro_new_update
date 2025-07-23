@extends('layouts.main')

@section('title', 'Login')

@section('content')
<div class="user_login_form">
    <h2>Login</h2>
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

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <a href="{{ route('login.google') }}">
        <button type="button" class="login-with-google-btn">Sign in with Google</button>
    </a>


    <div class="auth-links">
        <a href="{{ '/register' }}">Create new account</a>
        <a href="{{ '/forgot-password' }}" class="forgot-password-link">Forgot Password?</a>
    </div>
</div>

        <style>
            
/* Center the login form on the page */
.user_login_form {
    max-width: 400px;
    margin: 150px auto 20px;
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
}

button[type="submit"]:hover {
    background-color: #45a049;
}

/* Error and Success Messages */
.error-message, .success-message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

/* Link Styles */
.user_login_form a {
    text-decoration: none;
    font-size: 14px;
    color: black;
    display: block;
    text-align: center;
    margin-top: 10px;
}

.user_login_form a:hover {
    text-decoration: underline;
}

/* Styles for the additional links (Register & Forgot Password) */
.auth-links {
    display: flex;
    justify-content: space-between;
    width: 100%;  /* Ensure it spans the full width */
    margin-top: 10px;
}

.auth-links a {
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
}

.auth-links a:hover {
    text-decoration: underline;
}

/* Optional: Add some space between the links */
.auth-links a:first-child {
    margin-right: 20px;
}

.btn-google {
  display: inline-flex;
  align-items: center;
  background-color: white; /* Google blue */
  color: black;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 16px;
  text-decoration: none;
  font-family: Arial, sans-serif;
  transition: background-color 0.3s ease;
  border: 1px solid blue;
}

.btn-google img {

    margin-top: 10px;
}
.btn-google:hover {
  background-color: #2da5c1; /* Darker blue when hovered */
}

.google-icon {
  width: 20px; /* Adjust size of the Google logo */
  height: 20px;
  margin-right: 10px; /* Space between the icon and text */
}

.btn-google:focus {
  outline: none;
}

.login-with-google-btn {
  transition: background-color .3s, box-shadow .3s;
    
  padding: 12px 16px 12px 42px;
  border: none;
  border-radius: 3px;
  box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
  
  color: #757575;
  font-size: 14px;
  font-weight: 500;
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Fira Sans","Droid Sans","Helvetica Neue",sans-serif;
  
  background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
  background-color: white;
  background-repeat: no-repeat;
  background-position: 12px 11px;
  
  &:hover {
    box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
  }
  
  &:active {
    background-color: #eeeeee;
  }
  
  &:focus {
    outline: none;
    box-shadow: 
      0 -1px 0 rgba(0, 0, 0, .04),
      0 2px 4px rgba(0, 0, 0, .25),
      0 0 0 3px #c8dafc;
  }
  
  &:disabled {
    filter: grayscale(100%);
    background-color: #ebebeb;
    box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
    cursor: not-allowed;
  }
}













        </style>
@endsection