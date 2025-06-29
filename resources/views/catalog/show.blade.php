@extends('layouts.app')

@section('content')
<style>
/* Enhanced Product Image Gallery Styles */
.thumbnail-image {
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-image:hover {
    border-color: var(--bs-primary);
    transform: scale(1.05);
}

.thumbnail-image.active {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 2px rgba(var(--bs-primary-rgb), 0.25);
}

.product-image-main img {
    transition: transform 0.3s ease;
}

.product-image-main img:hover {
    transform: scale(1.02);
}

.image-count-badge {
    backdrop-filter: blur(10px);
}

/* Modal image styling */
#modalImage {
    max-height: 80vh;
    object-fit: contain;
}

/* Enhanced product details */
.detail-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>
<div class="container">
    <!-- Enhanced Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded-3">
            <li class="breadcrumb-item">
                <a href="{{ route('catalog.index') }}" class="text-decoration-none">
                    <i class="bi bi-house me-1"></i>Products
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('catalog.index', ['category' => $product->category->id]) }}" class="text-decoration-none">
                    <i class="bi bi-folder me-1"></i>{{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-box me-1"></i>{{ Str::limit($product->name, 30) }}
            </li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Product Information -->
        <div class="col-lg-8">
            <div class="product-main">
                <!-- Product Header Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <!-- Product Title & Category -->
                        <div class="product-header mb-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <span class="badge bg-primary mb-2">
                                        <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                                    </span>
                                    <h1 class="product-title display-6 fw-bold mb-2">{{ $product->name }}</h1>
                                    <div class="product-meta text-muted">
                                        <span class="me-3">
                                            <i class="bi bi-person-circle me-1"></i>
                                            by <strong>{{ $product->user->name }}</strong>
                                        </span>
                                        <span class="me-3">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            Listed {{ $product->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="Share Product">
                                        <i class="bi bi-share"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm ms-1" data-bs-toggle="tooltip" title="Add to Wishlist">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Product Image Section -->
                        <div class="product-image-section mb-4">
                            @if($product->hasImages())
                                <div class="product-images-container">
                                    <!-- Main Image Display -->
                                    <div class="main-image-container mb-3">
                                        <div class="product-image-main position-relative rounded-3 overflow-hidden" style="height: 400px;">
                                            <img id="mainProductImage"
                                                 src="{{ $product->display_image }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-100 h-100"
                                                 style="object-fit: cover; cursor: zoom-in;"
                                                 onclick="openImageModal(this.src)">

                                            @if($product->image_count > 1)
                                                <div class="image-count-badge position-absolute top-0 end-0 m-3">
                                                    <span class="badge bg-dark bg-opacity-75">
                                                        <i class="bi bi-images me-1"></i>{{ $product->image_count }} Photos
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Image Thumbnails -->
                                    @if($product->image_count > 1)
                                        <div class="image-thumbnails">
                                            <div class="row g-2">
                                                @foreach($product->image_urls as $index => $imageUrl)
                                                    <div class="col-auto">
                                                        <div class="thumbnail-container">
                                                            <img src="{{ $imageUrl }}"
                                                                 alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                                                 class="img-thumbnail thumbnail-image {{ $index === 0 ? 'active' : '' }}"
                                                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                                                 onclick="changeMainImage('{{ $imageUrl }}', this)">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Placeholder when no images -->
                                <div class="product-image-main bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 400px;">
                                    <div class="text-center">
                                        <i class="bi bi-image display-1 text-muted mb-3"></i>
                                        <p class="text-muted">No Image Available</p>
                                        <small class="text-muted">{{ $product->name }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details Grid -->
                        <div class="product-details-grid">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-card bg-light p-3 rounded-3">
                                        <div class="d-flex align-items-center">
                                            <div class="detail-icon me-3">
                                                <i class="bi bi-currency-dollar fs-4 text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Price</h6>
                                                <h4 class="text-success fw-bold mb-0 product-price" data-base-price="{{ $product->price }}">
                                                    {{ $product->formatted_price }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card bg-light p-3 rounded-3">
                                        <div class="d-flex align-items-center">
                                            <div class="detail-icon me-3">
                                                <i class="bi bi-box fs-4 {{ $product->stock > 0 ? 'text-success' : 'text-danger' }}"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Availability</h6>
                                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} fs-6">
                                                    {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                @if($product->description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0">
                                <i class="bi bi-file-text me-2 text-primary"></i>Product Description
                            </h5>
                        </div>
                        <div class="card-body pt-3">
                            <div class="product-description">
                                <p class="text-muted lh-lg">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Purchase Actions -->
                @if($product->stock > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0">
                                <i class="bi bi-cart-plus me-2 text-success"></i>Purchase Options
                            </h5>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-4">
                                <!-- Demo Order Section -->
                                @auth
                                    @if(Auth::user()->hasRole('buyer'))
                                        <div class="col-md-6">
                                            <div class="purchase-option bg-light p-4 rounded-3">
                                                <h6 class="fw-bold mb-3">
                                                    <i class="bi bi-bag-check me-2 text-primary"></i>Demo Order
                                                </h6>
                                                <form action="{{ route('orders.store') }}" method="POST" id="demoOrderForm">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                    <div class="mb-3">
                                                        <label for="quantity" class="form-label fw-semibold">Quantity</label>
                                                        <select name="quantity" id="quantity" class="form-select" required onchange="updateTotalPrice()">
                                                            @for($i = 1; $i <= min(10, $product->stock); $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="total-price mb-3 p-2 bg-white rounded">
                                                        <div class="d-flex justify-content-between">
                                                            <span>Total:</span>
                                                            <span class="fw-bold text-primary" id="totalPrice">{{ $product->formatted_price }}</span>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="bi bi-cart-plus me-2"></i>Create Demo Order
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endauth

                                <!-- WhatsApp Contact Section -->
                                <div class="col-md-6">
                                    @if($product->hasWhatsAppContact())
                                        <div class="purchase-option bg-success bg-opacity-10 p-4 rounded-3">
                                            <h6 class="fw-bold mb-3">
                                                <i class="bi bi-whatsapp me-2 text-success"></i>Contact Seller
                                            </h6>

                                            <div class="mb-3">
                                                <label for="whatsapp_quantity" class="form-label fw-semibold">Quantity for inquiry</label>
                                                <select id="whatsapp_quantity" class="form-select" onchange="updateWhatsAppLink()">
                                                    @for($i = 1; $i <= min(10, $product->stock); $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <a id="whatsapp-link"
                                               href="{{ $product->getWhatsAppInquiryUrl(1) }}"
                                               target="_blank"
                                               class="btn btn-success whatsapp-btn w-100">
                                                <i class="bi bi-whatsapp me-2"></i>Contact via WhatsApp
                                            </a>

                                            <small class="text-muted d-block mt-2">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Get instant response from the seller
                                            </small>
                                        </div>
                                    @else
                                        <div class="purchase-option bg-warning bg-opacity-10 p-4 rounded-3">
                                            <div class="text-center">
                                                <i class="bi bi-exclamation-triangle display-6 text-warning mb-3"></i>
                                                <h6 class="fw-bold mb-2">Contact Unavailable</h6>
                                                <p class="text-muted small mb-0">
                                                    Seller hasn't provided WhatsApp contact information.
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Out of Stock -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <i class="bi bi-x-circle display-4 text-danger mb-3"></i>
                            <h5 class="fw-bold text-danger mb-2">Out of Stock</h5>
                            <p class="text-muted mb-4">This product is currently unavailable.</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-outline-primary" onclick="notifyWhenAvailable()">
                                    <i class="bi bi-bell me-2"></i>Notify When Available
                                </button>
                                <a href="{{ route('catalog.index', ['category' => $product->category->id]) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Browse Similar
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="product-sidebar">
                <!-- Enhanced Seller Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h5 class="mb-0 text-white">
                            <i class="bi bi-person-circle me-2"></i>Seller Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="seller-profile text-center mb-4">
                            <div class="seller-avatar mb-3">
                                <i class="bi bi-person-circle display-4 text-primary"></i>
                            </div>
                            <h6 class="seller-name fw-bold mb-1">{{ $product->user->name }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                Member since {{ $product->user->created_at->format('M Y') }}
                            </small>
                        </div>

                        <div class="seller-details">
                            @if($product->user->whatsapp_number)
                                <div class="detail-item mb-3 p-2 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-whatsapp text-success me-2"></i>
                                        <span class="small">{{ \App\Helpers\WhatsAppHelper::formatWhatsAppNumber($product->user->whatsapp_number) }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="seller-stats row text-center mb-3">
                                <div class="col-6">
                                    <div class="stat-item">
                                        <h6 class="fw-bold text-primary mb-0">{{ $product->user->products()->count() }}</h6>
                                        <small class="text-muted">Products</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <h6 class="fw-bold text-success mb-0">{{ $product->user->orders()->count() }}</h6>
                                        <small class="text-muted">Orders</small>
                                    </div>
                                </div>
                            </div>

                            @if($product->hasWhatsAppContact())
                                <div class="d-grid">
                                    <a href="{{ \App\Helpers\WhatsAppHelper::generateContactUrl($product->user) }}"
                                       target="_blank"
                                       class="btn btn-success whatsapp-btn">
                                        <i class="bi bi-whatsapp me-2"></i>Contact Seller
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-gear me-2 text-primary"></i>Actions
                        </h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="shareProduct()">
                                <i class="bi bi-share me-2"></i>Share Product
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="reportProduct()">
                                <i class="bi bi-flag me-2"></i>Report Issue
                            </button>
                            <a href="{{ route('catalog.index', ['category' => $product->category->id]) }}" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-arrow-left me-2"></i>Back to Category
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Related Products -->
                @if($relatedProducts->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0">
                            <h5 class="mb-0">
                                <i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Related Products
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @foreach($relatedProducts as $related)
                                <div class="related-product-item p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="d-flex">
                                        <div class="related-product-image me-3">
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="related-product-info flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('catalog.show', $related) }}"
                                                   class="text-decoration-none text-dark fw-semibold">
                                                    {{ Str::limit($related->name, 25) }}
                                                </a>
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-primary fw-bold small">{{ $related->formatted_price }}</span>
                                                <span class="badge bg-light text-muted small">
                                                    {{ $related->stock }} left
                                                </span>
                                            </div>
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i>{{ $related->user->name }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="p-3 text-center border-top bg-light">
                                <a href="{{ route('catalog.index', ['category' => $product->category->id]) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-arrow-right me-1"></i>View All in Category
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img id="modalImage" src="" alt="{{ $product->name }}" class="w-100">
            </div>
        </div>
    </div>
</div>

<script>
// Image gallery functionality
function changeMainImage(imageUrl, thumbnailElement) {
    const mainImage = document.getElementById('mainProductImage');
    mainImage.src = imageUrl;

    // Update active thumbnail
    document.querySelectorAll('.thumbnail-image').forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbnailElement.classList.add('active');
}

function openImageModal(imageUrl) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;

    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Update total price for demo order
function updateTotalPrice() {
    const quantity = document.getElementById('quantity').value;
    const basePrice = {{ $product->price }};
    const totalPrice = basePrice * quantity;
    const formattedPrice = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(totalPrice);

    document.getElementById('totalPrice').textContent = formattedPrice;
}

// Update WhatsApp link with selected quantity
function updateWhatsAppLink() {
    const quantity = document.getElementById('whatsapp_quantity').value;
    const whatsappUrl = @json($product->getWhatsAppInquiryUrl(1)).replace('📊 Quantity: 1', '📊 Quantity: ' + quantity);
    document.getElementById('whatsapp-link').href = whatsappUrl;
}

// Share product function
function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->name }}',
            text: 'Check out this product: {{ $product->name }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Product link copied to clipboard!');
        });
    }
}

// Report product function
function reportProduct() {
    // This would typically open a modal or redirect to a report form
    alert('Report functionality would be implemented here.');
}

// Notify when available function
function notifyWhenAvailable() {
    // This would typically open a modal to collect email for notifications
    alert('Notification feature would be implemented here.');
}
</script>
@endsection
