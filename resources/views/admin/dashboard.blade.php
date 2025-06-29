@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Admin Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-header bg-gradient p-4 rounded-3 text-white" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2 text-white">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Admin Dashboard
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            System overview and management tools
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="admin-actions">
                            <a href="{{ route('admin.users') }}" class="btn btn-light btn-lg me-2">
                                <i class="bi bi-people me-2"></i>Manage Users
                            </a>
                            <a href="{{ route('admin.settings') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-gear me-2"></i>Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="bi bi-people display-6 text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Users</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['total_users']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="bi bi-box-seam display-6 text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Products</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['total_products']) }}</h3>
                            <small class="text-success">{{ $stats['active_products'] }} in stock</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="bi bi-receipt display-6 text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['total_orders']) }}</h3>
                            <small class="text-warning">{{ $stats['pending_orders'] }} pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="bi bi-currency-dollar display-6 text-info"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Revenue</h6>
                            <h3 class="fw-bold mb-0">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Activities -->
        <div class="col-lg-8">
            <!-- Recent Users -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2 text-primary"></i>
                        Recent Users
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-person-circle me-2 text-muted"></i>
                                                <strong>{{ $user->name }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-primary me-1">{{ ucfirst($role->name) }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-box-seam me-2 text-success"></i>
                        Recent Products
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Producer</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->hasImages())
                                                    <img src="{{ $product->display_image }}" alt="{{ $product->name }}" 
                                                         class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <i class="bi bi-image me-2 text-muted fs-4"></i>
                                                @endif
                                                <div>
                                                    <strong>{{ Str::limit($product->name, 30) }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->user->name }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td>{{ $product->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-receipt me-2 text-warning"></i>
                        Recent Orders
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_orders as $order)
                                    <tr>
                                        <td><strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Statistics -->
        <div class="col-lg-4">
            <!-- User Roles Distribution -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart me-2 text-info"></i>
                        User Roles
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($user_roles as $role)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge bg-primary me-2">{{ ucfirst($role->name) }}</span>
                            </div>
                            <div>
                                <strong>{{ $role->count }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Category Statistics -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-tags me-2 text-success"></i>
                        Categories
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($category_stats->take(10) as $category)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <i class="bi bi-folder me-1"></i>
                                {{ $category->name }}
                            </div>
                            <div>
                                <span class="badge bg-light text-dark">{{ $category->products_count }}</span>
                            </div>
                        </div>
                    @endforeach
                    @if($category_stats->count() > 10)
                        <div class="text-center mt-3">
                            <small class="text-muted">And {{ $category_stats->count() - 10 }} more...</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2 text-warning"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                            <i class="bi bi-people me-2"></i>Manage Users
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-tags me-2"></i>Manage Categories
                        </a>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-info">
                            <i class="bi bi-shop me-2"></i>View Marketplace
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
