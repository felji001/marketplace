@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="bi bi-gear me-2 text-primary"></i>
                        System Settings
                    </h1>
                    <p class="text-muted mb-0">Configure system settings and preferences</p>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Cards -->
    <div class="row g-4">
        <!-- Category Management -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-tags me-2 text-success"></i>
                        Category Management
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Manage product categories and their organization.</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>Total Categories</strong>
                            <div class="text-muted">{{ \App\Models\Category::count() }} categories</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success fs-6">{{ \App\Models\Category::whereNull('parent_id')->count() }}</span>
                            <div class="text-muted small">Root categories</div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <a href="{{ route('categories.index') }}" class="btn btn-success">
                            <i class="bi bi-tags me-2"></i>
                            Manage Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Statistics -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-people me-2 text-info"></i>
                        User Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Overview of user roles and activity.</p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-4 text-center">
                            <div class="fw-bold fs-4 text-danger">{{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'admin'); })->count() }}</div>
                            <small class="text-muted">Admins</small>
                        </div>
                        <div class="col-4 text-center">
                            <div class="fw-bold fs-4 text-success">{{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'producer'); })->count() }}</div>
                            <small class="text-muted">Producers</small>
                        </div>
                        <div class="col-4 text-center">
                            <div class="fw-bold fs-4 text-info">{{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'buyer'); })->count() }}</div>
                            <small class="text-muted">Buyers</small>
                        </div>
                    </div>

                    <div class="d-grid">
                        <a href="{{ route('admin.users') }}" class="btn btn-info">
                            <i class="bi bi-people me-2"></i>
                            Manage Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2 text-warning"></i>
                        System Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Laravel Version:</span>
                                <span class="fw-semibold">{{ app()->version() }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">PHP Version:</span>
                                <span class="fw-semibold">{{ PHP_VERSION }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Environment:</span>
                                <span class="badge bg-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">
                                    {{ ucfirst(app()->environment()) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Debug Mode:</span>
                                <span class="badge bg-{{ config('app.debug') ? 'warning' : 'success' }}">
                                    {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketplace Statistics -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2 text-primary"></i>
                        Marketplace Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="fw-bold fs-4 text-primary">{{ \App\Models\Product::count() }}</div>
                                <small class="text-muted">Total Products</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="fw-bold fs-4 text-success">{{ \App\Models\Product::where('stock', '>', 0)->count() }}</div>
                                <small class="text-muted">In Stock</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="fw-bold fs-4 text-warning">{{ \App\Models\Order::count() }}</div>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="fw-bold fs-4 text-info">${{ number_format(\App\Models\Order::sum('total_amount'), 2) }}</div>
                                <small class="text-muted">Total Revenue</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-shop me-2"></i>
                            View Marketplace
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
