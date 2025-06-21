@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Category: {{ $category->name }}
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Category Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $category->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="parent_id" class="col-md-4 col-form-label text-md-end">{{ __('Parent Category') }}</label>

                            <div class="col-md-6">
                                <select id="parent_id" class="form-control @error('parent_id') is-invalid @enderror" 
                                        name="parent_id">
                                    <option value="">None (Root Category)</option>
                                    @foreach($categories as $cat)
                                        @if($cat->parent_id === null)
                                            <option value="{{ $cat->id }}" 
                                                {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Leave empty to make this a main category, or select a parent to make it a subcategory.
                                </small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="alert alert-info">
                                    <strong>Current Slug:</strong> {{ $category->slug }}<br>
                                    <small>The slug will be automatically updated based on the category name.</small>
                                </div>
                            </div>
                        </div>

                        @if($category->children->count() > 0)
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="alert alert-warning">
                                        <strong>Note:</strong> This category has {{ $category->children->count() }} subcategories. 
                                        Changing the parent may affect the category hierarchy.
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($category->products->count() > 0)
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="alert alert-info">
                                        <strong>Products:</strong> This category contains {{ $category->products->count() }} products.
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('Update Category') }}
                                </button>
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
