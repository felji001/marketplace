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
    <!-- CSS is included inline below for compatibility without Node.js -->

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

        /* Enhanced Navigation */
        .navbar {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            border-bottom: 1px solid var(--gray-200);
            padding: 0.75rem 0;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--primary-color) !important;
            text-decoration: none;
            transition: all var(--transition-fast);
        }

        .navbar-brand:hover {
            color: var(--primary-dark) !important;
            transform: scale(1.05);
        }

        .navbar-brand i {
            font-size: 1.2rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--gray-600) !important;
            padding: 0.6rem 1rem !important;
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
            margin: 0 0.2rem;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: var(--primary-lighter);
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background-color: var(--primary-lighter);
            font-weight: 600;
        }

        .nav-link i {
            font-size: 0.9rem;
            margin-right: 0.4rem;
        }

        /* Enhanced Dropdown Menus */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: var(--radius-lg);
            padding: 0.5rem;
            margin-top: 0.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            animation: dropdownFadeIn 0.2s ease-out;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-header {
            font-weight: 600;
            color: var(--gray-700);
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-item {
            border-radius: var(--radius-md);
            padding: 0.6rem 1rem;
            transition: all var(--transition-fast);
            color: var(--gray-700);
            font-weight: 500;
            margin: 0.1rem 0;
        }

        .dropdown-item:hover {
            background-color: var(--primary-lighter);
            color: var(--primary-dark);
            transform: translateX(4px);
        }

        .dropdown-item i {
            font-size: 0.9rem;
            width: 1.2rem;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: var(--gray-200);
        }

        /* User Profile Dropdown */
        .user-avatar i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .user-info {
            line-height: 1.2;
        }

        .user-info .fw-semibold {
            font-size: 0.9rem;
        }

        .user-info small {
            font-size: 0.75rem;
        }

        /* Mobile Navigation */
        .navbar-toggler {
            border: none;
            padding: 0.4rem 0.6rem;
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .navbar-toggler:hover {
            background-color: var(--primary-lighter);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: white;
                border-radius: var(--radius-lg);
                margin-top: 1rem;
                padding: 1rem;
                box-shadow: var(--shadow-md);
            }

            .nav-link {
                margin: 0.2rem 0;
                padding: 0.8rem 1rem !important;
            }

            .dropdown-menu {
                box-shadow: none;
                background: var(--gray-50);
                margin-top: 0.5rem;
                margin-left: 1rem;
            }
        }

        /* Alert Enhancements */
        .alert {
            border: none;
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: var(--success-dark);
            border-left-color: var(--success-color);
        }

        .alert-danger {
            background-color: #fef2f2;
            color: var(--danger-dark);
            border-left-color: var(--danger-color);
        }

        .alert-warning {
            background-color: #fffbeb;
            color: var(--warning-dark);
            border-left-color: var(--warning-color);
        }

        .alert-info {
            background-color: var(--primary-lighter);
            color: var(--primary-dark);
            border-left-color: var(--primary-color);
        }

        /* Form Enhancements */
        .form-control, .form-select {
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            transition: all var(--transition-fast);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: var(--danger-color);
        }

        .form-control.is-valid {
            border-color: var(--success-color);
        }

        .form-label {
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: var(--spacing-sm);
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: var(--spacing-xs);
        }

        .valid-feedback {
            color: var(--success-color);
            font-size: 0.875rem;
            margin-top: var(--spacing-xs);
        }

        /* Dashboard Card Styles */
        .dashboard-card {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            transition: all var(--transition-normal);
            overflow: hidden;
            position: relative;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .dashboard-card .card-body {
            position: relative;
            z-index: 1;
        }

        .dashboard-card.bg-success {
            background: linear-gradient(135deg, var(--success-color), var(--success-dark));
        }

        .dashboard-card.bg-warning {
            background: linear-gradient(135deg, var(--warning-color), var(--warning-dark));
        }

        .dashboard-card.bg-info {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
        }

        /* Category Sidebar Styles */
        .category-sidebar {
            background-color: white;
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .category-sidebar h5 {
            color: var(--gray-800);
            font-weight: 600;
            margin-bottom: var(--spacing-lg);
            padding-bottom: var(--spacing-sm);
            border-bottom: 2px solid var(--gray-200);
        }

        /* Enhanced Search Styles */
        .search-input-wrapper {
            position: relative;
        }

        .search-input {
            padding-right: 80px;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            transition: all var(--transition-fast);
            font-size: 0.95rem;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-input-icons {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 4px;
        }

        .btn-clear-search, .btn-search {
            background: none;
            border: none;
            padding: 6px;
            border-radius: var(--radius-md);
            color: var(--gray-500);
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-search {
            color: var(--primary-color);
        }

        .btn-clear-search:hover {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-search:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .search-focused {
            transform: scale(1.02);
        }

        .search-suggestions .badge {
            transition: all var(--transition-fast);
            cursor: pointer;
            border: 1px solid var(--gray-300);
        }

        /* Enhanced Category Styles */
        .enhanced-category-link, .enhanced-subcategory-link {
            display: block;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
            text-decoration: none;
            border: 1px solid transparent;
            margin-bottom: 0.3rem;
        }

        .category-content, .subcategory-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .category-info, .subcategory-info {
            display: flex;
            align-items: center;
        }

        .category-icon, .subcategory-icon {
            font-size: 0.9rem;
            margin-right: 0.6rem;
            width: 1.2rem;
            text-align: center;
        }

        .category-name, .subcategory-name {
            font-weight: 500;
            color: var(--gray-700);
        }

        .category-count, .subcategory-count {
            background-color: var(--gray-200);
            color: var(--gray-600);
            padding: 0.2rem 0.5rem;
            border-radius: var(--radius-md);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .enhanced-category-link:hover, .enhanced-subcategory-link:hover {
            background-color: var(--primary-lighter);
            border-color: var(--primary-color);
            transform: translateX(4px);
        }

        .enhanced-category-link.active, .enhanced-subcategory-link.active {
            background-color: var(--primary-color);
            border-color: var(--primary-dark);
            color: white;
        }

        .enhanced-category-link.active .category-name,
        .enhanced-subcategory-link.active .subcategory-name {
            color: white;
        }

        .enhanced-category-link.active .category-count,
        .enhanced-subcategory-link.active .subcategory-count {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .subcategories {
            margin-left: 1rem;
            margin-top: 0.5rem;
            border-left: 2px solid var(--gray-200);
            padding-left: 1rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .subcategories.expanded {
            max-height: 500px;
        }

        /* Enhanced Sort Dropdown */
        .enhanced-sort-btn {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all var(--transition-fast);
        }

        .enhanced-sort-btn:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .enhanced-sort-btn.dropdown-open {
            background-color: var(--primary-color);
            color: white;
        }

        .enhanced-sort-menu {
            min-width: 280px;
            padding: 0.5rem;
        }

        .enhanced-sort-item {
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            margin: 0.2rem 0;
        }

        .sort-item-content {
            display: flex;
            align-items: center;
        }

        .sort-icon {
            font-size: 1rem;
            margin-right: 0.75rem;
            width: 1.2rem;
            color: var(--primary-color);
        }

        .sort-item-text {
            flex: 1;
        }

        .sort-name {
            display: block;
            font-weight: 500;
            color: var(--gray-800);
        }

        .sort-desc {
            display: block;
            color: var(--gray-500);
            font-size: 0.8rem;
        }

        .enhanced-sort-item.active {
            background-color: var(--primary-lighter);
            border-left: 3px solid var(--primary-color);
        }

        .enhanced-sort-item:hover {
            background-color: var(--gray-100);
        }

        /* Modern Pagination Styles */
        .modern-pagination-wrapper {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .results-summary {
            display: flex;
            align-items: center;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .results-text strong {
            color: var(--primary-color);
            font-weight: 600;
        }

        .pagination-list {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.3rem;
        }

        .pagination-item {
            display: flex;
        }

        .pagination-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 0.8rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-fast);
            min-width: 2.5rem;
            justify-content: center;
        }

        .pagination-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .pagination-item.active .pagination-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .pagination-item.disabled .pagination-link {
            color: var(--gray-400);
            background-color: var(--gray-100);
            border-color: var(--gray-200);
            cursor: not-allowed;
        }

        .pagination-item.disabled .pagination-link:hover {
            transform: none;
        }

        /* Icon Size Standardization */
        .bi {
            font-size: 1rem;
        }

        .navbar .bi {
            font-size: 0.9rem;
        }

        .btn .bi {
            font-size: 0.85rem;
        }

        .card-header .bi {
            font-size: 1rem;
        }

        .display-1 .bi {
            font-size: 4rem;
        }

        .display-4 .bi {
            font-size: 2.5rem;
        }

        .display-6 .bi {
            font-size: 1.5rem;
        }

        /* Loading States */
        .loading-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        .enhanced-category-link.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: var(--spacing-md);
                padding-right: var(--spacing-md);
            }

            .card-body {
                padding: var(--spacing-md);
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            h1 { font-size: 1.75rem; }
            h2 { font-size: 1.5rem; }
            h3 { font-size: 1.25rem; }

            .product-card:hover {
                transform: none;
            }

            .category-sidebar {
                margin-bottom: var(--spacing-lg);
            }

            .pagination-container {
                flex-direction: column;
                text-align: center;
            }

            .pagination-list {
                justify-content: center;
                flex-wrap: wrap;
            }

            .sort-controls {
                justify-content: center !important;
                margin-top: 1rem;
            }

            .enhanced-sort-menu {
                min-width: 250px;
            }
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
