@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="bi bi-pencil me-2 text-primary"></i>
                        Edit User: {{ $user->name }}
                    </h1>
                    <p class="text-muted mb-0">Update user information and roles</p>
                </div>
                <div>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Edit User Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-person-fill me-2"></i>
                        User Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave blank to keep current password. Minimum 8 characters if changing.</div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>

                            <!-- WhatsApp Number -->
                            <div class="col-md-6">
                                <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" 
                                       id="whatsapp_number" name="whatsapp_number" 
                                       value="{{ old('whatsapp_number', $user->whatsapp_number) }}"
                                       placeholder="+212 666-123456">
                                @error('whatsapp_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Verified -->
                            <div class="col-md-6">
                                <label class="form-label">Account Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="email_verified" 
                                           name="email_verified" value="1" 
                                           {{ old('email_verified', $user->email_verified_at ? '1' : '0') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_verified">
                                        Email verified (account active)
                                    </label>
                                </div>
                                <div class="form-text">
                                    Current status: 
                                    <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                        {{ $user->email_verified_at ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>User ID:</strong> {{ $user->id }}<br>
                                            <strong>Created:</strong> {{ $user->created_at->format('M d, Y H:i') }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y H:i') }}<br>
                                            <strong>Products:</strong> {{ $user->products()->count() }} | 
                                            <strong>Orders:</strong> {{ $user->orders()->count() }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Roles -->
                            <div class="col-12">
                                <label class="form-label">User Roles <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    @foreach($roles as $role)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input @error('roles') is-invalid @enderror" 
                                                       type="checkbox" id="role_{{ $role->id }}" 
                                                       name="roles[]" value="{{ $role->id }}"
                                                       {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'producer' ? 'success' : 'info') }} me-2">
                                                        {{ ucfirst($role->name) }}
                                                    </span>
                                                    {{ $role->description }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('roles')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Current roles: 
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'producer' ? 'success' : 'info') }} me-1">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-2"></i>Cancel
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="bi bi-trash me-2"></i>Delete User
                                        </button>
                                    @endif
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Update User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password confirmation validation
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    function validatePasswordConfirmation() {
        if (passwordInput.value && confirmPasswordInput.value !== passwordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match');
            confirmPasswordInput.classList.add('is-invalid');
        } else {
            confirmPasswordInput.setCustomValidity('');
            confirmPasswordInput.classList.remove('is-invalid');
        }
    }

    confirmPasswordInput.addEventListener('input', validatePasswordConfirmation);
    passwordInput.addEventListener('input', validatePasswordConfirmation);

    // Ensure at least one role is selected
    const roleCheckboxes = document.querySelectorAll('input[name="roles[]"]');
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        const checkedRoles = document.querySelectorAll('input[name="roles[]"]:checked');
        if (checkedRoles.length === 0) {
            e.preventDefault();
            alert('Please select at least one role for the user.');
            return false;
        }
    });

    // Delete confirmation function
    window.confirmDelete = function(userId, userName) {
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteForm').action = `/admin/users/${userId}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    };
});
</script>
@endsection
