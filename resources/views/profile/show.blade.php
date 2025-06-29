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
                            <i class="bi bi-person-circle me-2"></i>
                            My Profile
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            Manage your account information and settings
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="profile-actions">
                            <a href="{{ route('profile.edit') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-pencil me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Full Name:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fw-semibold">{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Email Address:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fw-semibold">{{ $user->email }}</span>
                            @if($user->email_verified_at)
                                <span class="badge bg-success ms-2">
                                    <i class="bi bi-check-circle me-1"></i>Verified
                                </span>
                            @else
                                <span class="badge bg-warning ms-2">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Unverified
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">WhatsApp Number:</strong>
                        </div>
                        <div class="col-sm-9">
                            @if($user->whatsapp_number)
                                <span class="fw-semibold">{{ $user->whatsapp_number }}</span>
                                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $user->whatsapp_number) }}" 
                                   target="_blank" class="btn btn-sm btn-success ms-2">
                                    <i class="bi bi-whatsapp me-1"></i>Test Contact
                                </a>
                            @else
                                <span class="text-muted">Not provided</span>
                                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="bi bi-plus me-1"></i>Add WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Account Roles:</strong>
                        </div>
                        <div class="col-sm-9">
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary me-1">
                                    <i class="bi bi-person-badge me-1"></i>
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Member Since:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fw-semibold">{{ $user->created_at->format('F j, Y') }}</span>
                            <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <strong class="text-muted">Last Updated:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fw-semibold">{{ $user->updated_at->format('F j, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            @if($user->hasRole('producer'))
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>
                            Producer Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <i class="bi bi-box display-6 text-primary mb-2"></i>
                                    <h4 class="fw-bold">{{ $user->products()->count() }}</h4>
                                    <h6 class="text-muted">Total Products</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <i class="bi bi-check-circle display-6 text-success mb-2"></i>
                                    <h4 class="fw-bold">{{ $user->products()->inStock()->count() }}</h4>
                                    <h6 class="text-muted">In Stock</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <i class="bi bi-cart display-6 text-warning mb-2"></i>
                                    <h4 class="fw-bold">{{ $user->products()->withCount('orderItems')->get()->sum('order_items_count') }}</h4>
                                    <h6 class="text-muted">Total Orders</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($user->hasRole('buyer'))
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-bag-check me-2"></i>
                            Buyer Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="stat-item">
                                    <i class="bi bi-receipt display-6 text-primary mb-2"></i>
                                    <h4 class="fw-bold">{{ $user->orders()->count() }}</h4>
                                    <h6 class="text-muted">Total Orders</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="stat-item">
                                    <i class="bi bi-currency-dollar display-6 text-success mb-2"></i>
                                    <h4 class="fw-bold">${{ number_format($user->orders()->sum('total_amount'), 2) }}</h4>
                                    <h6 class="text-muted">Total Spent</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Actions Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </a>
                        
                        <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-warning">
                            <i class="bi bi-shield-lock me-2"></i>Change Password
                        </a>

                        @if($user->hasRole('producer'))
                            <hr>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-success">
                                <i class="bi bi-box-seam me-2"></i>My Products
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-outline-info">
                                <i class="bi bi-plus-circle me-2"></i>Add Product
                            </a>
                        @endif

                        @if($user->hasRole('buyer'))
                            <hr>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-success">
                                <i class="bi bi-bag-check me-2"></i>My Orders
                            </a>
                            <a href="{{ route('catalog.index') }}" class="btn btn-outline-info">
                                <i class="bi bi-shop me-2"></i>Browse Products
                            </a>
                        @endif

                        @if($user->hasRole('admin'))
                            <hr>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">
                                <i class="bi bi-tags me-2"></i>Manage Categories
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Security -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>
                        Account Security
                    </h5>
                </div>
                <div class="card-body">
                    <div class="security-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Email Verification</strong>
                                <br>
                                <small class="text-muted">Verify your email address</small>
                            </div>
                            <div>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="security-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Password</strong>
                                <br>
                                <small class="text-muted">Last changed: {{ $user->updated_at->format('M j, Y') }}</small>
                            </div>
                            <div>
                                <a href="{{ route('profile.password.edit') }}" class="btn btn-sm btn-outline-primary">
                                    Change
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
