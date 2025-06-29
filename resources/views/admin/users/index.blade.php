@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="bi bi-people me-2 text-primary"></i>
                        User Management
                    </h1>
                    <p class="text-muted mb-0">Manage system users and their roles</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Add New User
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-people display-6 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold fs-4">{{ $users->total() }}</div>
                            <div class="text-muted">Total Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-shield-check display-6 text-danger"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold fs-4">{{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'admin'); })->count() }}</div>
                            <div class="text-muted">Administrators</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-briefcase display-6 text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold fs-4">{{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'producer'); })->count() }}</div>
                            <div class="text-muted">Producers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-cart display-6 text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold fs-4">{{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'buyer'); })->count() }}</div>
                            <div class="text-muted">Buyers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Users</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Search by name or email...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="role" class="form-label">Filter by Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-circle me-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card border-0 shadow-sm mb-4" id="bulkActionsCard" style="display: none;">
        <div class="card-body">
            <form id="bulkActionForm" method="POST" action="{{ route('admin.users.bulk-action') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="bulkAction" class="form-label">Bulk Action</label>
                        <select class="form-select" id="bulkAction" name="action" required>
                            <option value="">Select Action</option>
                            <option value="activate">Activate Users</option>
                            <option value="deactivate">Deactivate Users</option>
                            <option value="assign_role">Assign Role</option>
                            <option value="remove_role">Remove Role</option>
                            <option value="delete">Delete Users</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="roleSelectContainer" style="display: none;">
                        <label for="bulkRole" class="form-label">Select Role</label>
                        <select class="form-select" id="bulkRole" name="role_id">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-lightning me-1"></i>Apply to Selected
                        </button>
                        <button type="button" class="btn btn-outline-secondary ms-2" onclick="clearSelection()">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </button>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">
                            <span id="selectedCount">0</span> users selected
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-table me-2"></i>
                    All Users ({{ $users->total() }})
                </h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll">
                        Select All
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4" style="width: 50px;">
                                <input type="checkbox" class="form-check-input" id="selectAllTable">
                            </th>
                            <th class="border-0">User</th>
                            <th class="border-0">Email</th>
                            <th class="border-0">Roles</th>
                            <th class="border-0">WhatsApp</th>
                            <th class="border-0">Joined</th>
                            <th class="border-0">Status</th>
                            <th class="border-0" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input user-checkbox"
                                           value="{{ $user->id }}" name="users[]">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $user->email }}</div>
                                    @if($user->email_verified_at)
                                        <small class="text-success">
                                            <i class="bi bi-check-circle me-1"></i>Verified
                                        </small>
                                    @else
                                        <small class="text-warning">
                                            <i class="bi bi-exclamation-circle me-1"></i>Unverified
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge 
                                            @if($role->name === 'admin') bg-danger
                                            @elseif($role->name === 'producer') bg-success
                                            @elseif($role->name === 'buyer') bg-info
                                            @else bg-secondary
                                            @endif me-1">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($user->whatsapp_number)
                                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $user->whatsapp_number) }}" 
                                           target="_blank" class="text-success text-decoration-none">
                                            <i class="bi bi-whatsapp me-1"></i>
                                            {{ $user->whatsapp_number }}
                                        </a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $user->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-sm btn-outline-primary" title="Edit User">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}"
                                                  class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-{{ $user->email_verified_at ? 'warning' : 'success' }}"
                                                        title="{{ $user->email_verified_at ? 'Deactivate' : 'Activate' }} User">
                                                    <i class="bi bi-{{ $user->email_verified_at ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>

                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                    title="Delete User">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people display-1 d-block mb-3 opacity-25"></i>
                                        <h5>No users found</h5>
                                        <p>There are no users matching your criteria.</p>
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                            <i class="bi bi-person-plus me-2"></i>Add First User
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Checkbox functionality
    const selectAll = document.getElementById('selectAll');
    const selectAllTable = document.getElementById('selectAllTable');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActionsCard = document.getElementById('bulkActionsCard');
    const selectedCount = document.getElementById('selectedCount');
    const bulkActionSelect = document.getElementById('bulkAction');
    const roleSelectContainer = document.getElementById('roleSelectContainer');
    const bulkActionForm = document.getElementById('bulkActionForm');

    // Select all functionality
    function updateSelectAll() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const totalBoxes = userCheckboxes.length;

        selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalBoxes;
        selectAll.checked = checkedBoxes.length === totalBoxes;
        selectAllTable.indeterminate = selectAll.indeterminate;
        selectAllTable.checked = selectAll.checked;

        // Show/hide bulk actions
        if (checkedBoxes.length > 0) {
            bulkActionsCard.style.display = 'block';
            selectedCount.textContent = checkedBoxes.length;
        } else {
            bulkActionsCard.style.display = 'none';
        }
    }

    selectAll.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectAll();
    });

    selectAllTable.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectAll();
    });

    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAll);
    });

    // Bulk action role selection
    bulkActionSelect.addEventListener('change', function() {
        if (this.value === 'assign_role' || this.value === 'remove_role') {
            roleSelectContainer.style.display = 'block';
            document.getElementById('bulkRole').required = true;
        } else {
            roleSelectContainer.style.display = 'none';
            document.getElementById('bulkRole').required = false;
        }
    });

    // Bulk action form submission
    bulkActionForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const action = bulkActionSelect.value;

        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one user.');
            return;
        }

        // Add confirmation for destructive actions
        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} user(s)? This action cannot be undone.`)) {
                e.preventDefault();
                return;
            }
        } else if (action === 'deactivate') {
            if (!confirm(`Are you sure you want to deactivate ${checkedBoxes.length} user(s)?`)) {
                e.preventDefault();
                return;
            }
        }

        // Add selected user IDs to form
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'users[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
    });

    // Clear selection function
    window.clearSelection = function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectAll();
    };

    // Delete confirmation function
    window.confirmDelete = function(userId, userName) {
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteForm').action = `/admin/users/${userId}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    };

    // Auto-submit search form on filter change
    document.getElementById('role').addEventListener('change', function() {
        this.form.submit();
    });

    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endsection
