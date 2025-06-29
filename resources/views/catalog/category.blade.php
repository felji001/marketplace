@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header bg-gradient p-4 rounded-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <nav aria-label="breadcrumb" class="mb-2">
                            <ol class="breadcrumb text-white-50">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('catalog.index') }}" class="text-white text-decoration-none">
                                        <i class="bi bi-house-door me-1"></i>Marketplace
                                    </a>
                                </li>
                                @if($category->parent)
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('catalog.category', $category->parent) }}" class="text-white text-decoration-none">
                                            {{ $category->parent->name }}
                                        </a>
                                    </li>
                                @endif
                                <li class="breadcrumb-item active text-white" aria-current="page">
                                    {{ $category->name }}
                                </li>
                            </ol>
                        </nav>
                        <h1 class="display-6 fw-bold mb-2 text-white">
                            <i class="bi bi-folder me-2"></i>
                            {{ $category->name }}
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            Explore products in {{ $category->name }} category
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="stats-badges">
                            <span class="badge bg-light text-dark fs-6 me-2">
                                <i class="bi bi-box me-1"></i>
                                {{ $products->total() }} Products
                            </span>
                            @if($category->children->count() > 0)
                                <span class="badge bg-light text-dark fs-6">
                                    <i class="bi bi-folder me-1"></i>
                                    {{ $category->children->count() }} Subcategories
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Enhanced Categories Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="category-sidebar sticky-top" style="top: 20px;">
                <!-- Back to All Categories -->
                <div class="mb-4">
                    <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left me-2"></i>All Categories
                    </a>
                </div>

                <!-- Current Category Info -->
                <div class="current-category-info mb-4 p-3 bg-light rounded">
                    <h6 class="fw-bold text-primary mb-2">
                        <i class="bi bi-folder-open me-2"></i>Current Category
                    </h6>
                    <p class="mb-1 fw-semibold">{{ $category->name }}</p>
                    @if($category->parent)
                        <small class="text-muted">
                            Parent: {{ $category->parent->name }}
                        </small>
                    @endif
                </div>

                <!-- Subcategories if available -->
                @if($category->children->count() > 0)
                    <div class="subcategories-section mb-4">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-folder me-2"></i>Subcategories
                        </h6>
                        @foreach($category->children as $child)
                            <div class="subcategory-item mb-2">
                                <a href="{{ route('catalog.category', $child) }}"
                                   class="subcategory-link enhanced-subcategory-link">
                                    <div class="subcategory-content">
                                        <div class="subcategory-info">
                                            <i class="bi bi-folder subcategory-icon"></i>
                                            <span class="subcategory-name">{{ $child->name }}</span>
                                        </div>
                                        <span class="subcategory-count">{{ $child->products_count ?? 0 }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Enhanced Search Section -->
                <div class="search-section mb-4">
                    <div class="search-header d-flex align-items-center mb-3">
                        <div class="search-icon me-2">
                            <i class="bi bi-search text-primary"></i>
                        </div>
                        <h6 class="sidebar-title mb-0 fw-semibold">Search in {{ $category->name }}</h6>
                    </div>

                    <form method="GET" action="{{ route('catalog.category', $category) }}" class="enhanced-search-form">
                        <div class="search-input-wrapper position-relative mb-3">
                            <input type="text"
                                   name="search"
                                   class="form-control search-input"
                                   placeholder="Search in {{ $category->name }}..."
                                   value="{{ request('search') }}"
                                   id="searchInput"
                                   autocomplete="off">
                            <div class="search-input-icons">
                                @if(request('search'))
                                    <button type="button" class="btn-clear-search" onclick="clearSearch()">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                @endif
                                <button type="submit" class="btn-search">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        @if(request('search'))
                            <div class="search-results-info">
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Searching for: <strong>"{{ request('search') }}"</strong>
                                    </small>
                                    <a href="{{ route('catalog.category', $category) }}"
                                       class="btn btn-outline-secondary btn-xs">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- All Categories Navigation -->
                <div class="categories-section">
                    <div class="categories-header d-flex align-items-center mb-3">
                        <div class="categories-icon me-2">
                            <i class="bi bi-grid-3x2-gap text-primary"></i>
                        </div>
                        <h6 class="sidebar-title mb-0 fw-semibold">All Categories</h6>
                    </div>

                    <!-- All Products Link -->
                    <div class="category-item mb-2">
                        <a href="{{ route('catalog.index') }}"
                           class="category-link enhanced-category-link">
                            <div class="category-content">
                                <div class="category-info">
                                    <i class="bi bi-house-door category-icon"></i>
                                    <span class="category-name">All Products</span>
                                </div>
                                <span class="category-count">{{ \App\Models\Product::count() }}</span>
                            </div>
                        </a>
                    </div>

                    <!-- Enhanced Category List -->
                    @foreach($categories as $cat)
                        <div class="category-item mb-2">
                            <a href="{{ route('catalog.category', $cat) }}"
                               class="category-link enhanced-category-link {{ $cat->id == $category->id || ($category->parent && $cat->id == $category->parent->id) ? 'active' : '' }}">
                                <div class="category-content">
                                    <div class="category-info">
                                        <i class="bi bi-folder category-icon"></i>
                                        <span class="category-name">{{ $cat->name }}</span>
                                    </div>
                                    <span class="category-count">{{ $cat->products_count ?? 0 }}</span>
                                </div>
                            </a>

                            @if($cat->children->count() > 0)
                                <div class="subcategories {{ $cat->id == $category->id || ($category->parent && $cat->id == $category->parent->id) || in_array($category->id, $cat->children->pluck('id')->toArray()) ? 'expanded' : '' }}">
                                    @foreach($cat->children as $child)
                                        <div class="subcategory-item">
                                            <a href="{{ route('catalog.category', $child) }}"
                                               class="subcategory-link enhanced-subcategory-link {{ $child->id == $category->id ? 'active' : '' }}">
                                                <div class="subcategory-content">
                                                    <div class="subcategory-info">
                                                        <i class="bi bi-arrow-return-right subcategory-icon"></i>
                                                        <span class="subcategory-name">{{ $child->name }}</span>
                                                    </div>
                                                    <span class="subcategory-count">{{ $child->products_count ?? 0 }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Enhanced Products Grid -->
        <div class="col-lg-9 col-md-8">
            <!-- Products Header -->
            <div class="products-header mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="products-title mb-2">
                            @if(request('search'))
                                <i class="bi bi-search me-2 text-primary"></i>
                                Search Results in {{ $category->name }}
                            @else
                                <i class="bi bi-folder me-2 text-primary"></i>
                                {{ $category->name }} Products
                            @endif
                        </h2>
                        <p class="text-muted mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <!-- Enhanced Sort Options -->
                        <div class="sort-controls d-flex align-items-center justify-content-md-end gap-2">
                            <small class="text-muted d-none d-md-inline">Sort by:</small>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle enhanced-sort-btn" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-funnel"></i>
                                    <span class="sort-text">
                                        @switch(request('sort'))
                                            @case('name')
                                                Name A-Z
                                                @break
                                            @case('price_low')
                                                Price: Low to High
                                                @break
                                            @case('price_high')
                                                Price: High to Low
                                                @break
                                            @case('newest')
                                                Newest First
                                                @break
                                            @default
                                                Default
                                        @endswitch
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end enhanced-sort-menu">
                                    <li class="dropdown-header">
                                        <i class="bi bi-funnel me-1"></i>Sort Options
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item enhanced-sort-item {{ !request('sort') ? 'active' : '' }}"
                                           href="{{ request()->fullUrlWithQuery(['sort' => null]) }}">
                                            <div class="sort-item-content">
                                                <i class="bi bi-star sort-icon"></i>
                                                <div class="sort-item-text">
                                                    <span class="sort-name">Default</span>
                                                    <small class="sort-desc">Recommended order</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item enhanced-sort-item {{ request('sort') == 'name' ? 'active' : '' }}"
                                           href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}">
                                            <div class="sort-item-content">
                                                <i class="bi bi-sort-alpha-down sort-icon"></i>
                                                <div class="sort-item-text">
                                                    <span class="sort-name">Name A-Z</span>
                                                    <small class="sort-desc">Alphabetical order</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item enhanced-sort-item {{ request('sort') == 'price_low' ? 'active' : '' }}"
                                           href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">
                                            <div class="sort-item-content">
                                                <i class="bi bi-sort-numeric-down sort-icon"></i>
                                                <div class="sort-item-text">
                                                    <span class="sort-name">Price: Low to High</span>
                                                    <small class="sort-desc">Cheapest first</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item enhanced-sort-item {{ request('sort') == 'price_high' ? 'active' : '' }}"
                                           href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">
                                            <div class="sort-item-content">
                                                <i class="bi bi-sort-numeric-up sort-icon"></i>
                                                <div class="sort-item-text">
                                                    <span class="sort-name">Price: High to Low</span>
                                                    <small class="sort-desc">Most expensive first</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item enhanced-sort-item {{ request('sort') == 'newest' ? 'active' : '' }}"
                                           href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
                                            <div class="sort-item-content">
                                                <i class="bi bi-clock sort-icon"></i>
                                                <div class="sort-item-text">
                                                    <span class="sort-name">Newest First</span>
                                                    <small class="sort-desc">Recently added</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($products->count() > 0)
                <!-- Products Grid -->
                <div class="products-grid">
                    <div class="row g-4" id="productsContainer">
                        @foreach($products as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6 product-item fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                <div class="card product-card h-100 border-0 shadow-sm">
                                    <!-- Product Image -->
                                    <div class="product-image-container position-relative" style="height: 200px; overflow: hidden;">
                                        @if($product->hasImages())
                                            <img src="{{ $product->display_image }}" alt="{{ $product->name }}"
                                                 class="w-100 h-100" style="object-fit: cover;">
                                            @if($product->image_count > 1)
                                                <span class="badge bg-dark position-absolute top-0 end-0 m-2">
                                                    <i class="bi bi-images me-1"></i>{{ $product->image_count }}
                                                </span>
                                            @endif
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                <i class="bi bi-image display-4 text-muted"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-body p-4">
                                        <!-- Product Category -->
                                        <div class="product-category mb-2">
                                            <span class="badge bg-light text-primary">
                                                <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                                            </span>
                                        </div>

                                        <!-- Product Title -->
                                        <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>

                                        <!-- Product Description -->
                                        @if($product->description)
                                            <p class="card-text text-muted small mb-3">
                                                {{ Str::limit($product->description, 80) }}
                                            </p>
                                        @endif

                                        <!-- Product Price & Stock -->
                                        <div class="product-meta d-flex justify-content-between align-items-center mb-3">
                                            <div class="price">
                                                <span class="h5 text-primary fw-bold mb-0 product-price">{{ $product->formatted_price }}</span>
                                            </div>
                                            <div class="stock">
                                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    <i class="bi bi-box me-1"></i>
                                                    {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Seller Info -->
                                        <div class="seller-info mb-3">
                                            <small class="text-muted d-flex align-items-center">
                                                <i class="bi bi-person-circle me-2"></i>
                                                <span>by <strong>{{ $product->user->name }}</strong></span>
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('catalog.show', $product) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye me-2"></i>View Details
                                            </a>
                                            @if($product->stock > 0 && $product->hasWhatsAppContact())
                                                <a href="{{ $product->getWhatsAppInquiryUrl(1) }}"
                                                   target="_blank"
                                                   class="btn btn-success btn-sm whatsapp-btn">
                                                    <i class="bi bi-whatsapp me-2"></i>Contact Seller
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Modern Pagination -->
                <div class="modern-pagination-wrapper mt-5">
                    <div class="pagination-container">
                        <div class="pagination-info-section">
                            <div class="results-summary">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                <span class="results-text">
                                    Showing <strong>{{ $products->firstItem() }}</strong> to <strong>{{ $products->lastItem() }}</strong>
                                    of <strong>{{ $products->total() }}</strong> {{ Str::plural('result', $products->total()) }}
                                </span>
                            </div>
                        </div>

                        <div class="pagination-controls-section">
                            @if ($products->hasPages())
                                <nav aria-label="Product pagination" class="modern-pagination">
                                    <ul class="pagination-list">
                                        {{-- Previous Page Link --}}
                                        @if ($products->onFirstPage())
                                            <li class="pagination-item disabled">
                                                <span class="pagination-link">
                                                    <i class="bi bi-chevron-left"></i>
                                                    <span class="d-none d-sm-inline ms-1">Previous</span>
                                                </span>
                                            </li>
                                        @else
                                            <li class="pagination-item">
                                                <a class="pagination-link" href="{{ $products->appends(request()->query())->previousPageUrl() }}">
                                                    <i class="bi bi-chevron-left"></i>
                                                    <span class="d-none d-sm-inline ms-1">Previous</span>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($products->appends(request()->query())->getUrlRange(1, $products->lastPage()) as $page => $url)
                                            @if ($page == $products->currentPage())
                                                <li class="pagination-item active">
                                                    <span class="pagination-link current-page">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="pagination-item">
                                                    <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($products->hasMorePages())
                                            <li class="pagination-item">
                                                <a class="pagination-link" href="{{ $products->appends(request()->query())->nextPageUrl() }}">
                                                    <span class="d-none d-sm-inline me-1">Next</span>
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="pagination-item disabled">
                                                <span class="pagination-link">
                                                    <span class="d-none d-sm-inline me-1">Next</span>
                                                    <i class="bi bi-chevron-right"></i>
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-4">
                        <i class="bi bi-folder-x display-1 text-muted"></i>
                    </div>
                    <h4 class="empty-title mb-3">No products found in {{ $category->name }}</h4>
                    <p class="empty-description text-muted mb-4">
                        @if(request('search'))
                            We couldn't find any products matching "<strong>{{ request('search') }}</strong>" in this category.
                            <br>Try adjusting your search terms or browse other categories.
                        @else
                            There are no products in this category yet.
                            <br>Check back later or browse other categories.
                        @endif
                    </p>
                    <div class="empty-actions">
                        @if(request('search'))
                            <a href="{{ route('catalog.category', $category) }}" class="btn btn-primary me-2">
                                <i class="bi bi-arrow-left me-2"></i>View All in {{ $category->name }}
                            </a>
                        @endif
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-grid-3x3-gap me-2"></i>Browse All Products
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced search functionality
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;

    if (searchInput) {
        // Live search with better UX
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.trim();

            if (searchTerm.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // Add subtle loading indicator
                    this.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'%23007bff\' viewBox=\'0 0 16 16\'%3E%3Cpath d=\'M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0zM8 14a6 6 0 1 1 6-6 6 6 0 0 1-6 6z\'/%3E%3C/svg%3E")';
                    this.style.backgroundRepeat = 'no-repeat';
                    this.style.backgroundPosition = 'right 40px center';

                    setTimeout(() => {
                        this.style.backgroundImage = '';
                    }, 500);
                }, 300);
            }
        });

        // Enhanced focus effects
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('search-focused');
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('search-focused');
        });
    }

    // Enhanced product card interactions
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach((card, index) => {
        // Staggered animation on load
        card.style.animationDelay = `${index * 0.1}s`;

        // Enhanced hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.08)';
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';
            this.style.zIndex = '';
        });
    });

    // Sort dropdown enhancements
    const sortDropdown = document.getElementById('sortDropdown');
    if (sortDropdown) {
        sortDropdown.addEventListener('show.bs.dropdown', function() {
            this.classList.add('dropdown-open');
        });

        sortDropdown.addEventListener('hide.bs.dropdown', function() {
            this.classList.remove('dropdown-open');
        });
    }
});

// Clear search function
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
        searchInput.focus();

        // Trigger form submission to clear results
        const form = searchInput.closest('form');
        if (form) {
            // Remove search parameter and submit
            const url = new URL(window.location);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }
    }
}
</script>
@endsection
