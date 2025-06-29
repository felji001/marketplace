@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="profile-header bg-gradient p-4 rounded-3 text-white" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2 text-white">
                            <i class="bi bi-shield-lock me-2"></i>
                            Change Password
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            Update your account password for better security
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="profile-actions">
                            <a href="{{ route('profile.show') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Back to Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-key me-2"></i>
                        Update Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           name="current_password" required autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                        <i class="bi bi-eye" id="current_password_icon"></i>
                                    </button>
                                </div>

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Enter your current password to confirm your identity
                                </small>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password" onkeyup="checkPasswordStrength()">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="bi bi-eye" id="password_icon"></i>
                                    </button>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <!-- Password Strength Indicator -->
                                <div class="password-strength mt-2" id="password_strength" style="display: none;">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="strength-text text-muted"></small>
                                </div>
                                
                                <small class="form-text text-muted">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Password must be at least 8 characters long
                                </small>
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirm New Password') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password_confirmation" type="password" class="form-control" 
                                           name="password_confirmation" required autocomplete="new-password" onkeyup="checkPasswordMatch()">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye" id="password_confirmation_icon"></i>
                                    </button>
                                </div>

                                <div id="password_match" class="mt-2" style="display: none;">
                                    <small class="match-text"></small>
                                </div>
                                
                                <small class="form-text text-muted">
                                    <i class="bi bi-arrow-repeat me-1"></i>
                                    Re-enter your new password to confirm
                                </small>
                            </div>
                        </div>

                        <!-- Security Tips -->
                        <div class="row mb-4">
                            <div class="col-md-6 offset-md-4">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-lightbulb me-2"></i>Password Security Tips
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Use at least 8 characters</li>
                                        <li>Include uppercase and lowercase letters</li>
                                        <li>Add numbers and special characters</li>
                                        <li>Avoid common words or personal information</li>
                                        <li>Don't reuse passwords from other accounts</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-danger" id="submit_btn" disabled>
                                    <i class="bi bi-shield-check me-2"></i>{{ __('Update Password') }}
                                </button>
                                <a href="{{ route('profile.show') }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

// Check password strength
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthDiv = document.getElementById('password_strength');
    const progressBar = strengthDiv.querySelector('.progress-bar');
    const strengthText = strengthDiv.querySelector('.strength-text');
    
    if (password.length === 0) {
        strengthDiv.style.display = 'none';
        return;
    }
    
    strengthDiv.style.display = 'block';
    
    let strength = 0;
    let feedback = [];
    
    // Length check
    if (password.length >= 8) strength += 20;
    else feedback.push('at least 8 characters');
    
    // Uppercase check
    if (/[A-Z]/.test(password)) strength += 20;
    else feedback.push('uppercase letter');
    
    // Lowercase check
    if (/[a-z]/.test(password)) strength += 20;
    else feedback.push('lowercase letter');
    
    // Number check
    if (/\d/.test(password)) strength += 20;
    else feedback.push('number');
    
    // Special character check
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 20;
    else feedback.push('special character');
    
    // Update progress bar
    progressBar.style.width = strength + '%';
    
    // Update colors and text
    if (strength < 40) {
        progressBar.className = 'progress-bar bg-danger';
        strengthText.className = 'strength-text text-danger';
        strengthText.textContent = 'Weak - Add: ' + feedback.join(', ');
    } else if (strength < 80) {
        progressBar.className = 'progress-bar bg-warning';
        strengthText.className = 'strength-text text-warning';
        strengthText.textContent = 'Fair - Add: ' + feedback.join(', ');
    } else {
        progressBar.className = 'progress-bar bg-success';
        strengthText.className = 'strength-text text-success';
        strengthText.textContent = 'Strong password!';
    }
    
    checkFormValidity();
}

// Check password match
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const matchDiv = document.getElementById('password_match');
    const matchText = matchDiv.querySelector('.match-text');
    
    if (confirmation.length === 0) {
        matchDiv.style.display = 'none';
        return;
    }
    
    matchDiv.style.display = 'block';
    
    if (password === confirmation) {
        matchText.className = 'match-text text-success';
        matchText.innerHTML = '<i class="bi bi-check-circle me-1"></i>Passwords match';
    } else {
        matchText.className = 'match-text text-danger';
        matchText.innerHTML = '<i class="bi bi-x-circle me-1"></i>Passwords do not match';
    }
    
    checkFormValidity();
}

// Check overall form validity
function checkFormValidity() {
    const currentPassword = document.getElementById('current_password').value;
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const submitBtn = document.getElementById('submit_btn');
    
    const isValid = currentPassword.length > 0 && 
                   password.length >= 8 && 
                   password === confirmation;
    
    submitBtn.disabled = !isValid;
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('current_password').addEventListener('input', checkFormValidity);
    document.getElementById('password').addEventListener('input', function() {
        checkPasswordStrength();
        checkPasswordMatch();
    });
    document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
});
</script>
@endsection
