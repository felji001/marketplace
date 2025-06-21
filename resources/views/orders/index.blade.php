@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-bag-check"></i> My Orders
        </h2>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary">
            <i class="bi bi-shop"></i> Continue Shopping
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Order #{{ $order->id }}</h6>
                            <span class="badge {{ $order->status_badge_class }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Order Date</small>
                                    <div>{{ $order->created_at->format('M d, Y') }}</div>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">Total Amount</small>
                                    <div class="h5 text-primary mb-0">{{ $order->formatted_total }}</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">Items</small>
                                @foreach($order->orderItems as $item)
                                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                        <div>
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            <small class="text-muted">
                                                Qty: {{ $item->quantity }} × {{ $item->formatted_unit_price }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <div>{{ $item->formatted_total_price }}</div>
                                            <small class="text-muted">by {{ $item->product->user->name }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                                
                                @if($order->canBeCancelled())
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-bag-x display-1 text-muted"></i>
            <h4 class="mt-3">No orders yet</h4>
            <p class="text-muted">You haven't placed any orders yet. Start shopping to see your orders here!</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                <i class="bi bi-shop"></i> Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
