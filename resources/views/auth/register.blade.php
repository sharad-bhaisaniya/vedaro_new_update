@extends('layouts.main')

@section('title', 'Register')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

@section('content')
    <div class="user_register_form">
        <h2>Create Account</h2>

        @if(session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" id="error-message">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="post">
            @csrf  
            
            <div class="input-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            
            <div class="input-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            
            <div class="input-group">
                <label for="phone">Phone</label>
                <input type="number" id="phone" name="phone" required>
            </div>
            
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="input-group">
    <label for="password">Password</label>
    <div class="password-container">
        <input type="password" id="password" name="password" required>
        <i class="fa fa-eye toggle-password" id="togglePassword"></i>
    </div>
</div>

            <div class="input-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                <span id="password-error" style="color:red; display:none;">Passwords do not match</span>
            </div>

            <div class="submit-btn">
                <button type="submit">Register</button>
            </div>
            
            <div class="forgot-password">
                <a href="/login">Already have an account?</a>
            </div>
        </form>
    </div>
    
 

    <script>
        $(document).ready(function() {
            // Success/Error Message Auto Fade
            if($('#success-message').length) {
                setTimeout(function() {
                    $('#success-message').fadeOut('slow');
                }, 3000); 
            }

            if($('#error-message').length) {
                setTimeout(function() {
                    $('#error-message').fadeOut('slow');
                }, 3000); 
            }

            // Password Matching Check
            $('#password, #password_confirmation').on('input', function() {
                var password = $('#password').val();
                var confirmPassword = $('#password_confirmation').val();

                if (password !== confirmPassword) {
                    $('#password-error').show();
                } else {
                    $('#password-error').hide();
                }
            });

            // Show/Hide Password
            $('#togglePassword').on('change', function() {
                var passwordField = $('#password');
                var confirmPasswordField = $('#password_confirmation');
                var type = $(this).is(':checked') ? 'text' : 'password';

                passwordField.attr('type', type);
                confirmPasswordField.attr('type', type);
            });

            $('#close-success').on('click', function() {
                $('#success-message').fadeOut('slow');
            });

            $('#close-error').on('click', function() {
                $('#error-message').fadeOut('slow');
            });
        });
    </script>
    
    
 

<script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);

        // Toggle the icon class
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
</script>
@endsection



   <style>
        .user_register_form .alert{
            position: relative;
        }
        .user_register_form .alert ul{
            position: absolute;
            padding: 10px;
            top: -160px;
            z-index: 27;
        }
        .user_register_form .alert ul li{
            padding: 6px 10px;
            background: red;
            margin: 10px;
            color: #fff;
            border-radius: 3px;
            font-size: 12px;
        }
    </style>


   <style>
.input-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.password-container {
    position: relative;
    display: flex;
    align-items: center;
}

.password-container input {
    width: 100%;
    padding-right: 35px; /* Space for the icon */
}

.toggle-password {
    position: absolute;
    right: 10px;
    cursor: pointer;
    font-size: 1.2rem;
    color: #888;
    transition: color 0.3s;
}

.toggle-password:hover {
    color: #333;
}
</style>
 