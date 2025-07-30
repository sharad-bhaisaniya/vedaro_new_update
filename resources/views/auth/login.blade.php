<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      background-color: #f7e9d9;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-card {
      background-color: white;
      border-radius: 1.5rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 2.5rem;
      width: 100%;
      max-width: 420px;
    }

    .form-control:focus {
      border-color: #8e62f2;
      box-shadow: 0 0 0 0.25rem rgba(142, 98, 242, 0.25);
    }

    .btn-login {
      background-color: #8e62f2;
      border: none;
      font-weight: 500;
    }

    .btn-login:hover {
      background-color: #7a52e0;
    }

    .btn-whatsapp {
      background-color: #25D366;
      color: white;
    }

    .btn-whatsapp:hover {
      background-color: #128C7E;
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
  </style>
</head>
<body>

  <div class="login-card">
    <h3 class="text-center mb-3 fw-bold">Login to Your Account</h3>
    <p class="text-center text-muted mb-4">Access your dashboard with email or WhatsApp</p>

    <!-- Flash Messages -->
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        @if(config('app.debug'))
          <div class="mt-1 small text-muted">Debug: {{ session('debug_error') }}</div>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Login Form -->
    <form action="{{ route('login') }}" method="POST" class="mb-4">
      @csrf
      <div class="mb-3">
        <input type="email" name="email" class="form-control" id="email" placeholder="Email address" required>
      </div>

      <div class="mb-4">
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-login btn-lg">
          <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>
      </div>
    </form>

    <!-- OR Section -->
    <div class="text-center mb-3 text-muted">or login with</div>

    <div class="d-grid gap-2 mb-4">
      <a href="{{ route('login-with-otp') }}" class="btn btn-whatsapp">
        <i class="bi bi-whatsapp me-2"></i>WhatsApp OTP
      </a>
      <a href="{{ route('login.google') }}" class="google-btn">
        Sign in with Google
      </a>
    </div>

    <!-- Links -->
    <div class="auth-links">
      <div class="mb-2">
        <a href="{{ url('/register') }}">Create new account</a>
      </div>
      <div>
        <a href="{{ url('/forgot-password') }}">Forgot Password?</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>