@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-tags"></i> Categories Management
        </h2>
        @can('create', App\Models\Category::class)
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Category
            </a>
        @endcan
    </div>

    @if($categories->count() > 0)
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-folder"></i> {{ $category->name }}
                            </h5>
                            <p class="card-text">
                                <small class="text-muted">Slug: {{ $category->slug }}</small>
                            </p>
                            
                            @if($category->children->count() > 0)
                                <div class="mb-2">
                                    <strong>Subcategories:</strong>
                                    <ul class="list-unstyled ms-3">
                                        @foreach($category->children as $child)
                                            <li>
                                                <i class="bi bi-folder2"></i> {{ $child->name }}
                                                <small class="text-muted">({{ $child->products->count() }} products)</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-box"></i> {{ $category->products->count() }} products
                                </small>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                @can('update', $category)
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                @endcan
                                @can('delete', $category)
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-tags display-1 text-muted"></i>
            <h4 class="mt-3">No categories yet</h4>
            <p class="text-muted">Start by creating your first category to organize products.</p>
            @can('create', App\Models\Category::class)
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create First Category
                </a>
            @endcan
        </div>
    @endif
</div>
@endsection
