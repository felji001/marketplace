<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* Include critical styles inline if needed */
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --primary-lighter: #dbeafe;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --transition-fast: 150ms ease-in-out;
            --transition-normal: 250ms ease-in-out;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--gray-50);
        }

        .btn {
            transition: all var(--transition-fast);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-normal);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .whatsapp-btn {
            background-color: #25d366 !important;
            border-color: #25d366 !important;
        }

        .whatsapp-btn:hover {
            background-color: #128c7e !important;
            border-color: #128c7e !important;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .slide-up {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('catalog.index') }}">
                    <i class="bi bi-shop-window me-2 text-primary"></i>
                    <span class="fw-bold">{{ config('app.name', 'Marketplace') }}</span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <!-- Home Link for All Users -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <i class="bi bi-house-door"></i> Home
                                </a>
                            </li>
                        @endauth

                        <!-- Browse Products for All -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}">
                                <i class="bi bi-grid-3x3-gap"></i> Browse Products
                            </a>
                        </li>

                        @auth
                            @if(Auth::user()->hasRole('producer'))
                                <!-- Producer Menu -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : '' }}" href="#" id="producerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-briefcase"></i> Producer Tools
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="producerDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('products.index') }}">
                                                <i class="bi bi-box-seam me-2"></i> My Products
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('products.create') }}">
                                                <i class="bi bi-plus-circle me-2"></i> Add Product
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('categories.index') }}">
                                                <i class="bi bi-tags me-2"></i> Manage Categories
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            @if(Auth::user()->hasRole('buyer'))
                                <!-- Buyer Menu -->
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                        <i class="bi bi-bag-check"></i> My Orders
                                    </a>
                                </li>
                            @endif

                            @if(Auth::user()->hasRole('admin'))
                                <!-- Admin Menu -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear"></i> Admin
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-people me-2"></i> Manage Users
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-graph-up me-2"></i> Analytics
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-shield-check me-2"></i> System Settings
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-1"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <!-- User Profile Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div class="user-avatar me-2">
                                        <i class="bi bi-person-circle fs-5"></i>
                                    </div>
                                    <div class="user-info d-none d-md-block">
                                        <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">
                                            @foreach(Auth::user()->roles as $role)
                                                {{ ucfirst($role->name) }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </small>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <div class="dropdown-header">
                                        <strong>{{ Auth::user()->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                    </a>

                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person me-2"></i> Profile Settings
                                    </a>

                                    @if(Auth::user()->hasRole('producer'))
                                        <a class="dropdown-item" href="{{ route('products.index') }}">
                                            <i class="bi bi-box-seam me-2"></i> My Products
                                        </a>
                                    @endif

                                    @if(Auth::user()->hasRole('buyer'))
                                        <a class="dropdown-item" href="{{ route('orders.index') }}">
                                            <i class="bi bi-bag-check me-2"></i> My Orders
                                        </a>
                                    @endif

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="container mt-4">
                    <div class="alert alert-success alert-dismissible fade show slide-up" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="container mt-4">
                    <div class="alert alert-danger alert-dismissible fade show slide-up" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="container mt-4">
                    <div class="alert alert-warning alert-dismissible fade show slide-up" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <strong>Warning!</strong> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="container mt-4">
                    <div class="alert alert-info alert-dismissible fade show slide-up" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Info!</strong> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="container mt-4">
                    <div class="alert alert-danger alert-dismissible fade show slide-up" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <div class="content-wrapper py-4">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer bg-white border-top mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-primary">{{ config('app.name', 'Marketplace') }}</h6>
                    <p class="text-muted small mb-0">
                        Your trusted marketplace for quality products and services.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end justify-content-start gap-3 mb-2">
                        <a href="#" class="text-muted text-decoration-none small">About</a>
                        <a href="#" class="text-muted text-decoration-none small">Contact</a>
                        <a href="#" class="text-muted text-decoration-none small">Privacy</a>
                        <a href="#" class="text-muted text-decoration-none small">Terms</a>
                    </div>
                    <p class="text-muted small mb-0">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>
