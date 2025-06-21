@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-75 align-items-center">
        <div class="col-lg-6 col-md-8">
            <!-- Registration Header -->
            <div class="text-center mb-4">
                <div class="register-icon mb-3">
                    <i class="bi bi-person-plus-fill display-1 text-success"></i>
                </div>
                <h2 class="fw-bold text-gray-800">Create Account</h2>
                <p class="text-muted">Join our marketplace community today</p>
            </div>

            <!-- Registration Card -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="bi bi-person me-2 text-success"></i>{{ __('Full Name') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person-fill text-muted"></i>
                                </span>
                                <input id="name"
                                       type="text"
                                       class="form-control border-start-0 @error('name') is-invalid @enderror"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       autocomplete="name"
                                       autofocus
                                       placeholder="Enter your full name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-2 text-success"></i>{{ __('Email Address') }}
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
                                       placeholder="Enter your email address">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label for="role" class="form-label fw-semibold">
                                <i class="bi bi-person-badge me-2 text-success"></i>{{ __('Account Type') }}
                            </label>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-check form-check-card">
                                        <input class="form-check-input" type="radio" name="role" id="buyer" value="buyer" {{ old('role') == 'buyer' ? 'checked' : '' }} required>
                                        <label class="form-check-label card h-100 p-3 text-center" for="buyer">
                                            <i class="bi bi-bag-check display-6 text-primary mb-2"></i>
                                            <h6 class="fw-bold">Buyer</h6>
                                            <small class="text-muted">I want to purchase products</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-check form-check-card">
                                        <input class="form-check-input" type="radio" name="role" id="producer" value="producer" {{ old('role') == 'producer' ? 'checked' : '' }} required>
                                        <label class="form-check-label card h-100 p-3 text-center" for="producer">
                                            <i class="bi bi-shop display-6 text-warning mb-2"></i>
                                            <h6 class="fw-bold">Producer</h6>
                                            <small class="text-muted">I want to sell products</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- WhatsApp Number Field -->
                        <div class="mb-4" id="whatsappField" style="display: none;">
                            <label for="whatsapp_number" class="form-label fw-semibold">
                                <i class="bi bi-whatsapp me-2 text-success"></i>{{ __('WhatsApp Number') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-phone text-muted"></i>
                                </span>
                                <input id="whatsapp_number"
                                       type="text"
                                       class="form-control border-start-0 @error('whatsapp_number') is-invalid @enderror"
                                       name="whatsapp_number"
                                       value="{{ old('whatsapp_number') }}"
                                       placeholder="e.g., +212 766-635841">
                                @error('whatsapp_number')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Required for producers to receive order notifications
                            </small>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-2 text-success"></i>{{ __('Password') }}
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
                                       autocomplete="new-password"
                                       placeholder="Create a strong password">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="password-strength mt-2" id="passwordStrength" style="display: none;">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted" id="passwordStrengthText"></small>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold">
                                <i class="bi bi-shield-check me-2 text-success"></i>{{ __('Confirm Password') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-shield text-muted"></i>
                                </span>
                                <input id="password-confirm"
                                       type="password"
                                       class="form-control border-start-0"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Confirm your password">
                            </div>
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-person-plus me-2"></i>
                                {{ __('Create Account') }}
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Role selection handling
    const roleInputs = document.querySelectorAll('input[name="role"]');
    const whatsappField = document.getElementById('whatsappField');
    const whatsappInput = document.getElementById('whatsapp_number');

    roleInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'producer') {
                whatsappField.style.display = 'block';
                whatsappInput.required = true;
            } else {
                whatsappField.style.display = 'none';
                whatsappInput.required = false;
            }
        });
    });

    // Check initial state
    const checkedRole = document.querySelector('input[name="role"]:checked');
    if (checkedRole && checkedRole.value === 'producer') {
        whatsappField.style.display = 'block';
        whatsappInput.required = true;
    }

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

    // Password strength indicator
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordStrengthBar = passwordStrength.querySelector('.progress-bar');
    const passwordStrengthText = document.getElementById('passwordStrengthText');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);

        if (password.length > 0) {
            passwordStrength.style.display = 'block';
            passwordStrengthBar.style.width = strength.percentage + '%';
            passwordStrengthBar.className = 'progress-bar ' + strength.class;
            passwordStrengthText.textContent = strength.text;
        } else {
            passwordStrength.style.display = 'none';
        }
    });

    function calculatePasswordStrength(password) {
        let score = 0;
        let feedback = [];

        if (password.length >= 8) score += 25;
        else feedback.push('at least 8 characters');

        if (/[a-z]/.test(password)) score += 25;
        else feedback.push('lowercase letter');

        if (/[A-Z]/.test(password)) score += 25;
        else feedback.push('uppercase letter');

        if (/[0-9]/.test(password)) score += 25;
        else feedback.push('number');

        let strength = {
            percentage: score,
            class: 'bg-danger',
            text: 'Weak'
        };

        if (score >= 75) {
            strength.class = 'bg-success';
            strength.text = 'Strong';
        } else if (score >= 50) {
            strength.class = 'bg-warning';
            strength.text = 'Medium';
        }

        if (feedback.length > 0) {
            strength.text += ' - Add: ' + feedback.join(', ');
        }

        return strength;
    }

    // Form validation
    const form = document.getElementById('registerForm');
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

    // Password confirmation validation
    const confirmPassword = document.getElementById('password-confirm');
    confirmPassword.addEventListener('input', function() {
        if (this.value !== passwordInput.value) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
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

<style>
.form-check-card .form-check-input {
    display: none;
}

.form-check-card .form-check-label {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.form-check-card .form-check-label:hover {
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.form-check-card .form-check-input:checked + .form-check-label {
    border-color: #007bff;
    background-color: #f8f9ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
