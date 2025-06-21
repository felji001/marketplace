@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header bg-gradient p-4 rounded-3 text-white" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2 text-white">
                            <i class="bi bi-sun me-2"></i>
                            Welcome back, {{ Auth::user()->name }}!
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            Ready to manage your marketplace activities? Here's your dashboard overview.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="user-roles">
                            @foreach(Auth::user()->roles as $role)
                                <span class="badge bg-light text-primary fs-6 me-1">
                                    <i class="bi bi-person-badge me-1"></i>
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </div>
                        <small class="text-white-50 d-block mt-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ now()->format('l, F j, Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Dashboard Cards -->
    <div class="row g-4">
        @if(Auth::user()->hasRole('producer'))
            <!-- Producer Dashboard Cards -->
            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-primary text-white h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mb-3">
                            <i class="bi bi-box-seam display-4"></i>
                        </div>
                        <h5 class="card-title fw-bold">My Products</h5>
                        <p class="card-text opacity-90">Manage and track your product listings</p>
                        <div class="mt-auto">
                            <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-arrow-right me-1"></i> View Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-success text-white h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mb-3">
                            <i class="bi bi-plus-circle display-4"></i>
                        </div>
                        <h5 class="card-title fw-bold">Add Product</h5>
                        <p class="card-text opacity-90">List a new product for sale</p>
                        <div class="mt-auto">
                            <a href="{{ route('products.create') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-plus me-1"></i> Add Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-info text-white h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mb-3">
                            <i class="bi bi-tags display-4"></i>
                        </div>
                        <h5 class="card-title fw-bold">Categories</h5>
                        <p class="card-text opacity-90">Organize your product categories</p>
                        <div class="mt-auto">
                            <a href="{{ route('categories.index') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-gear me-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::user()->hasRole('buyer'))
            <!-- Buyer Dashboard Cards -->
            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-primary text-white h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mb-3">
                            <i class="bi bi-shop display-4"></i>
                        </div>
                        <h5 class="card-title fw-bold">Browse Products</h5>
                        <p class="card-text opacity-90">Discover amazing products from sellers</p>
                        <div class="mt-auto">
                            <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-search me-1"></i> Browse Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-success text-white h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mb-3">
                            <i class="bi bi-bag-check display-4"></i>
                        </div>
                        <h5 class="card-title fw-bold">My Orders</h5>
                        <p class="card-text opacity-90">Track your purchase history</p>
                        <div class="mt-auto">
                            <a href="{{ route('orders.index') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-list-check me-1"></i> View Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Common Dashboard Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card dashboard-card bg-warning text-white h-100">
                <div class="card-body text-center p-4">
                    <div class="dashboard-icon mb-3">
                        <i class="bi bi-grid-3x3-gap display-4"></i>
                    </div>
                    <h5 class="card-title fw-bold">Marketplace</h5>
                    <p class="card-text opacity-90">Explore all available products</p>
                    <div class="mt-auto">
                        <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-compass me-1"></i> Explore
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        Quick Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <i class="bi bi-people display-6 text-primary mb-2"></i>
                                <h6 class="text-muted">Active Users</h6>
                                <h4 class="fw-bold">{{ \App\Models\User::count() }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <i class="bi bi-box display-6 text-success mb-2"></i>
                                <h6 class="text-muted">Total Products</h6>
                                <h4 class="fw-bold">{{ \App\Models\Product::count() }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <i class="bi bi-tags display-6 text-info mb-2"></i>
                                <h6 class="text-muted">Categories</h6>
                                <h4 class="fw-bold">{{ \App\Models\Category::count() }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <i class="bi bi-cart display-6 text-warning mb-2"></i>
                                <h6 class="text-muted">Orders</h6>
                                <h4 class="fw-bold">{{ \App\Models\Order::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
