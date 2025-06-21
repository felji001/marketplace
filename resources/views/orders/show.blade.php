@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Order #{{ $order->id }}</h4>
                    <span class="badge {{ $order->status_badge_class }} fs-6">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge {{ $order->status_badge_class }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Total Amount:</strong> <span class="h5 text-primary">{{ $order->formatted_total }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <p><strong>Name:</strong> {{ $order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            @if($order->user->whatsapp_number)
                                <p><strong>WhatsApp:</strong> {{ $order->user->whatsapp_number }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6>Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Seller</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item->product->name }}</strong><br>
                                                <small class="text-muted">{{ $item->product->category->name }}</small>
                                            </td>
                                            <td>
                                                {{ $item->product->user->name }}<br>
                                                @if($item->product->user->whatsapp_number)
                                                    <small class="text-muted">{{ $item->product->user->whatsapp_number }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $item->formatted_unit_price }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td><strong>{{ $item->formatted_total_price }}</strong></td>
                                            <td>
                                                <a href="{{ route('catalog.show', $item->product) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                @if($item->product->hasWhatsAppContact())
                                                    <a href="{{ $item->product->getWhatsAppInquiryUrl($item->quantity) }}" 
                                                       target="_blank" class="btn btn-outline-success btn-sm">
                                                        <i class="bi bi-whatsapp"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Total:</th>
                                        <th>{{ $order->formatted_total }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if($order->canBeCancelled())
                        <div class="alert alert-warning">
                            <strong>Note:</strong> This order can still be cancelled. Contact the sellers via WhatsApp to arrange delivery or cancellation.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($order->canBeCancelled())
                            <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger w-100" 
                                        onclick="return confirm('Are you sure you want to cancel this order?')">
                                    <i class="bi bi-x-circle"></i> Cancel Order
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Orders
                        </a>
                        
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                            <i class="bi bi-shop"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Order Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <strong>Order Placed</strong><br>
                            <small class="text-muted">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</small>
                        </div>
                        @if($order->status !== 'pending')
                            <div class="timeline-item">
                                <i class="bi bi-arrow-clockwise text-info"></i>
                                <strong>Status: {{ ucfirst($order->status) }}</strong><br>
                                <small class="text-muted">{{ $order->updated_at->format('M d, Y \a\t g:i A') }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-item {
    padding: 10px 0;
    border-left: 2px solid #dee2e6;
    padding-left: 20px;
    margin-left: 10px;
    position: relative;
}

.timeline-item i {
    position: absolute;
    left: -8px;
    background: white;
    padding: 2px;
}
</style>
@endsection
