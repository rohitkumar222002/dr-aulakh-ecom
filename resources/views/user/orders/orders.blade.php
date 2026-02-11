@extends('user.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4>My Orders</h4>
                </div>
                
                <div class="card-body">
                    <!-- Search Filter -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" 
                                   class="form-control" 
                                   placeholder="Search by Order Number..."
                                   id="searchInput">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" onclick="filterOrders()">Search</button>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $order->order_number }}</strong>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        @foreach($order->items->take(2) as $item)
                                            <div class="d-flex align-items-center mb-1">
                                                @if($item->product->primary_image ?? false)
                                                    <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="rounded me-2" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <small>{{ $item->product->name ?? 'Product removed' }}</small><br>
                                                    <small class="text-muted">Qty: {{ $item->quantity }} × ₹{{ $item->price }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 2)
                                            <small class="text-primary">+{{ $order->items->count() - 2 }} more items</small>
                                        @endif
                                    </td>
                                    <td class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'shipped' => 'primary',
                                                'delivered' => 'success',
                                                'cancelled' => 'danger'
                                            ];
                                            $statusIcons = [
                                                'pending' => '⏳',
                                                'processing' => '⚙️',
                                                'shipped' => '🚚',
                                                'delivered' => '✅',
                                                'cancelled' => '❌'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$order->order_status] ?? 'secondary' }}">
                                            {{ $statusIcons[$order->order_status] ?? '📦' }}
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($order->payment_method === 'cod')
                                            <span class="badge bg-warning">💵 COD</span>
                                        @else
                                            <span class="badge bg-success">💳 Paid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.order.success', $order->id) }}" 
                                           class="btn btn-sm text-white btn-primary">
                                            View
                                        </a>
                                        {{--
                                        @if(in_array($order->order_status, ['pending', 'processing']))
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="cancelOrder({{ $order->id }})">
                                                Cancel
                                            </button>
                                        @endi--}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $orders->links("pagination::bootstrap-5") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table img {
        border: 1px solid #dee2e6;
    }
    
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.8em;
    }
    
    td small {
        font-size: 0.85rem;
    }
</style>

<script>
    function filterOrders() {
        const search = document.getElementById('searchInput').value;
        window.location.href = '{{ url()->current() }}?search=' + encodeURIComponent(search);
    }
    
    function cancelOrder(orderId) {
        if(confirm('Are you sure you want to cancel this order?')) {
            // Add your cancel order logic here
            console.log('Cancelling order:', orderId);
        }
    }
    
    // Enter key triggers search
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if(e.key === 'Enter') {
            filterOrders();
        }
    });
</script>
@endsection