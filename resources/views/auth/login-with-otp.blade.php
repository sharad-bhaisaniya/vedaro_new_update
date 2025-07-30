<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register with WhatsApp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0e6d3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        
        .auth-card {
            max-width: 300px;
            width: 100%;
            padding: 2rem;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        @media (min-width: 768px) {
            .auth-card {
                max-width: 450px;
                padding: 3rem;
            }
        }
        
        .card-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .mobile-input {
            height: 3.5rem;
            font-size: 1.1rem;
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: all 0.2s ease-in-out;
        }
        
        .mobile-input:focus {
            border-color: #25D366;
            box-shadow: 0 0 0 0.25rem rgba(37, 211, 102, 0.25);
            outline: none;
        }
        
        .btn-whatsapp {
            background-color: #25D366;
            border-color: #25D366;
            color: white;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.2s ease-in-out;
        }
        
        .btn-whatsapp:hover {
            background-color: #128C7E;
            border-color: #128C7E;
            color: white;
        }
        
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 1.5rem;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.5rem;
            transition: all 0.3s;
        }
        
        .nav-tabs .nav-link.active {
            color: #25D366;
            background-color: transparent;
            border-bottom: 2px solid #25D366;
        }
        
        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .text-muted {
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        .footer-links {
            font-size: 0.75rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="card shadow-lg auth-card">
        <h2 class="card-title text-center">
            <i class="bi bi-whatsapp me-2"></i>
            WhatsApp Login/Register
        </h2>
        
        <!-- Error/Success Messages -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
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

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs nav-justified" id="authTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                    <i class="bi bi-person-plus me-2"></i>Register
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="authTabsContent">
            <!-- Login Tab -->
            <div class="tab-pane fade show active" id="login" role="tabpanel">
                <form action="{{ route('wh.send.otp') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="login">
                    
                    <div class="mb-4">
                        <label for="login_phone" class="form-label text-muted">
                            <i class="bi bi-phone me-2"></i>WhatsApp Number
                        </label>
                        <input type="tel" class="form-control mobile-input" id="login_phone" name="phone" required
                               placeholder="e.g. +911234567890" value="{{ old('phone') }}">
                        <small class="text-muted">Enter with country code</small>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-whatsapp">
                            <i class="bi bi-send me-2"></i>Send OTP via WhatsApp
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Register Tab -->
            <div class="tab-pane fade" id="register" role="tabpanel">
                <form action="{{ route('wh.send.otp') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="register">
                    
                    <div class="mb-3">
                        <label for="register_phone" class="form-label text-muted">
                            <i class="bi bi-phone me-2"></i>WhatsApp Number
                        </label>
                        <input type="tel" class="form-control mobile-input" id="register_phone" name="phone" required
                               placeholder="e.g. +911234567890" value="{{ old('phone') }}">
                        <small class="text-muted">Enter with country code</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label text-muted">
                            <i class="bi bi-person me-2"></i>First Name
                        </label>
                        <input type="text" class="form-control mobile-input" id="name" name="name" required
                               placeholder="Your full name" value="{{ old('name') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="last_name" class="form-label text-muted">
                            <i class="bi bi-person me-2"></i>Last Name
                        </label>
                        <input type="text" class="form-control mobile-input" id="last_name" name="last_name" required
                               placeholder="Your full name" value="{{ old('last_name') }}">
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted">
                            <i class="bi bi-envelope me-2"></i>Email (Optional)
                        </label>
                        <input type="email" class="form-control mobile-input" id="email" name="email"
                               placeholder="your@email.com" value="{{ old('email') }}">
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-whatsapp">
                            <i class="bi bi-send me-2"></i>Register & Send OTP
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <hr class="my-4">
            <p class="text-muted">Or use traditional methods</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                    <i class="bi bi-envelope me-2"></i>Email Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-person-plus me-2"></i>Register
                </a>
            </div>
        </div>
        
        <div class="text-center mt-4 pt-3 border-top">
            <p class="mb-0 footer-links">
                By continuing, you agree to our 
                <a href="#" class="text-decoration-none">Terms</a> and 
                <a href="#" class="text-decoration-none">Privacy Policy</a>
            </p>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>