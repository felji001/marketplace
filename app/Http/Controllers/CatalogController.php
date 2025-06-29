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
            ->inStock();

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

        // Sorting functionality
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                // Default sorting: newest first, but prioritize in-stock items
                $query->orderByRaw('stock > 0 DESC, created_at DESC');
                break;
        }

        $products = $query->paginate(12);

        // Load categories with product counts for better UX
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // Add product counts to child categories
        foreach ($categories as $category) {
            foreach ($category->children as $child) {
                $child->loadCount('products');
            }
        }

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
    public function category(Category $category, Request $request)
    {
        $query = Product::with(['category', 'user'])
            ->byCategory($category->id)
            ->inStock();

        // Search functionality within category
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting functionality
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderByRaw('stock > 0 DESC, created_at DESC');
                break;
        }

        $products = $query->paginate(12);

        // Load categories with product counts
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('catalog.category', compact('products', 'category', 'categories'));
    }
}
