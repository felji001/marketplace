<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Get key statistics
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'active_products' => Product::inStock()->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_revenue' => Order::sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        // Get recent activities
        $recent_users = User::latest()->take(5)->get();
        $recent_products = Product::with(['user', 'category'])->latest()->take(5)->get();
        $recent_orders = Order::with(['user'])->latest()->take(5)->get();

        // Get user role distribution
        $user_roles = DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('count(*) as count'))
            ->groupBy('roles.name')
            ->get();

        // Get category statistics
        $category_stats = Category::withCount('products')->get();

        // Get monthly statistics for charts
        $monthly_stats = $this->getMonthlyStats();

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_products',
            'recent_orders',
            'user_roles',
            'category_stats',
            'monthly_stats'
        ));
    }

    /**
     * Show user management page.
     */
    public function users()
    {
        $users = User::with('roles')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show system settings page.
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Get monthly statistics for charts.
     */
    private function getMonthlyStats()
    {
        $months = [];
        $users = [];
        $products = [];
        $orders = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');

            $users[] = User::whereYear('created_at', $date->year)
                          ->whereMonth('created_at', $date->month)
                          ->count();

            $products[] = Product::whereYear('created_at', $date->year)
                                ->whereMonth('created_at', $date->month)
                                ->count();

            $orders[] = Order::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count();
        }

        return [
            'months' => $months,
            'users' => $users,
            'products' => $products,
            'orders' => $orders,
        ];
    }
}
