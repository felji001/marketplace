@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Enhanced Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="categories-header position-relative overflow-hidden rounded-4 shadow-lg"
                 style="background: linear-gradient(135deg, #e91e63 0%, #ad1457 100%); min-height: 180px;">
                <!-- Animated Background Elements -->
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                    </div>
                </div>

                <div class="position-relative p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-7">
                            <div class="header-content">
                                <h1 class="display-5 fw-bold text-white mb-3 fade-in-up">
                                    <i class="bi bi-tags me-3 display-6"></i>
                                    Categories Management
                                </h1>
                                <p class="lead text-white mb-0 opacity-90 fade-in-up" style="animation-delay: 0.2s;">
                                    <i class="bi bi-folder-plus me-2"></i>
                                    Organize your products efficiently with well-structured categories
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 text-md-end">
                            @can('create', App\Models\Category::class)
                                <div class="action-section fade-in-up" style="animation-delay: 0.4s;">
                                    <a href="{{ route('categories.create') }}" class="btn btn-white btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                                        <i class="bi bi-plus-circle me-2"></i> Add New Category
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($categories->count() > 0)
        <!-- Categories Overview Stats -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <div class="stat-item">
                                    <i class="bi bi-tags display-6 text-primary mb-2"></i>
                                    <h4 class="fw-bold text-primary mb-1">{{ $categories->count() }}</h4>
                                    <small class="text-muted">Total Categories</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <div class="stat-item">
                                    <i class="bi bi-folder2 display-6 text-success mb-2"></i>
                                    <h4 class="fw-bold text-success mb-1">{{ $categories->sum(function($cat) { return $cat->children->count(); }) }}</h4>
                                    <small class="text-muted">Subcategories</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-item">
                                    <i class="bi bi-box display-6 text-info mb-2"></i>
                                    <h4 class="fw-bold text-info mb-1">{{ $categories->sum(function($cat) { return $cat->products->count(); }) }}</h4>
                                    <small class="text-muted">Total Products</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-item">
                                    <i class="bi bi-graph-up display-6 text-warning mb-2"></i>
                                    <h4 class="fw-bold text-warning mb-1">{{ number_format($categories->avg(function($cat) { return $cat->products->count(); }), 1) }}</h4>
                                    <small class="text-muted">Avg Products/Category</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Categories Grid -->
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-md-6 col-lg-4">
                    <div class="card modern-category-card h-100 border-0 shadow-lg position-relative overflow-hidden hover-lift">
                        <!-- Category Gradient Background -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-5"
                             style="background: linear-gradient(135deg, {{ ['#667eea', '#11998e', '#e91e63', '#fd7e14', '#6f42c1'][array_rand(['#667eea', '#11998e', '#e91e63', '#fd7e14', '#6f42c1'])] }} 0%, {{ ['#764ba2', '#38ef7d', '#ad1457', '#e55a00', '#5a2d91'][array_rand(['#764ba2', '#38ef7d', '#ad1457', '#e55a00', '#5a2d91'])] }} 100%);"></div>

                        <div class="card-body p-4 position-relative">
                            <!-- Category Header -->
                            <div class="category-header mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="category-icon me-3">
                                        <i class="bi bi-folder display-6 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title fw-bold mb-1">{{ $category->name }}</h5>
                                        <small class="text-muted">{{ $category->slug }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Stats -->
                            <div class="category-stats mb-3">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="stat-box bg-light rounded-3 p-3">
                                            <i class="bi bi-box text-primary mb-1"></i>
                                            <div class="fw-bold text-primary">{{ $category->products->count() }}</div>
                                            <small class="text-muted">Products</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box bg-light rounded-3 p-3">
                                            <i class="bi bi-folder2 text-success mb-1"></i>
                                            <div class="fw-bold text-success">{{ $category->children->count() }}</div>
                                            <small class="text-muted">Subcategories</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($category->children->count() > 0)
                                <div class="subcategories-section mb-3">
                                    <h6 class="fw-bold text-muted mb-2">
                                        <i class="bi bi-folder2 me-1"></i>Subcategories
                                    </h6>
                                    <div class="subcategories-list">
                                        @foreach($category->children->take(3) as $child)
                                            <div class="subcategory-item d-flex align-items-center justify-content-between mb-2 p-2 bg-light rounded-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-folder2 text-success me-2"></i>
                                                    <span class="fw-medium">{{ $child->name }}</span>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $child->products->count() }}</span>
                                            </div>
                                        @endforeach
                                        @if($category->children->count() > 3)
                                            <small class="text-muted">
                                                <i class="bi bi-three-dots"></i> +{{ $category->children->count() - 3 }} more
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="category-actions mt-auto">
                                <div class="d-flex gap-2 mb-2">
                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-primary btn-sm flex-fill">
                                        <i class="bi bi-eye me-1"></i> View Details
                                    </a>
                                </div>
                                <div class="d-flex gap-2">
                                    @can('update', $category)
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </a>
                                    @endcan
                                    @can('delete', $category)
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="bi bi-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Enhanced Empty State -->
        <div class="empty-state-container">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body text-center p-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="empty-state-icon mb-4">
                        <i class="bi bi-tags display-1 text-primary opacity-75"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">No Categories Yet</h3>
                    <p class="text-muted mb-4 lead">
                        Start organizing your products by creating your first category.<br>
                        Categories help customers find products easily and improve your store's organization.
                    </p>
                    @can('create', App\Models\Category::class)
                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-pill shadow-sm hover-lift">
                            <i class="bi bi-plus-circle me-2"></i> Create Your First Category
                        </a>
                    @endcan

                    <!-- Quick Tips -->
                    <div class="quick-tips mt-5">
                        <h6 class="fw-bold text-muted mb-3">💡 Quick Tips</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="tip-item p-3 bg-white rounded-3 shadow-sm mb-3">
                                    <i class="bi bi-lightbulb text-warning mb-2"></i>
                                    <small class="d-block fw-medium">Use clear, descriptive names</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="tip-item p-3 bg-white rounded-3 shadow-sm mb-3">
                                    <i class="bi bi-diagram-3 text-info mb-2"></i>
                                    <small class="d-block fw-medium">Create subcategories for better organization</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="tip-item p-3 bg-white rounded-3 shadow-sm mb-3">
                                    <i class="bi bi-search text-success mb-2"></i>
                                    <small class="d-block fw-medium">Think about how customers search</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Enhanced CSS Styles -->
<style>
/* Floating shapes animation */
.floating-shapes {
    position: relative;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 60px;
    height: 60px;
    top: 20%;
    right: 15%;
    animation-delay: 0s;
}

.shape-2 {
    width: 40px;
    height: 40px;
    top: 60%;
    right: 25%;
    animation-delay: 3s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(180deg); }
}

/* Fade in animations */
.fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
    transform: translateY(30px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Modern category card enhancements */
.modern-category-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.modern-category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Stat boxes */
.stat-box {
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Subcategory items */
.subcategory-item {
    transition: all 0.2s ease;
}

.subcategory-item:hover {
    background-color: #e3f2fd !important;
    transform: translateX(5px);
}

/* Empty state enhancements */
.empty-state-container {
    max-width: 800px;
    margin: 0 auto;
}

.tip-item {
    transition: all 0.3s ease;
}

.tip-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

/* Responsive enhancements */
@media (max-width: 768px) {
    .categories-header {
        min-height: 120px !important;
    }

    .categories-header .p-5 {
        padding: 2rem !important;
    }

    .modern-category-card:hover {
        transform: none;
    }
}
</style>

@endsection
