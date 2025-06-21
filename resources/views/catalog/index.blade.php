@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header bg-gradient p-4 rounded-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2 text-white">
                            <i class="bi bi-shop-window me-2"></i>
                            Product Marketplace
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            Discover amazing products from our trusted sellers
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="stats-badges">
                            <span class="badge bg-light text-dark fs-6 me-2">
                                <i class="bi bi-box me-1"></i>
                                {{ $products->total() }} Products
                            </span>
                            <span class="badge bg-light text-dark fs-6">
                                <i class="bi bi-tags me-1"></i>
                                {{ $categories->count() }} Categories
                            </span>
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
                <!-- Search Section -->
                <div class="search-section mb-4">
                    <h5 class="sidebar-title">
                        <i class="bi bi-search me-2"></i>Search Products
                    </h5>
                    <form method="GET" action="{{ route('catalog.index') }}" class="search-form">
                        <div class="input-group">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Search products..."
                                   value="{{ request('search') }}"
                                   id="searchInput">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('search'))
                            <div class="mt-2">
                                <a href="{{ route('catalog.index', request()->except('search')) }}"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-x-circle me-1"></i>Clear Search
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Categories Section -->
                <div class="categories-section">
                    <h5 class="sidebar-title">
                        <i class="bi bi-tags me-2"></i>Categories
                    </h5>

                    <!-- All Products Link -->
                    <div class="category-item mb-2">
                        <a href="{{ route('catalog.index') }}"
                           class="category-link {{ !request('category') ? 'active' : '' }}">
                            <i class="bi bi-grid-3x3-gap me-2"></i>
                            <span>All Products</span>
                            <span class="badge bg-light text-dark ms-auto">{{ \App\Models\Product::count() }}</span>
                        </a>
                    </div>

                    <!-- Category List -->
                    @foreach($categories as $category)
                        <div class="category-item mb-2">
                            <a href="{{ route('catalog.index', ['category' => $category->id]) }}"
                               class="category-link {{ request('category') == $category->id ? 'active' : '' }}">
                                <i class="bi bi-folder me-2"></i>
                                <span>{{ $category->name }}</span>
                                <span class="badge bg-light text-dark ms-auto">{{ $category->products_count ?? 0 }}</span>
                            </a>

                            @if($category->children->count() > 0)
                                <div class="subcategories ms-3 mt-2">
                                    @foreach($category->children as $child)
                                        <div class="subcategory-item mb-1">
                                            <a href="{{ route('catalog.index', ['category' => $child->id]) }}"
                                               class="subcategory-link {{ request('category') == $child->id ? 'active' : '' }}">
                                                <i class="bi bi-folder2 me-2"></i>
                                                <span>{{ $child->name }}</span>
                                                <span class="badge bg-light text-muted ms-auto small">{{ $child->products_count ?? 0 }}</span>
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
                                Search Results for "<span class="text-primary">{{ request('search') }}</span>"
                            @elseif(request('category'))
                                @php
                                    $selectedCategory = $categories->flatten()->firstWhere('id', request('category'));
                                @endphp
                                <i class="bi bi-folder me-2 text-primary"></i>
                                {{ $selectedCategory ? $selectedCategory->name : 'Products' }}
                            @else
                                <i class="bi bi-grid-3x3-gap me-2 text-primary"></i>
                                All Products
                            @endif
                        </h2>
                        <p class="text-muted mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <!-- Sort Options -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                                <i class="bi bi-sort-down me-1"></i>Sort By
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}">
                                    <i class="bi bi-sort-alpha-down me-2"></i>Name A-Z
                                </a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">
                                    <i class="bi bi-sort-numeric-down me-2"></i>Price: Low to High
                                </a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">
                                    <i class="bi bi-sort-numeric-up me-2"></i>Price: High to Low
                                </a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
                                    <i class="bi bi-clock me-2"></i>Newest First
                                </a></li>
                            </ul>
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
                                    <!-- Product Image Placeholder -->
                                    <div class="product-image-placeholder bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="bi bi-image display-4 text-muted"></i>
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

                <!-- Enhanced Pagination -->
                <div class="pagination-wrapper mt-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                                of {{ $products->total() }} results
                            </small>
                        </div>
                        <div class="pagination-links">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-4">
                        <i class="bi bi-search display-1 text-muted"></i>
                    </div>
                    <h4 class="empty-title mb-3">No products found</h4>
                    <p class="empty-description text-muted mb-4">
                        @if(request('search'))
                            We couldn't find any products matching "<strong>{{ request('search') }}</strong>".
                            <br>Try adjusting your search terms or browse our categories.
                        @else
                            There are no products in this category yet.
                            <br>Check back later or browse other categories.
                        @endif
                    </p>
                    <div class="empty-actions">
                        @if(request('search') || request('category'))
                            <a href="{{ route('catalog.index') }}" class="btn btn-primary me-2">
                                <i class="bi bi-arrow-left me-2"></i>View All Products
                            </a>
                        @endif
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live search functionality
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.trim();

            if (searchTerm.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // Add loading state
                    this.classList.add('loading');

                    // Simulate search delay (in real app, this would be an AJAX call)
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 500);
                }, 300);
            }
        });
    }

    // Product card hover effects
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });

    // Category link animations
    const categoryLinks = document.querySelectorAll('.category-link, .subcategory-link');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state to the products container
            const productsContainer = document.getElementById('productsContainer');
            if (productsContainer) {
                productsContainer.style.opacity = '0.6';
                productsContainer.style.pointerEvents = 'none';
            }
        });
    });
});
</script>
@endsection
