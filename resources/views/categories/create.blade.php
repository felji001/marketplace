@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Create New Category
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Category Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                    @foreach($categories as $category)
                                        @if($category->parent_id === null)
                                            <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
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
                                    Leave empty to create a main category, or select a parent to create a subcategory.
                                </small>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('Create Category') }}
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary ms-2">
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
