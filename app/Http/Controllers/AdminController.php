<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    public function users(Request $request)
    {
        $query = User::with('roles');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show create user form.
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a new user.
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'whatsapp_number' => 'nullable|string|max:20',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'email_verified' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'whatsapp_number' => $request->whatsapp_number,
            'email_verified_at' => $request->email_verified ? now() : null,
        ]);

        $user->roles()->attach($request->roles);

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show edit user form.
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'whatsapp_number' => 'nullable|string|max:20',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'email_verified' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp_number' => $request->whatsapp_number,
            'email_verified_at' => $request->email_verified ? now() : null,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Toggle user status (activate/deactivate).
     */
    public function toggleUserStatus(User $user)
    {
        $user->update([
            'email_verified_at' => $user->email_verified_at ? null : now()
        ]);

        $status = $user->email_verified_at ? 'activated' : 'deactivated';
        return back()->with('success', "User {$status} successfully.");
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting the current admin user
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        // Check if user has orders or products
        $hasOrders = $user->orders()->count() > 0;
        $hasProducts = $user->products()->count() > 0;

        if ($hasOrders || $hasProducts) {
            return back()->withErrors(['error' => 'Cannot delete user with existing orders or products.']);
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    /**
     * Bulk actions for users.
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:activate,deactivate,delete,assign_role,remove_role',
            'users' => 'required|array|min:1',
            'users.*' => 'exists:users,id',
            'role_id' => 'required_if:action,assign_role,remove_role|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $users = User::whereIn('id', $request->users)->get();
        $currentUserId = auth()->id();

        switch ($request->action) {
            case 'activate':
                $users->each(function($user) {
                    $user->update(['email_verified_at' => now()]);
                });
                $message = 'Users activated successfully.';
                break;

            case 'deactivate':
                $users->each(function($user) use ($currentUserId) {
                    if ($user->id !== $currentUserId) {
                        $user->update(['email_verified_at' => null]);
                    }
                });
                $message = 'Users deactivated successfully.';
                break;

            case 'delete':
                $deletedCount = 0;
                foreach ($users as $user) {
                    if ($user->id !== $currentUserId &&
                        $user->orders()->count() === 0 &&
                        $user->products()->count() === 0) {
                        $user->delete();
                        $deletedCount++;
                    }
                }
                $message = "{$deletedCount} users deleted successfully.";
                break;

            case 'assign_role':
                $role = Role::find($request->role_id);
                $users->each(function($user) use ($role) {
                    if (!$user->hasRole($role->name)) {
                        $user->roles()->attach($role->id);
                    }
                });
                $message = "Role '{$role->name}' assigned to selected users.";
                break;

            case 'remove_role':
                $role = Role::find($request->role_id);
                $users->each(function($user) use ($role) {
                    if ($user->roles()->count() > 1) { // Ensure user has at least one role
                        $user->roles()->detach($role->id);
                    }
                });
                $message = "Role '{$role->name}' removed from selected users.";
                break;
        }

        return back()->with('success', $message);
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
