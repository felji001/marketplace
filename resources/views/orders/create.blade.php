@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-cart-plus"></i> Create Demo Order
                    </h4>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Demo Order:</strong> This is a demonstration order. In a real marketplace, 
                        you would contact the seller via WhatsApp to complete the purchase.
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">
                                        <strong>Category:</strong> {{ $product->category->name }}<br>
                                        <strong>Seller:</strong> {{ $product->user->name }}<br>
                                        <strong>Price:</strong> <span class="text-primary h5">{{ $product->formatted_price }}</span><br>
                                        <strong>Available Stock:</strong> {{ $product->stock }}
                                    </p>
                                    @if($product->description)
                                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('orders.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <select name="quantity" id="quantity" class="form-select @error('quantity') is-invalid @enderror" 
                                            required onchange="updateTotal()">
                                        @for($i = 1; $i <= min(10, $product->stock); $i++)
                                            <option value="{{ $i }}" {{ old('quantity', $quantity) == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Order Summary</label>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <span>Unit Price:</span>
                                                <span>{{ $product->formatted_price }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Quantity:</span>
                                                <span id="selected-quantity">{{ $quantity }}</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <strong>Total:</strong>
                                                <strong class="text-primary" id="total-price">
                                                    ${{ number_format($product->price * $quantity, 2) }}
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-cart-plus"></i> Create Demo Order
                                    </button>
                                    <a href="{{ route('catalog.show', $product) }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Product
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="bi bi-whatsapp"></i> Real Purchase Process:</h6>
                        <p class="mb-2">To actually purchase this product, you should:</p>
                        <ol class="mb-2">
                            <li>Contact the seller via WhatsApp</li>
                            <li>Discuss product details, delivery, and payment</li>
                            <li>Arrange pickup or delivery</li>
                            <li>Complete payment as agreed with the seller</li>
                        </ol>
                        @if($product->hasWhatsAppContact())
                            <a href="{{ $product->getWhatsAppInquiryUrl($quantity) }}" 
                               target="_blank" class="btn btn-success whatsapp-btn">
                                <i class="bi bi-whatsapp"></i> Contact {{ $product->user->name }} via WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateTotal() {
    const quantity = document.getElementById('quantity').value;
    const unitPrice = {{ $product->price }};
    const total = quantity * unitPrice;
    
    document.getElementById('selected-quantity').textContent = quantity;
    document.getElementById('total-price').textContent = '$' + total.toFixed(2);
}
</script>
@endsection
