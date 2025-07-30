<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7e9d9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }
        
        .register-card {
            background-color: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
        }
        
        .form-control:focus {
            border-color: #8e62f2;
            box-shadow: 0 0 0 0.25rem rgba(142, 98, 242, 0.25);
        }
        
        .btn-register {
            background-color: #8e62f2;
            border: none;
            padding: 0.75rem;
            font-weight: 500;
        }
        
        .btn-register:hover {
            background-color: #7a52e0;
        }
        
        .password-container {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
        
        .toggle-password:hover {
            color: #8e62f2;
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .login-link a {
            color: #6c757d;
            text-decoration: none;
        }
        
        .login-link a:hover {
            color: #8e62f2;
            text-decoration: underline;
        }
        
        #password-error {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .auth-links {
            font-size: 0.9rem;
            text-align: center;
            margin-top: 1.5rem;
        }

        .auth-links a {
            color: #6c757d;
            text-decoration: none;
        }

        .auth-links a:hover {
            color: #8e62f2;
            text-decoration: underline;
        }

        .google-btn {
            background: white url('https://www.svgrepo.com/show/475656/google-color.svg') no-repeat 12px center;
            background-size: 20px;
            border: 1px solid #ddd;
            color: #555;
            font-size: 14px;
            padding: 10px 16px 10px 42px;
            border-radius: 5px;
            width: 100%;
        }

        .google-btn:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h3 class="text-center mb-3 fw-bold">Create Your Account</h3>
        <p class="text-center text-muted mb-4">Join us to get started</p>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="post">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                </div>
            </div>
            
            <div class="mb-3">
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
            </div>
            
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
            </div>
            
            <div class="mb-3">
                <div class="password-container">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
            </div>
            
            <div class="mb-4">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <div id="password-error" class="text-danger" style="display:none;">
                    <i class="bi bi-exclamation-circle me-1"></i>Passwords do not match
                </div>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-register btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Register
                </button>
            </div>
        </form>

        <!-- OR Section -->
        <div class="text-center mb-3 text-muted">or sign up with</div>

        <div class="d-grid gap-2 mb-4">
            <a href="{{ route('login-with-otp') }}" class="btn btn-whatsapp">
                <i class="bi bi-whatsapp me-2"></i>WhatsApp OTP
            </a>
            <a href="{{ route('login.google') }}" class="google-btn">
                Sign up with Google
            </a>
        </div>

        <div class="auth-links">
            <div class="mb-2">
                <a href="{{ url('/login') }}">Already have an account? Sign in</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto-hide success/error messages after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Password matching check
            $('#password, #password_confirmation').on('input', function() {
                var password = $('#password').val();
                var confirmPassword = $('#password_confirmation').val();

                if (password !== confirmPassword && confirmPassword.length > 0) {
                    $('#password-error').show();
                } else {
                    $('#password-error').hide();
                }
            });

            // Show/hide password toggle
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const confirmField = $('#password_confirmation');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                
                passwordField.attr('type', type);
                confirmField.attr('type', type);
                
                // Toggle eye icon
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
</body>
</html>