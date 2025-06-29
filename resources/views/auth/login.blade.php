@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Side - Branding/Image -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center position-relative overflow-hidden"
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <!-- Background Pattern -->
            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                </div>
            </div>

            <div class="text-center text-white position-relative">
                <div class="brand-showcase mb-4">
                    <div class="brand-icon-large bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                         style="width: 120px; height: 120px;">
                        <i class="bi bi-shop-window display-3 text-white"></i>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">{{ config('app.name', 'Marketplace') }}</h1>
                    <p class="lead opacity-90 mb-4">Quality products marketplace</p>
                </div>
                <div class="features-list">
                    <div class="feature-item d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-shield-check me-3 fs-4"></i>
                        <span>Secure & Trusted Platform</span>
                    </div>
                    <div class="feature-item d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-people me-3 fs-4"></i>
                        <span>Connect with Verified Sellers</span>
                    </div>
                    <div class="feature-item d-flex align-items-center justify-content-center">
                        <i class="bi bi-lightning me-3 fs-4"></i>
                        <span>Fast & Easy Transactions</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center p-4">
            <div class="login-form-container w-100" style="max-width: 480px;">
                <!-- Enhanced Login Header -->
                <div class="text-center mb-5">
                    <div class="login-icon mb-4">
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-person-circle display-4 text-primary"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-2">Welcome Back!</h2>
                    <p class="text-muted">Sign in to your account to continue your marketplace journey</p>
                </div>

                <!-- Enhanced Login Card -->
                <div class="card modern-form-card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate class="modern-form">
                            @csrf

                            <!-- Enhanced Email Field -->
                            <div class="form-floating mb-4">
                                <input id="email"
                                       type="email"
                                       class="form-control modern-input @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="email"
                                       autofocus
                                       placeholder="Enter your email address">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-2"></i>{{ __('Email Address') }}
                                </label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="valid-feedback">
                                    <i class="bi bi-check-circle me-1"></i>Email looks good!
                                </div>
                            </div>

                            <!-- Enhanced Password Field -->
                            <div class="form-floating mb-4 position-relative">
                                <input id="password"
                                       type="password"
                                       class="form-control modern-input @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock me-2"></i>{{ __('Password') }}
                                </label>
                                <button class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 bg-transparent"
                                        type="button" id="togglePassword" style="z-index: 10;">
                                    <i class="bi bi-eye text-muted" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="valid-feedback">
                                    <i class="bi bi-check-circle me-1"></i>Password is secure!
                                </div>
                            </div>

                            <!-- Enhanced Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check modern-checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-semibold">
                                        <i class="bi bi-question-circle me-1"></i>{{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Enhanced Login Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg py-3 rounded-pill shadow-sm modern-submit-btn">
                                    <span class="btn-text">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        {{ __('Sign In') }}
                                    </span>
                                    <span class="btn-loading d-none">
                                        <i class="bi bi-arrow-repeat spin me-2"></i>
                                        Signing in...
                                    </span>
                                </button>
                            </div>

                            <!-- Enhanced Register Link -->
                            @if (Route::has('register'))
                                <div class="text-center">
                                    <div class="divider-text mb-3">
                                        <span class="bg-white px-3 text-muted small">or</span>
                                    </div>
                                    <p class="text-muted mb-0">
                                        Don't have an account?
                                        <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold">
                                            <i class="bi bi-person-plus me-1"></i>Create one here
                                        </a>
                                    </p>
                                </div>
                            @endif
                    </form>
                </div>
            </div>

            <!-- Enhanced Demo Credentials -->
            <div class="card mt-4 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="card-title text-primary mb-3 fw-semibold">
                        <i class="bi bi-info-circle me-2"></i>Demo Credentials
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="demo-credential p-3 bg-light rounded-3">
                                <div class="fw-semibold text-primary mb-1">Admin</div>
                                <small class="text-muted">fadwaeljihani@gmail.com</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="demo-credential p-3 bg-light rounded-3">
                                <div class="fw-semibold text-success mb-1">Producer</div>
                                <small class="text-muted">fatyelouardi@gmail.com</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="demo-credential p-3 bg-light rounded-3">
                                <div class="fw-semibold text-info mb-1">Buyer</div>
                                <small class="text-muted">yasser@gmail.com</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-key me-1"></i>All demo accounts use the same password
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced CSS Styles -->
<style>
/* Floating shapes animation */
.floating-shapes {
    position: relative;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 80px;
    height: 80px;
    top: 20%;
    right: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 60px;
    height: 60px;
    top: 60%;
    right: 20%;
    animation-delay: 2s;
}

.shape-3 {
    width: 40px;
    height: 40px;
    top: 40%;
    right: 5%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

/* Modern form styles */
.modern-form-card {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.modern-input {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
}

.modern-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    background: white;
}

.modern-input.is-valid {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
}

.modern-input.is-invalid {
    border-color: #dc3545;
    background: rgba(220, 53, 69, 0.05);
}

.form-floating > .modern-input {
    padding-top: 1.625rem;
    padding-bottom: 0.625rem;
}

.form-floating > label {
    padding: 1rem;
    font-weight: 500;
    color: #6c757d;
}

.modern-checkbox .form-check-input {
    border-radius: 6px;
    border: 2px solid #dee2e6;
    width: 1.2em;
    height: 1.2em;
}

.modern-checkbox .form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.modern-submit-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.modern-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
}

.modern-submit-btn:active {
    transform: translateY(0);
}

.divider-text {
    position: relative;
    text-align: center;
}

.divider-text::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #dee2e6;
}

.demo-credential {
    transition: all 0.3s ease;
    cursor: pointer;
}

.demo-credential:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .login-form-container {
        padding: 2rem 1rem;
    }

    .modern-form-card .card-body {
        padding: 2rem !important;
    }
}
</style>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function(e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');

            // Add visual feedback
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    }

    // Enhanced form validation
    const form = document.getElementById('loginForm');
    const inputs = form.querySelectorAll('input[required]');
    const submitBtn = form.querySelector('.modern-submit-btn');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
            updateSubmitButton();
        });

        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    function validateField(field) {
        const value = field.value.trim();
        field.classList.remove('is-valid', 'is-invalid');

        if (field.hasAttribute('required') && !value) {
            field.classList.add('is-invalid');
            return false;
        }

        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                field.classList.add('is-invalid');
                return false;
            }
        }

        if (field.name === 'password' && value) {
            if (value.length < 6) {
                field.classList.add('is-invalid');
                return false;
            }
        }

        if (value) {
            field.classList.add('is-valid');
        }

        return true;
    }

    function updateSubmitButton() {
        const allValid = Array.from(inputs).every(input => {
            return input.value.trim() !== '' && !input.classList.contains('is-invalid');
        });

        if (allValid) {
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-primary');
        } else {
            submitBtn.classList.remove('btn-primary');
            submitBtn.classList.add('btn-secondary');
        }
    }

    // Enhanced form submission
    form.addEventListener('submit', function(e) {
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        submitBtn.disabled = true;

        // Re-enable if form submission fails
        setTimeout(() => {
            if (submitBtn.disabled) {
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
                submitBtn.disabled = false;
            }
        }, 5000);
    });

    // Demo credential click handlers
    const demoCredentials = document.querySelectorAll('.demo-credential');
    demoCredentials.forEach(credential => {
        credential.addEventListener('click', function() {
            const email = this.querySelector('small').textContent;
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            emailInput.value = email;
            passwordInput.value = 'password'; // Default demo password

            validateField(emailInput);
            validateField(passwordInput);
            updateSubmitButton();

            // Visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // Initial validation state
    updateSubmitButton();
});
</script>
@endsection
