<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
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
    .btn-purple {
      background-color: #8e62f2;
      border: none;
      font-weight: 500;
      color: white;
    }
    .btn-purple:hover {
      background-color: #7a52e0;
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
    .form-control {
      padding: 1rem;
    }
  </style>
</head>
<body>

<div class="login-card">
  <h3 class="text-center mb-3 fw-bold">Reset Password</h3>
  <p class="text-center text-muted mb-4">Enter your email to receive a reset link</p>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if ($errors->any()))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      @foreach ($errors->all() as $error)
        {{ $error }}
      @endforeach
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <form action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Enter your email address" 
             value="{{ old('email') }}" required autofocus>
    </div>

    <div class="d-grid mb-3">
      <button type="submit" class="btn btn-purple btn-lg">
        <i class="bi bi-send me-2"></i>Send Reset Link
      </button>
    </div>
  </form>

  <div class="auth-links">
    <a href="{{ url('/login') }}"><i class="bi bi-arrow-left me-1"></i>Back to Login</a>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>