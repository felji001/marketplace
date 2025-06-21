@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-box-seam"></i> My Products
        </h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Product
        </a>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-tag"></i> {{ $product->category->name }}
                            </p>
                            @if($product->description)
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-primary mb-0">{{ $product->formatted_price }}</span>
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->stock }} in stock
                                </span>
                            </div>
                            <div class="small text-muted">
                                <i class="bi bi-calendar"></i> Created {{ $product->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-box display-1 text-muted"></i>
            <h4 class="mt-3">No products yet</h4>
            <p class="text-muted">You haven't added any products yet. Start by creating your first product listing!</p>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Your First Product
            </a>
        </div>
    @endif
</div>
@endsection
