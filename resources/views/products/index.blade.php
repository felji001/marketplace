@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Enhanced Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="page-header-modern position-relative overflow-hidden rounded-4 shadow-lg p-5"
                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <!-- Background Pattern -->
                <div class="position-absolute top-0 end-0 opacity-10">
                    <i class="bi bi-box-seam" style="font-size: 10rem; transform: rotate(15deg);"></i>
                </div>

                <div class="position-relative">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="header-content">
                                <h1 class="display-6 fw-bold text-white mb-3 fade-in-up">
                                    <i class="bi bi-box-seam me-3"></i>My Products
                                </h1>
                                <p class="lead text-white opacity-90 mb-4 fade-in-up" style="animation-delay: 0.2s;">
                                    Manage your product listings and track their performance
                                </p>
                                <div class="stats-row d-flex flex-wrap gap-3 fade-in-up" style="animation-delay: 0.4s;">
                                    <div class="stat-badge rounded-pill px-4 py-2">
                                        <i class="bi bi-box text-warning me-2"></i>
                                        <span class="text-white">{{ $products->total() }} Total Products</span>
                                    </div>
                                    <div class="stat-badge rounded-pill px-4 py-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <span class="text-white">{{ $products->where('stock', '>', 0)->count() }} In Stock</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <div class="header-actions fade-in-up" style="animation-delay: 0.6s;">
                                <a href="{{ route('products.create') }}" class="btn btn-white btn-lg px-5 py-3 rounded-pill shadow-sm hover-lift">
                                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($products->count() > 0)
        <!-- Enhanced Products Grid -->
        <div class="row g-4 products-grid">
            @foreach($products as $product)
                <div class="col-xl-4 col-lg-6 col-md-6 product-item fade-in-scale" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="card modern-product-card h-100 border-0 shadow-lg position-relative overflow-hidden">
                        <!-- Product Image Section -->
                        <div class="product-image-section position-relative" style="height: 220px;">
                            @if($product->hasImages())
                                <img src="{{ $product->display_image }}" alt="{{ $product->name }}"
                                     class="w-100 h-100 object-fit-cover">
                                @if($product->image_count > 1)
                                    <span class="badge bg-dark position-absolute top-0 end-0 m-3 rounded-pill">
                                        <i class="bi bi-images me-1"></i>{{ $product->image_count }}
                                    </span>
                                @endif
                            @else
                                <div class="bg-gradient d-flex align-items-center justify-content-center h-100"
                                     style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                                    <i class="bi bi-image display-3 text-muted"></i>
                                </div>
                            @endif

                            <!-- Stock Status Overlay -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                    <i class="bi bi-box me-1"></i>
                                    {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="card-body p-4">
                            <!-- Category Badge -->
                            <div class="product-category mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                    <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Product Title -->
                            <h5 class="card-title fw-bold mb-3 text-dark">{{ $product->name }}</h5>

                            <!-- Product Description -->
                            @if($product->description)
                                <p class="card-text text-muted mb-3 small">
                                    {{ Str::limit($product->description, 120) }}
                                </p>
                            @endif

                            <!-- Price Section -->
                            <div class="price-section mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="price">
                                        <span class="h4 text-primary fw-bold mb-0">{{ $product->formatted_price }}</span>
                                    </div>
                                    <div class="product-meta">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $product->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Card Footer -->
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <div class="action-buttons d-grid gap-2">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="{{ route('products.show', $product) }}"
                                           class="btn btn-outline-primary btn-sm w-100 hover-lift">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-outline-secondary btn-sm w-100 hover-lift">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100 hover-lift"
                                                data-confirm="Are you sure you want to delete '{{ $product->name }}'? This action cannot be undone."
                                                data-confirm-type="danger"
                                                data-confirm-title="Delete Product"
                                                data-confirm-text="Delete"
                                                data-confirm-cancel="Cancel"
                                                onclick="deleteProduct('{{ $product->id }}')">
                                            <i class="bi bi-trash me-1"></i>Delete Product
                                        </button>
                                        <form id="delete-form-{{ $product->id }}"
                                              action="{{ route('products.destroy', $product) }}"
                                              method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Enhanced Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="pagination-wrapper d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Enhanced Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="empty-state-modern text-center py-5">
                    <div class="empty-state-card bg-white rounded-4 shadow-lg p-5 mx-auto" style="max-width: 600px;">
                        <div class="empty-icon mb-4">
                            <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width: 120px; height: 120px;">
                                <i class="bi bi-box display-1 text-primary"></i>
                            </div>
                        </div>
                        <h3 class="empty-title fw-bold mb-3 text-dark">No products yet</h3>
                        <p class="empty-description text-muted mb-4 lead">
                            You haven't added any products yet. Start by creating your first product listing and begin selling to customers!
                        </p>
                        <div class="empty-actions">
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm hover-lift">
                                <i class="bi bi-plus-circle me-2"></i>Add Your First Product
                            </a>
                        </div>
                        <div class="empty-tips mt-4">
                            <small class="text-muted">
                                <i class="bi bi-lightbulb me-1"></i>
                                Tip: Add high-quality images and detailed descriptions to attract more customers
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Enhanced CSS and JavaScript -->
<style>
/* Modern Product Card Styles */
.modern-product-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.modern-product-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.product-image-section {
    overflow: hidden;
    border-radius: 0.5rem 0.5rem 0 0;
}

.product-image-section img {
    transition: all 0.3s ease;
}

.modern-product-card:hover .product-image-section img {
    transform: scale(1.1);
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Animation classes */
.fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
    transform: translateY(30px);
}

.fade-in-scale {
    animation: fadeInScale 0.6s ease-out forwards;
    opacity: 0;
    transform: scale(0.9);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInScale {
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modern-product-card:hover {
        transform: none;
    }

    .page-header-modern .p-5 {
        padding: 2rem !important;
    }

    .stats-row {
        justify-content: center !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced delete function using feedback system
    window.deleteProduct = async function(productId) {
        const form = document.getElementById(`delete-form-${productId}`);
        if (form) {
            // Show loading state
            const progress = window.feedbackSystem.showProgress('Deleting product...', 0);

            try {
                // Simulate progress
                setTimeout(() => progress.update('Removing from database...', 50), 500);
                setTimeout(() => progress.update('Cleaning up files...', 80), 1000);

                // Submit form
                form.submit();

                // Complete progress (this will be interrupted by page navigation)
                setTimeout(() => progress.complete('Product deleted successfully'), 1500);
            } catch (error) {
                progress.error('Failed to delete product');
                window.feedbackSystem.error('An error occurred while deleting the product. Please try again.');
            }
        }
    };

    // Product card interactions with enhanced animations
    const productCards = document.querySelectorAll('.modern-product-card');
    productCards.forEach((card, index) => {
        // Staggered animation on load
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-scale');

        // Enhanced hover effects
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '';
            this.style.transform = '';
        });
    });

    // Enhanced loading states for action buttons
    const actionButtons = document.querySelectorAll('.hover-lift');
    actionButtons.forEach(button => {
        if (button.href && !button.href.includes('#')) {
            button.addEventListener('click', function(e) {
                const icon = this.querySelector('i');
                if (icon && !icon.classList.contains('bi-trash')) {
                    const originalClass = icon.className;
                    icon.className = 'bi bi-arrow-repeat spin me-1';

                    // Show loading toast
                    const loadingToast = window.feedbackSystem.showToast(
                        'Loading page...',
                        'info',
                        { duration: 3000, closable: false }
                    );

                    setTimeout(() => {
                        if (icon.classList.contains('spin')) {
                            icon.className = originalClass;
                        }
                    }, 3000);
                }
            });
        }
    });

    // Show success message if redirected after successful action
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success')) {
        window.feedbackSystem.success(decodeURIComponent(urlParams.get('success')));
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    if (urlParams.get('error')) {
        window.feedbackSystem.error(decodeURIComponent(urlParams.get('error')));
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Enhanced form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i>Processing...';
                submitBtn.disabled = true;

                // Re-enable if form submission fails
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }, 10000);
            }
        });
    });
});
</script>
@endsection
