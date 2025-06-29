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

    <!-- Modern Animations CSS -->
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">

    <!-- Mobile Responsive CSS -->
    <link href="{{ asset('css/mobile-responsive.css') }}" rel="stylesheet">

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

        /* Additional Button Sizes */
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: var(--radius-sm);
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

        /* Enhanced Navigation Styles */
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
            transition: all 0.3s ease;
            padding: 0.5rem 0; /* Reduced padding for smaller navbar */
        }

        .navbar.scrolled {
            box-shadow: 0 2px 20px rgba(0,0,0,0.1) !important;
        }

        /* Modern Brand Styling */
        .modern-brand {
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .modern-brand:hover {
            transform: scale(1.05);
        }

        .brand-icon-wrapper {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .brand-icon {
            font-size: 1.1rem;
            color: white !important;
        }

        .modern-brand:hover .brand-icon-wrapper {
            transform: rotate(5deg) scale(1.1);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        }

        /* Compact navbar styling */
        .navbar-brand {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .brand-text .fw-bold {
            line-height: 1.2;
        }

        /* Modern Toggle Button */
        .modern-toggler {
            width: 40px;
            height: 40px;
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
        }

        .toggler-line {
            display: block;
            width: 25px;
            height: 3px;
            background: var(--primary-color);
            margin: 5px auto;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .modern-toggler:not(.collapsed) .toggler-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .modern-toggler:not(.collapsed) .toggler-line:nth-child(2) {
            opacity: 0;
        }

        .modern-toggler:not(.collapsed) .toggler-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Modern Navigation Links */
        .modern-nav-link {
            position: relative;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
            font-weight: 500;
        }

        .modern-nav-link:hover {
            background: var(--primary-lighter);
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .modern-nav-link.active {
            background: var(--primary-color);
            color: white !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .modern-nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        /* Modern Dropdown Menus */
        .modern-dropdown {
            border-radius: 12px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            min-width: 280px;
            background: white;
            backdrop-filter: blur(10px);
        }

        .modern-dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            background: none;
        }

        .modern-dropdown-item:hover {
            background: var(--gray-50);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .dropdown-item-content {
            display: flex;
            align-items: center;
        }

        .dropdown-item-content i {
            width: 20px;
            text-align: center;
        }

        /* User Dropdown Enhancements */
        .modern-user-dropdown {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            background: var(--gray-50);
        }

        .modern-user-dropdown:hover {
            background: var(--primary-lighter);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .avatar-circle {
            transition: all 0.3s ease;
        }

        .modern-user-dropdown:hover .avatar-circle {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        /* Mobile Navigation Enhancements */
        @media (max-width: 991.98px) {
            /* Compact navbar on mobile */
            .navbar {
                padding: 0.25rem 0;
            }

            .brand-icon-wrapper {
                width: 32px;
                height: 32px;
            }

            .brand-icon {
                font-size: 1rem;
            }

            .navbar-brand .fw-bold {
                font-size: 1.1rem !important;
            }

            .navbar-collapse {
                background: white;
                border-radius: 12px;
                margin-top: 1rem;
                padding: 1rem;
                box-shadow: 0 4px 25px rgba(0,0,0,0.1);
            }

            .modern-nav-link {
                margin: 0.25rem 0;
                text-align: center;
            }

            .modern-dropdown {
                position: static !important;
                transform: none !important;
                box-shadow: none;
                border: 1px solid var(--gray-200);
                margin: 0.5rem 0;
            }

            .brand-text small {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Enhanced Modern Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-lg border-bottom-0 sticky-top">
            <div class="container-fluid px-4">
                <!-- Compact Brand -->
                <a class="navbar-brand d-flex align-items-center modern-brand" href="{{ route('catalog.index') }}">
                    <div class="brand-icon-wrapper me-2">
                        <i class="bi bi-shop-window text-primary brand-icon"></i>
                    </div>
                    <div class="brand-text">
                        <span class="fw-bold fs-5 text-dark">{{ config('app.name', 'Marketplace') }}</span>
                    </div>
                </a>

                <!-- Enhanced Mobile Toggle -->
                <button class="navbar-toggler modern-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="toggler-line"></span>
                    <span class="toggler-line"></span>
                    <span class="toggler-line"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Enhanced Left Side Navigation -->
                    <ul class="navbar-nav me-auto align-items-lg-center">
                        @auth
                            <!-- Home Link for All Users -->
                            <li class="nav-item">
                                <a class="nav-link modern-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <i class="bi bi-house-door me-2"></i>
                                    <span>Home</span>
                                </a>
                            </li>
                        @endauth

                        @auth
                            @if(Auth::user()->hasRole('producer'))
                                <!-- Enhanced Producer Menu -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle modern-nav-link {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : '' }}"
                                       href="#" id="producerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-briefcase me-2"></i>
                                        <span>Producer Tools</span>
                                    </a>
                                    <ul class="dropdown-menu modern-dropdown shadow-lg border-0" aria-labelledby="producerDropdown">
                                        <li class="dropdown-header">
                                            <i class="bi bi-person-workspace me-2"></i>Product Management
                                        </li>
                                        <li>
                                            <a class="dropdown-item modern-dropdown-item" href="{{ route('products.index') }}">
                                                <div class="dropdown-item-content">
                                                    <i class="bi bi-box-seam me-3 text-primary"></i>
                                                    <div>
                                                        <div class="fw-semibold">My Products</div>
                                                        <small class="text-muted">View and manage your listings</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item modern-dropdown-item" href="{{ route('products.create') }}">
                                                <div class="dropdown-item-content">
                                                    <i class="bi bi-plus-circle me-3 text-success"></i>
                                                    <div>
                                                        <div class="fw-semibold">Add Product</div>
                                                        <small class="text-muted">Create new product listing</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-header">
                                            <i class="bi bi-gear me-2"></i>Organization
                                        </li>
                                        <li>
                                            <a class="dropdown-item modern-dropdown-item" href="{{ route('categories.index') }}">
                                                <div class="dropdown-item-content">
                                                    <i class="bi bi-tags me-3 text-info"></i>
                                                    <div>
                                                        <div class="fw-semibold">Manage Categories</div>
                                                        <small class="text-muted">Organize product categories</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            @if(Auth::user()->hasRole('buyer'))
                                <!-- Enhanced Buyer Menu -->
                                <li class="nav-item">
                                    <a class="nav-link modern-nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                        <i class="bi bi-bag-check me-2"></i>
                                        <span>My Orders</span>
                                        @if(Auth::user()->orders()->where('status', 'pending')->count() > 0)
                                            <span class="badge bg-warning text-dark ms-2">{{ Auth::user()->orders()->where('status', 'pending')->count() }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif

                            @if(Auth::user()->hasRole('admin'))
                                <!-- Enhanced Admin Menu -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle modern-nav-link" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-shield-check me-2"></i>
                                        <span>Admin</span>
                                    </a>
                                    <ul class="dropdown-menu modern-dropdown shadow-lg border-0" aria-labelledby="adminDropdown">
                                        <li class="dropdown-header">
                                            <i class="bi bi-shield-lock me-2"></i>Administration
                                        </li>
                                        <li>
                                            <a class="dropdown-item modern-dropdown-item" href="{{ route('admin.dashboard') }}">
                                                <div class="dropdown-item-content">
                                                    <i class="bi bi-speedometer2 me-3 text-primary"></i>
                                                    <div>
                                                        <div class="fw-semibold">Admin Dashboard</div>
                                                        <small class="text-muted">System overview and analytics</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item modern-dropdown-item" href="{{ route('admin.users') }}">
                                                <div class="dropdown-item-content">
                                                    <i class="bi bi-people me-3 text-success"></i>
                                                    <div>
                                                        <div class="fw-semibold">Manage Users</div>
                                                        <small class="text-muted">User accounts and roles</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item modern-dropdown-item" href="{{ route('categories.index') }}">
                                                <div class="dropdown-item-content">
                                                    <i class="bi bi-tags me-3 text-info"></i>
                                                    <div>
                                                        <div class="fw-semibold">Manage Categories</div>
                                                        <small class="text-muted">Product categorization</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item modern-dropdown-item" href="{{ route('admin.settings') }}">
                                                <div class="dropdown-item-content">
                                                    <i class="bi bi-gear me-3 text-warning"></i>
                                                    <div>
                                                        <div class="fw-semibold">System Settings</div>
                                                        <small class="text-muted">Configuration and preferences</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Enhanced Right Side Navigation -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link modern-nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        <span>{{ __('Login') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-primary btn-sm ms-3 px-4 py-2 rounded-pill shadow-sm" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-2"></i>{{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <!-- Enhanced User Profile Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle modern-user-dropdown d-flex align-items-center"
                                   href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div class="user-avatar me-3">
                                        <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    </div>
                                    <div class="user-info d-none d-lg-block">
                                        <div class="fw-semibold text-dark">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">
                                            @foreach(Auth::user()->roles as $role)
                                                {{ ucfirst($role->name) }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </small>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end modern-dropdown shadow-lg border-0" aria-labelledby="navbarDropdown">
                                    <!-- User Profile Header -->
                                    <div class="dropdown-header bg-light rounded-top p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-person-fill fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block">{{ Auth::user()->name }}</strong>
                                                <small class="text-muted">{{ Auth::user()->email }}</small>
                                                <div class="mt-1">
                                                    @foreach(Auth::user()->roles as $role)
                                                        <span class="badge bg-primary bg-opacity-10 text-primary me-1">{{ ucfirst($role->name) }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>

                                    <!-- Navigation Items -->
                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('home') }}">
                                        <div class="dropdown-item-content">
                                            <i class="bi bi-speedometer2 me-3 text-primary"></i>
                                            <div>
                                                <div class="fw-semibold">Dashboard</div>
                                                <small class="text-muted">Your personal overview</small>
                                            </div>
                                        </div>
                                    </a>

                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('profile.show') }}">
                                        <div class="dropdown-item-content">
                                            <i class="bi bi-person me-3 text-success"></i>
                                            <div>
                                                <div class="fw-semibold">Profile Settings</div>
                                                <small class="text-muted">Manage your account</small>
                                            </div>
                                        </div>
                                    </a>

                                    @if(Auth::user()->hasRole('producer'))
                                        <a class="dropdown-item modern-dropdown-item" href="{{ route('products.index') }}">
                                            <div class="dropdown-item-content">
                                                <i class="bi bi-box-seam me-3 text-info"></i>
                                                <div>
                                                    <div class="fw-semibold">My Products</div>
                                                    <small class="text-muted">{{ Auth::user()->products()->count() }} products</small>
                                                </div>
                                            </div>
                                        </a>
                                    @endif

                                    @if(Auth::user()->hasRole('buyer'))
                                        <a class="dropdown-item modern-dropdown-item" href="{{ route('orders.index') }}">
                                            <div class="dropdown-item-content">
                                                <i class="bi bi-bag-check me-3 text-warning"></i>
                                                <div>
                                                    <div class="fw-semibold">My Orders</div>
                                                    <small class="text-muted">{{ Auth::user()->orders()->count() }} orders</small>
                                                </div>
                                            </div>
                                        </a>
                                    @endif

                                    <div class="dropdown-divider"></div>

                                    <!-- Logout -->
                                    <a class="dropdown-item modern-dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <div class="dropdown-item-content">
                                            <i class="bi bi-box-arrow-right me-3"></i>
                                            <div>
                                                <div class="fw-semibold">{{ __('Logout') }}</div>
                                                <small class="text-muted">Sign out of your account</small>
                                            </div>
                                        </div>
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
                        Quality products and services marketplace.
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

    <!-- Enhanced Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Enhanced Navigation Interactions
            const navbar = document.querySelector('.navbar');
            const navbarToggler = document.querySelector('.modern-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            // Navbar scroll effect
            let lastScrollTop = 0;
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                // Hide/show navbar on scroll (optional)
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
                lastScrollTop = scrollTop;
            });

            // Enhanced mobile toggle animation
            if (navbarToggler) {
                navbarToggler.addEventListener('click', function() {
                    this.classList.toggle('collapsed');
                });
            }

            // Dropdown hover effects (desktop only)
            if (window.innerWidth > 991) {
                const dropdowns = document.querySelectorAll('.nav-item.dropdown');
                dropdowns.forEach(dropdown => {
                    const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                    const dropdownMenu = dropdown.querySelector('.dropdown-menu');

                    let hoverTimeout;

                    dropdown.addEventListener('mouseenter', function() {
                        clearTimeout(hoverTimeout);
                        dropdownToggle.classList.add('show');
                        dropdownMenu.classList.add('show');
                    });

                    dropdown.addEventListener('mouseleave', function() {
                        hoverTimeout = setTimeout(() => {
                            dropdownToggle.classList.remove('show');
                            dropdownMenu.classList.remove('show');
                        }, 300);
                    });
                });
            }

            // Enhanced dropdown item interactions
            const dropdownItems = document.querySelectorAll('.modern-dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Active link highlighting
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.modern-nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Smooth scrolling for anchor links
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

            // Enhanced search functionality (if search input exists)
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const searchTerm = this.value.trim();

                    if (searchTerm.length >= 2) {
                        searchTimeout = setTimeout(() => {
                            // Add visual feedback
                            this.style.borderColor = '#007bff';
                            this.style.boxShadow = '0 0 0 0.2rem rgba(0,123,255,.25)';

                            setTimeout(() => {
                                this.style.borderColor = '';
                                this.style.boxShadow = '';
                            }, 1000);
                        }, 300);
                    }
                });
            }

            // Loading states for navigation links
            const navLinksWithLoading = document.querySelectorAll('.modern-nav-link, .modern-dropdown-item');
            navLinksWithLoading.forEach(link => {
                if (link.href && !link.href.includes('#')) {
                    link.addEventListener('click', function(e) {
                        // Add loading state
                        const icon = this.querySelector('i');
                        if (icon && !icon.classList.contains('bi-arrow-right')) {
                            const originalClass = icon.className;
                            icon.className = 'bi bi-arrow-repeat spin me-2';

                            // Restore original icon if navigation is cancelled
                            setTimeout(() => {
                                if (icon.classList.contains('spin')) {
                                    icon.className = originalClass;
                                }
                            }, 3000);
                        }
                    });
                }
            });

            // Keyboard navigation support
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    // Close all open dropdowns
                    const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                    openDropdowns.forEach(dropdown => {
                        dropdown.classList.remove('show');
                        const toggle = dropdown.previousElementSibling;
                        if (toggle) toggle.classList.remove('show');
                    });
                }
            });
        });

        // Add spin animation for loading states
        const spinCSS = `
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        `;

        const style = document.createElement('style');
        style.textContent = spinCSS;
        document.head.appendChild(style);
    </script>

    <!-- Modern Loading States JavaScript -->
    <script src="{{ asset('js/loading-states.js') }}"></script>

    <!-- Enhanced Feedback System JavaScript -->
    <script src="{{ asset('js/feedback-system.js') }}"></script>

    @if(config('app.debug'))
    <!-- UI Test Suite (Development Only) -->
    <script src="{{ asset('js/ui-test-suite.js') }}"></script>
    @endif

    <!-- Additional CSS for enhanced animations -->
    <style>
        /* Highlight flash effect */
        .highlight-flash {
            animation: highlightFlash 2s ease-in-out;
        }

        @keyframes highlightFlash {
            0%, 100% { background-color: transparent; }
            50% { background-color: rgba(0, 123, 255, 0.1); }
        }

        /* Element loading overlay */
        .element-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            border-radius: inherit;
        }

        .element-loading-overlay .loading-content {
            text-align: center;
        }

        .element-loading-overlay .loading-spinner {
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 0.5rem;
        }

        .element-loading-overlay .loading-message {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Enhanced button states */
        .btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        /* Smooth transitions for all interactive elements */
        .btn, .card, .nav-link, .dropdown-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Page transition effects */
        .page-transition {
            animation: pageTransition 0.5s ease-in-out;
        }

        @keyframes pageTransition {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Skeleton loading placeholders */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-text {
            height: 1rem;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }

        .skeleton-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .skeleton-card {
            height: 200px;
            border-radius: 8px;
        }
    </style>
</body>
</html>
