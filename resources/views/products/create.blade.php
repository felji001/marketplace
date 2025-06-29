@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Product Name') }}</label>

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
                            <label for="category_id" class="col-md-4 col-form-label text-md-end">{{ __('Category') }}</label>

                            <div class="col-md-6">
                                <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" 
                                        name="category_id" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        @if($category->parent_id === null)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @foreach($category->children as $child)
                                                <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;{{ $child->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price ($)') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" step="0.01" min="0" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       name="price" value="{{ old('price') }}" required>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="stock" class="col-md-4 col-form-label text-md-end">{{ __('Stock Quantity') }}</label>

                            <div class="col-md-6">
                                <input id="stock" type="number" min="0" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       name="stock" value="{{ old('stock') }}" required>

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                          name="description" rows="4" placeholder="Describe your product...">{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Images Section -->
                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Primary Image') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" accept="image/*"
                                       class="form-control @error('image') is-invalid @enderror"
                                       name="image" onchange="previewImage(this, 'imagePreview')">

                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                                </small>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <div class="image-preview-container">
                                        <img id="imagePreviewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeImagePreview('imagePreview', 'image')">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="additional_images" class="col-md-4 col-form-label text-md-end">{{ __('Additional Images') }}</label>

                            <div class="col-md-6">
                                <input id="additional_images" type="file" accept="image/*" multiple
                                       class="form-control @error('additional_images.*') is-invalid @enderror"
                                       name="additional_images[]" onchange="previewMultipleImages(this, 'additionalImagesPreview')">

                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    You can select multiple images. Max 5 images, 2MB each.
                                </small>

                                @error('additional_images.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <!-- Additional Images Preview -->
                                <div id="additionalImagesPreview" class="mt-3 row g-2" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('Create Product') }}
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">
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

<script>
// Image preview functionality
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const previewImg = document.getElementById(previewId + 'Img');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function removeImagePreview(previewId, inputId) {
    const preview = document.getElementById(previewId);
    const input = document.getElementById(inputId);

    preview.style.display = 'none';
    input.value = '';
}

function previewMultipleImages(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';

    if (input.files) {
        // Limit to 5 images
        const files = Array.from(input.files).slice(0, 5);

        if (files.length > 0) {
            preview.style.display = 'flex';

            files.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-auto';

                    col.innerHTML = `
                        <div class="image-preview-container position-relative">
                            <img src="${e.target.result}" alt="Preview ${index + 1}"
                                 class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-1"
                                    onclick="removeAdditionalImage(this, ${index})" style="padding: 2px 6px;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    `;

                    preview.appendChild(col);
                };

                reader.readAsDataURL(file);
            });
        } else {
            preview.style.display = 'none';
        }
    }
}

function removeAdditionalImage(button, index) {
    const input = document.getElementById('additional_images');
    const preview = document.getElementById('additionalImagesPreview');

    // Remove the preview element
    button.closest('.col-auto').remove();

    // If no more previews, hide the container
    if (preview.children.length === 0) {
        preview.style.display = 'none';
        input.value = '';
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const imageInput = document.getElementById('image');
    const additionalImagesInput = document.getElementById('additional_images');

    // Validate file sizes
    function validateFileSize(file, maxSize = 2048) {
        return file.size <= maxSize * 1024; // Convert KB to bytes
    }

    imageInput.addEventListener('change', function() {
        if (this.files[0] && !validateFileSize(this.files[0])) {
            alert('Primary image must be less than 2MB');
            this.value = '';
            removeImagePreview('imagePreview', 'image');
        }
    });

    additionalImagesInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        const invalidFiles = files.filter(file => !validateFileSize(file));

        if (invalidFiles.length > 0) {
            alert('All additional images must be less than 2MB');
            this.value = '';
            document.getElementById('additionalImagesPreview').style.display = 'none';
            document.getElementById('additionalImagesPreview').innerHTML = '';
        }

        if (files.length > 5) {
            alert('You can upload maximum 5 additional images');
            this.value = '';
            document.getElementById('additionalImagesPreview').style.display = 'none';
            document.getElementById('additionalImagesPreview').innerHTML = '';
        }
    });
});
</script>
@endsection
