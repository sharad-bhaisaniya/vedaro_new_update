<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
					font-family: "MyCustomFont";
					src: url("{{ asset('fonts/myfont.ttf') }}") format("truetype");
					font-weight: normal;
					font-style: normal;
					}
        body {
            background-color: #f8f9fa;
            font-family: "MyCustomFont", sans-serif;
        }

        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            font-weight: 700;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box .form-control {
            border-radius: 5px;
            height: 45px;
        }

        .login-box .btn-primary {
            width: 100%;
            height: 45px;
            font-size: 16px;
        }

        .login-box .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .login-box .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .login-box .forgot-password a:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!--<div class="mb-3 form-check">-->
                <!--    <input type="checkbox" class="form-check-input" name="remember" id="remember">-->
                <!--    <label class="form-check-label" for="remember">Remember Me</label>-->
                <!--</div>-->
                <button type="submit" class="btn btn-primary">Login</button>
                <div class="forgot-password">
                    <!-- <a href="forgot_password.html">Forgot Password?</a> -->
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>