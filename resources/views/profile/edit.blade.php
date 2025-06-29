@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="profile-header bg-gradient p-4 rounded-3 text-white" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2 text-white">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Profile
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            Update your account information and preferences
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
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-gear me-2"></i>
                        Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Full Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    This name will be displayed to other users
                                </small>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if($user->email_verified_at)
                                    <small class="form-text text-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Email verified on {{ $user->email_verified_at->format('M j, Y') }}
                                    </small>
                                @else
                                    <small class="form-text text-warning">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Email not verified. Check your inbox for verification email.
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- WhatsApp Number Field -->
                        <div class="row mb-3">
                            <label for="whatsapp_number" class="col-md-4 col-form-label text-md-end">{{ __('WhatsApp Number') }}</label>

                            <div class="col-md-6">
                                <input id="whatsapp_number" type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" 
                                       name="whatsapp_number" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" 
                                       placeholder="+1 234 567 8900" autocomplete="tel">

                                @error('whatsapp_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <small class="form-text text-muted">
                                    <i class="bi bi-whatsapp me-1"></i>
                                    Include country code (e.g., +1 for US, +212 for Morocco). This allows buyers to contact you directly.
                                </small>
                            </div>
                        </div>

                        <!-- Account Roles Display -->
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Account Roles') }}</label>

                            <div class="col-md-6">
                                <div class="form-control-plaintext">
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary me-1">
                                            <i class="bi bi-person-badge me-1"></i>
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Contact an administrator to change your account roles
                                </small>
                            </div>
                        </div>

                        <!-- Account Information Display -->
                        <div class="row mb-4">
                            <div class="col-md-6 offset-md-4">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-info-circle me-2"></i>Account Information
                                    </h6>
                                    <hr>
                                    <p class="mb-1"><strong>Member Since:</strong> {{ $user->created_at->format('F j, Y') }}</p>
                                    <p class="mb-1"><strong>Last Updated:</strong> {{ $user->updated_at->format('F j, Y g:i A') }}</p>
                                    <p class="mb-0"><strong>Account ID:</strong> #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>{{ __('Update Profile') }}
                                </button>
                                <a href="{{ route('profile.show') }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Actions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Additional Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-grid">
                                <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-warning">
                                    <i class="bi bi-shield-lock me-2"></i>Change Password
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid">
                                <a href="{{ route('home') }}" class="btn btn-outline-info">
                                    <i class="bi bi-house-door me-2"></i>Go to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // WhatsApp number formatting
    const whatsappInput = document.getElementById('whatsapp_number');
    
    if (whatsappInput) {
        whatsappInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, ''); // Remove non-digits
            
            // Add + if not present and has digits
            if (value.length > 0 && !this.value.startsWith('+')) {
                this.value = '+' + value;
            }
        });

        // Validate WhatsApp number format
        whatsappInput.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value && !value.match(/^\+\d{10,15}$/)) {
                this.classList.add('is-invalid');
                
                // Add or update error message
                let feedback = this.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    this.parentNode.appendChild(feedback);
                }
                feedback.innerHTML = '<strong>Please enter a valid WhatsApp number with country code (e.g., +1234567890)</strong>';
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback && !feedback.hasAttribute('data-server-error')) {
                    feedback.remove();
                }
            }
        });
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const whatsappValue = whatsappInput.value.trim();
        
        if (whatsappValue && !whatsappValue.match(/^\+\d{10,15}$/)) {
            e.preventDefault();
            whatsappInput.focus();
            alert('Please enter a valid WhatsApp number with country code.');
        }
    });
});
</script>
@endsection
