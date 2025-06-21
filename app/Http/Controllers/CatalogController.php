<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display the product catalog.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user'])
            ->inStock()
            ->orderBy('created_at', 'desc');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12);
        $categories = Category::with('children')->whereNull('parent_id')->orderBy('name')->get();

        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Display a specific product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'user']);

        // Get related products from the same category
        $relatedProducts = Product::with(['category', 'user'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display products by category.
     */
    public function category(Category $category)
    {
        $products = Product::with(['category', 'user'])
            ->byCategory($category->id)
            ->inStock()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::with('children')->whereNull('parent_id')->orderBy('name')->get();

        return view('catalog.category', compact('products', 'category', 'categories'));
    }
}
