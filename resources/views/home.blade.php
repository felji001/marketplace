@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Enhanced Welcome Header with Modern Design -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="welcome-header position-relative overflow-hidden rounded-4 shadow-lg"
                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); min-height: 200px;">
                <!-- Animated Background Elements -->
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                    </div>
                </div>

                <div class="position-relative p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-7">
                            <div class="welcome-content">
                                <div class="greeting-animation mb-3">
                                    <h1 class="display-5 fw-bold text-white mb-3 fade-in-up">
                                        <i class="bi bi-sun me-3 text-warning"></i>
                                        Welcome back, <span class="text-warning">{{ Auth::user()->name }}</span>!
                                    </h1>
                                </div>
                                <p class="lead text-white mb-4 opacity-90 fade-in-up" style="animation-delay: 0.2s;">
                                    <i class="bi bi-rocket me-2"></i>
                                    Ready to manage your marketplace activities? Here's your personalized dashboard overview.
                                </p>
                                <div class="quick-stats d-flex flex-wrap gap-3 fade-in-up" style="animation-delay: 0.4s;">
                                    <div class="stat-item px-3 py-2">
                                        <i class="bi bi-calendar-check text-warning me-2"></i>
                                        <small class="text-white">Last login: {{ Auth::user()->updated_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="stat-item px-3 py-2">
                                        <i class="bi bi-shield-check text-success me-2"></i>
                                        <small class="text-white">Account verified</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 text-md-end">
                            <div class="user-profile-section fade-in-up" style="animation-delay: 0.6s;">




                                <!-- Member Since & Current Date -->
                                <div class="user-stats">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-calendar-heart text-warning me-2"></i>
                                            <div class="text-center">
                                                <small class="text-white opacity-90 d-block">Member since</small>
                                                <strong class="text-white">{{ Auth::user()->created_at->format('M Y') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-white d-block">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ now()->format('l, M j') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <!-- Enhanced Dashboard Cards with Modern Design -->
    <div class="row g-4 dashboard-cards-container">
        @if(Auth::user()->hasRole('admin') && !Auth::user()->hasAnyRole(['producer', 'buyer']))
            <!-- Admin-Only Dashboard Cards -->
            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale">
                            <i class="bi bi-speedometer2 display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">Admin Dashboard</h5>
                        <p class="card-text text-white opacity-90 mb-4">Access comprehensive system management tools</p>

                        <!-- Quick Stats -->
                        <div class="quick-stat bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="stat-number text-white fw-bold fs-4">{{ \App\Models\User::count() }}</div>
                                    <small class="text-white opacity-75">Users</small>
                                </div>
                                <div class="col-6">
                                    <div class="stat-number text-white fw-bold fs-4">{{ \App\Models\Order::count() }}</div>
                                    <small class="text-white opacity-75">Orders</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-arrow-right me-2"></i> Admin Panel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #6f42c1 0%, #5a2d91 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale" style="animation-delay: 0.1s;">
                            <i class="bi bi-people display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">User Management</h5>
                        <p class="card-text text-white opacity-90 mb-4">Manage users, roles, and permissions</p>

                        <!-- User Stats -->
                        <div class="quick-stat bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                            <div class="text-center">
                                <div class="stat-number text-white fw-bold fs-4">{{ \App\Models\User::whereHas('roles')->count() }}</div>
                                <small class="text-white opacity-75">Active Users</small>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('admin.users') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-people me-2"></i> Manage Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale" style="animation-delay: 0.2s;">
                            <i class="bi bi-tags display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">Category Management</h5>
                        <p class="card-text text-white opacity-90 mb-4">Organize and manage product categories</p>

                        <!-- Category Stats -->
                        <div class="quick-stat bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                            <div class="text-center">
                                <div class="stat-number text-white fw-bold fs-4">{{ \App\Models\Category::count() }}</div>
                                <small class="text-white opacity-75">Categories</small>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('categories.index') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-tags me-2"></i> Manage Categories
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::user()->hasRole('producer'))
            <!-- Producer Dashboard Cards -->
            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale">
                            <i class="bi bi-box-seam display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">My Products</h5>
                        <p class="card-text text-white opacity-90 mb-4">Manage and track your product listings with ease</p>

                        <!-- Quick Stats -->
                        <div class="quick-stat bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="stat-number text-white fw-bold fs-4">{{ Auth::user()->products()->count() }}</div>
                                    <small class="text-white opacity-75">Products</small>
                                </div>
                                <div class="col-6">
                                    <div class="stat-number text-white fw-bold fs-4">{{ Auth::user()->products()->where('stock', '>', 0)->count() }}</div>
                                    <small class="text-white opacity-75">In Stock</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('products.index') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-arrow-right me-2"></i> View Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale" style="animation-delay: 0.1s;">
                            <i class="bi bi-plus-circle display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">Add Product</h5>
                        <p class="card-text text-white opacity-90 mb-4">List a new product and start selling today</p>

                        <!-- Quick Action Buttons -->
                        <div class="quick-actions mb-4">
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge bg-dark bg-opacity-25 text-white px-3 py-2 rounded-pill">
                                    <i class="bi bi-lightning me-1"></i>Quick Setup
                                </span>
                                <span class="badge bg-dark bg-opacity-25 text-white px-3 py-2 rounded-pill">
                                    <i class="bi bi-image me-1"></i>Photo Upload
                                </span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('products.create') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-plus me-2"></i> Add Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #e91e63 0%, #ad1457 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale" style="animation-delay: 0.2s;">
                            <i class="bi bi-tags display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">Categories</h5>
                        <p class="card-text text-white opacity-90 mb-4">Organize your product categories efficiently</p>

                        <!-- Category Stats -->
                        <div class="quick-stat bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                            <div class="text-center">
                                <div class="stat-number text-white fw-bold fs-4">{{ \App\Models\Category::count() }}</div>
                                <small class="text-white opacity-75">Total Categories</small>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('categories.index') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-gear me-2"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::user()->hasRole('buyer'))
            <!-- Buyer Dashboard Cards -->
            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale">
                            <i class="bi bi-shop display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">Browse Products</h5>
                        <p class="card-text text-white opacity-90 mb-4">Discover amazing products from trusted sellers</p>

                        <!-- Browse Stats -->
                        <div class="quick-stat bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                            <div class="text-center">
                                <div class="stat-number text-white fw-bold fs-4">{{ \App\Models\Product::where('stock', '>', 0)->count() }}</div>
                                <small class="text-white opacity-75">Available Products</small>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('catalog.index') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-search me-2"></i> Browse Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                     style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">

                    <div class="card-body text-center p-5">
                        <div class="dashboard-icon mb-4 fade-in-scale" style="animation-delay: 0.1s;">
                            <i class="bi bi-bag-check display-3 text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">My Orders</h5>
                        <p class="card-text text-white opacity-90 mb-4">Track your purchase history and orders</p>

                        <!-- Order Stats -->
                        <div class="quick-stat bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                            <div class="text-center">
                                <div class="stat-number text-white fw-bold fs-4">{{ Auth::user()->orders()->count() }}</div>
                                <small class="text-white opacity-75">Total Orders</small>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('orders.index') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-list-check me-2"></i> View Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Common Dashboard Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card modern-dashboard-card h-100 border-0 shadow-lg"
                 style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">

                <div class="card-body text-center p-5">
                    <div class="dashboard-icon mb-4 fade-in-scale" style="animation-delay: 0.3s;">
                        <i class="bi bi-grid-3x3-gap display-3 text-dark"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-3">Marketplace</h5>
                    <p class="card-text text-dark opacity-80 mb-4">Explore all available products and categories</p>

                    <!-- Marketplace Stats -->
                    <div class="quick-stat rounded-3 p-3 mb-4">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-number text-dark fw-bold fs-5">{{ \App\Models\Product::count() }}</div>
                                <small class="text-dark opacity-75">Products</small>
                            </div>
                            <div class="col-6">
                                <div class="stat-number text-dark fw-bold fs-5">{{ \App\Models\Category::count() }}</div>
                                <small class="text-dark opacity-75">Categories</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="{{ route('catalog.index') }}" class="btn btn-dark btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                            <i class="bi bi-compass me-2"></i> Explore
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Quick Stats Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-gradient text-white border-0 p-4"
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-graph-up me-2"></i>
                        Marketplace Overview
                    </h5>
                    <small class="opacity-90">Real-time statistics and insights</small>
                </div>
                <div class="card-body p-5">
                    <div class="row g-4 text-center">
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-item modern-stat-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #667eea20, #764ba220);">
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-people display-4 text-primary"></i>
                                </div>
                                <h6 class="text-muted mb-2">Active Users</h6>
                                <h3 class="fw-bold text-primary mb-0 counter" data-target="{{ \App\Models\User::count() }}">0</h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up me-1"></i>Growing community
                                </small>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-item modern-stat-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #11998e20, #38ef7d20);">
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-box display-4 text-success"></i>
                                </div>
                                <h6 class="text-muted mb-2">Total Products</h6>
                                <h3 class="fw-bold text-success mb-0 counter" data-target="{{ \App\Models\Product::count() }}">0</h3>
                                <small class="text-info">
                                    <i class="bi bi-plus-circle me-1"></i>{{ \App\Models\Product::where('stock', '>', 0)->count() }} available
                                </small>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-item modern-stat-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #ff9a9e20, #fecfef20);">
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-tags display-4 text-info"></i>
                                </div>
                                <h6 class="text-muted mb-2">Categories</h6>
                                <h3 class="fw-bold text-info mb-0 counter" data-target="{{ \App\Models\Category::count() }}">0</h3>
                                <small class="text-primary">
                                    <i class="bi bi-grid me-1"></i>Well organized
                                </small>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-item modern-stat-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #ffecd220, #fcb69f20);">
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-cart display-4 text-warning"></i>
                                </div>
                                <h6 class="text-muted mb-2">Total Orders</h6>
                                <h3 class="fw-bold text-warning mb-0 counter" data-target="{{ \App\Models\Order::count() }}">0</h3>
                                <small class="text-success">
                                    <i class="bi bi-check-circle me-1"></i>Successful transactions
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced CSS Animations and Styles -->
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

/* Fade in animations */
.fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
    transform: translateY(30px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-scale {
    animation: fadeInScale 0.6s ease-out forwards;
    opacity: 0;
    transform: scale(0.8);
}

@keyframes fadeInScale {
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Modern dashboard card enhancements */
.modern-dashboard-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.modern-dashboard-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.modern-dashboard-card .icon-wrapper {
    transition: all 0.3s ease;
}

.modern-dashboard-card:hover .icon-wrapper {
    transform: scale(1.1) rotate(5deg);
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Modern stat cards */
.modern-stat-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.modern-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Counter animation */
.counter {
    transition: all 0.3s ease;
}

/* Responsive enhancements */
@media (max-width: 768px) {
    .welcome-header {
        min-height: 150px !important;
    }

    .welcome-header .p-5 {
        padding: 2rem !important;
    }

    .modern-dashboard-card:hover {
        transform: none;
    }

    .quick-stats {
        justify-content: center !important;
    }

    .user-profile-section {
        text-align: center !important;
        margin-top: 2rem;
    }
}
</style>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 16);
    };

    // Intersection Observer for counter animation
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                animateCounter(counter);
                observer.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));

    // Enhanced card interactions
    const dashboardCards = document.querySelectorAll('.modern-dashboard-card');
    dashboardCards.forEach((card, index) => {
        // Staggered animation on load
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-up');

        // Click ripple effect
        card.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255,255,255,0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
                z-index: 1;
            `;

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Add ripple animation CSS
const rippleCSS = `
@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;

const style = document.createElement('style');
style.textContent = rippleCSS;
document.head.appendChild(style);
</script>
@endsection
