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
    .btn-purple {
      background-color: #8e62f2;
      border: none;
      font-weight: 500;
      color: white;
    }
    .btn-purple:hover {
      background-color: #7a52e0;
    }
    .otp-input {
      width: 40px;
      height: 50px;
      text-align: center;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>

<div class="login-card">
  <h3 class="text-center mb-3 fw-bold">Verify OTP</h3>
  <p class="text-center text-muted mb-4">Enter the 6-digit code sent to your phone</p>

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <form action="{{ route('wh.verify.otp.post') }}" method="POST" id="otpForm">
    @csrf
    <div class="d-flex justify-content-center mb-4">
      <input type="text" name="otp[]" maxlength="1" class="form-control otp-input mx-1" required autofocus>
      <input type="text" name="otp[]" maxlength="1" class="form-control otp-input mx-1" required>
      <input type="text" name="otp[]" maxlength="1" class="form-control otp-input mx-1" required>
      <input type="text" name="otp[]" maxlength="1" class="form-control otp-input mx-1" required>
      <input type="text" name="otp[]" maxlength="1" class="form-control otp-input mx-1" required>
      <input type="text" name="otp[]" maxlength="1" class="form-control otp-input mx-1" required>
    </div>
    <button type="submit" class="btn btn-purple w-100 mb-3">Verify OTP</button>
  </form>

  <div class="text-center">
    <p class="text-muted">Didn't receive code? <a href="#" id="resendOtp">Resend OTP</a></p>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otpForm');
    
    // Auto-focus and move between OTP inputs
    otpInputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        if (e.target.value.length === 1) {
          if (index < otpInputs.length - 1) {
            otpInputs[index + 1].focus();
          }
        }
      });
      
      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
          otpInputs[index - 1].focus();
        }
      });
    });
    
    // Form submission handler
    form.addEventListener('submit', function(e) {
      // Combine OTP digits into a single value
      const otpDigits = Array.from(otpInputs).map(input => input.value).join('');
      
      // Create a hidden input to send the combined OTP
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = 'otp';
      hiddenInput.value = otpDigits;
      form.appendChild(hiddenInput);
    });
    
    // Resend OTP handler
    document.getElementById('resendOtp').addEventListener('click', function(e) {
      e.preventDefault();
      // You would typically make an AJAX call here to resend OTP
      alert('OTP has been resent to your phone number');
    });
  });
</script>
</body>
</html>