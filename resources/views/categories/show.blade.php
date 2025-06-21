@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-folder"></i> {{ $category->name }}
                    </h4>
                    <div>
                        @can('update', $category)
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        @endcan
                        @can('delete', $category)
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Slug:</strong> {{ $category->slug }}</p>
                            @if($category->parent)
                                <p><strong>Parent Category:</strong> 
                                    <a href="{{ route('categories.show', $category->parent) }}">{{ $category->parent->name }}</a>
                                </p>
                            @else
                                <p><strong>Type:</strong> Root Category</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p><strong>Products:</strong> {{ $category->products->count() }}</p>
                            <p><strong>Subcategories:</strong> {{ $category->children->count() }}</p>
                        </div>
                    </div>

                    @if($category->children->count() > 0)
                        <div class="mb-4">
                            <h5>Subcategories</h5>
                            <div class="row">
                                @foreach($category->children as $child)
                                    <div class="col-md-6 mb-2">
                                        <div class="card">
                                            <div class="card-body py-2">
                                                <h6 class="card-title mb-1">
                                                    <a href="{{ route('categories.show', $child) }}" class="text-decoration-none">
                                                        <i class="bi bi-folder2"></i> {{ $child->name }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">{{ $child->products->count() }} products</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($category->products->count() > 0)
                        <div>
                            <h5>Products in this Category</h5>
                            <div class="row">
                                @foreach($category->products as $product)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $product->name }}</h6>
                                                <p class="card-text">
                                                    <span class="text-primary fw-bold">{{ $product->formatted_price }}</span>
                                                    <small class="text-muted ms-2">{{ $product->stock }} in stock</small>
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">by {{ $product->user->name }}</small>
                                                </p>
                                                <a href="{{ route('catalog.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i> View Product
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-box display-4 text-muted"></i>
                            <p class="text-muted mt-2">No products in this category yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Category Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('catalog.index', ['category' => $category->id]) }}" class="btn btn-primary">
                            <i class="bi bi-shop"></i> Browse Products
                        </a>
                        @can('create', App\Models\Product::class)
                            <a href="{{ route('products.create') }}?category={{ $category->id }}" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </a>
                        @endcan
                        @can('create', App\Models\Category::class)
                            <a href="{{ route('categories.create') }}?parent={{ $category->id }}" class="btn btn-outline-secondary">
                                <i class="bi bi-folder-plus"></i> Add Subcategory
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
