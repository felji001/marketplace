@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-75 align-items-center">
        <div class="col-lg-5 col-md-7">
            <!-- Login Header -->
            <div class="text-center mb-4">
                <div class="login-icon mb-3">
                    <i class="bi bi-person-circle display-1 text-primary"></i>
                </div>
                <h2 class="fw-bold text-gray-800">Welcome Back!</h2>
                <p class="text-muted">Sign in to your account to continue</p>
            </div>

            <!-- Login Card -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-2 text-primary"></i>{{ __('Email Address') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-at text-muted"></i>
                                </span>
                                <input id="email"
                                       type="email"
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="email"
                                       autofocus
                                       placeholder="Enter your email address">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-2 text-primary"></i>{{ __('Password') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key text-muted"></i>
                                </span>
                                <input id="password"
                                       type="password"
                                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                {{ __('Sign In') }}
                            </button>
                        </div>

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Don't have an account?
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                                        Create one here
                                    </a>
                                </p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Demo Credentials -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body p-3">
                    <h6 class="card-title text-muted mb-2">
                        <i class="bi bi-info-circle me-1"></i>Demo Credentials
                    </h6>
                    <div class="row small">
                        <div class="col-md-6">
                            <strong>Admin:</strong> fadwaeljihani@gmail.com
                        </div>
                        <div class="col-md-6">
                            <strong>Producer:</strong> fatyelouardi@gmail.com
                        </div>
                        <div class="col-12 mt-1">
                            <strong>Buyer:</strong> yasser@gmail.com
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });

    // Form validation
    const form = document.getElementById('loginForm');
    const inputs = form.querySelectorAll('input[required]');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
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

        if (value) {
            field.classList.add('is-valid');
        }

        return true;
    }
});
</script>
@endsection
