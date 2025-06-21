@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">My Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $product->name }}</h4>
                    <div>
                        @can('update', $product)
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        @endcan
                        @can('delete', $product)
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Category:</strong> 
                                <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a>
                            </p>
                            <p><strong>Price:</strong> <span class="text-primary h5">{{ $product->formatted_price }}</span></p>
                            <p><strong>Stock:</strong> 
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->stock }} available
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created:</strong> {{ $product->created_at->format('M d, Y') }}</p>
                            <p><strong>Last Updated:</strong> {{ $product->updated_at->format('M d, Y') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-warning' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="mb-3">
                            <h5>Description</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h5>Product Links</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('catalog.show', $product) }}" class="btn btn-outline-primary" target="_blank">
                                <i class="bi bi-eye"></i> View in Catalog
                            </a>
                            @if($product->hasWhatsAppContact())
                                <a href="{{ $product->getWhatsAppInquiryUrl(1) }}" class="btn btn-outline-success" target="_blank">
                                    <i class="bi bi-whatsapp"></i> Test WhatsApp Link
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Product Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Orders:</strong> {{ $product->orderItems->count() }}
                    </div>
                    <div class="mb-3">
                        <strong>Total Sold:</strong> {{ $product->orderItems->sum('quantity') }}
                    </div>
                    <div class="mb-3">
                        <strong>Revenue:</strong> ${{ number_format($product->orderItems->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @can('update', $product)
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit Product
                            </a>
                        @endcan
                        <a href="{{ route('products.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Add New Product
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
