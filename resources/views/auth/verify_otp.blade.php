<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OTP Verification</title>

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

    .btn-verify {
      background-color: #8e62f2;
      border: none;
      font-weight: 500;
    }

    .btn-verify:hover {
      background-color: #7a52e0;
    }

    .btn-resend {
      background-color: #f39c12;
      border: none;
      font-weight: 500;
    }

    .btn-resend:hover {
      background-color: #e67e22;
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

    .alert {
      border-radius: 0.5rem;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h3 class="text-center mb-3 fw-bold">Verify OTP</h3>
    <p class="text-center text-muted mb-4">Enter the code sent to your phone</p>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('verify-otp') }}">
      @csrf
      <div class="mb-4">
        <input type="text" class="form-control" id="otp" name="otp" value="{{ old('otp') }}" placeholder="Enter OTP" required>
        @error('otp')
          <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
        @enderror
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-verify btn-lg">
          <i class="bi bi-shield-check me-2"></i>Verify OTP
        </button>
      </div>
    </form>

    @if(session('success') && !session('otp_sent'))
      <form action="{{ route('resend-otp') }}" method="POST">
        @csrf
        <div class="d-grid">
          <button type="submit" class="btn btn-resend btn-lg">
            <i class="bi bi-arrow-repeat me-2"></i>Resend OTP
          </button>
        </div>
      </form>
    @endif

    <div class="auth-links">
      <a href="{{ url('/login') }}">Back to Login</a>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>