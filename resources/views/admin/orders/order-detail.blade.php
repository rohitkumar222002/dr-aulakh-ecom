@extends('admin.layouts.app')
@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Back Button -->
                <div class="row mb-3">
                    
                    <div class="col-12">
                        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                        
                        <button onclick="window.print()" class="btn btn-primary float-end">
                            <i class="fas fa-print"></i> Print Invoice
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <!-- Order Details Card -->
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="card-title mb-0">Order Details - {{ $order->order_number }}</h4>
                            </div>
                            <div class="card-body">
                                <!-- Order Status -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h5>Order Status</h5>
                                         <form action="{{ route('admin.orders.update-status', $order->id) }}"
      method="POST"
      class="d-inline order-status-form">
    @csrf
    @method('PATCH')

    <select name="order_status"
            class="form-select form-select-sm order-status-select"
            data-current-status="{{ $order->order_status }}"
            style="width:130px;">
        @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
            <option value="{{ $status }}"
                @selected($order->order_status === $status)>
                {{ ucfirst($status) }}
            </option>
        @endforeach
    </select>
</form>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h5>Order Date</h5>
                                        <p class="mb-0">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <h5>Order Items</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product && $item->product->primary_image)
                                                        <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                                             alt="{{ $item->product->name }}"
                                                             style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $item->product->name ?? 'Product removed' }}</strong>
                                                            @if($item->product)
                                                            <!-- <br><small>SKU: {{ $item->product->sku ?? 'N/A' }}</small> -->
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>₹{{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₹{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                             @if($order->cgst > 0)
                        <tr>
                            <td colspan="3" class="text-end">CGST</td>
                            <td>₹{{ number_format($order->cgst, 2) }}</td>
                        </tr>
                        @endif

                        @if($order->sgst > 0)
                        <tr>
                            <td colspan="3" class="text-end">SGST</td>
                            <td>₹{{ number_format($order->sgst, 2) }}</td>
                        </tr>
                        @endif

                        @if($order->igst > 0)
                        <tr>
                            <td colspan="3" class="text-end">IGST</td>
                            <td>₹{{ number_format($order->igst, 2) }}</td>
                        </tr>
                        @endif
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                                <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                                            </tr>
                                            @if($order->discount_amount > 0)
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Discount:</strong></td>
                                                <td><strong>-₹{{ number_format($order->discount_amount, 2) }}</strong></td>
                                            </tr>
                                            @endif
                                            @if($order->shipping_amount > 0)
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                                <td><strong>₹{{ number_format($order->shipping_amount, 2) }}</strong></td>
                                            </tr>
                                            @endif
                                            
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                                                <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Customer Info Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                @if($order->user)
                                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                <p><strong>Email:</strong> {{ $order->user->email  }}</p>
                                <p><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                                @endif
                                
                                <hr>
                                
                                <h6>Shipping Address</h6>
                                @if($order->address)
                                <p class="mb-1"><strong>{{ $order->address->full_name }}</strong></p>
                                <p class="mb-1">{{ $order->address->address_line1 }}</p>
                                @if($order->address->address_line2)
                                <p class="mb-1">{{ $order->address->address_line2 }}</p>
                                @endif
                                <p class="mb-1">{{ $order->address->city }}, {{ $order->address->state->name }} - {{ $order->address->pincode }}</p>
                                <p class="mb-0"><strong>Phone:</strong> {{ $order->address->phone }}</p>
                                @else
                                <p class="text-danger">No shipping address found</p>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Info Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Payment Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                                <p><strong>Payment Status:</strong> 
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->payment_status ?? 'pending') }}
                                    </span>
                                </p>
                                @if($order->transaction_id)
                                <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Notes -->
                        @if($order->notes)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Order Notes</h5>
                            </div>
                            <div class="card-body">
                                <p>{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="print-invoice">

    {{-- CUSTOMER + ADDRESS --}}
    <h3>Customer Details</h3>
    <p><strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}</p>
    <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ $order->address->phone ?? 'N/A' }}</p>

    <h4>Shipping Address</h4>
    <p>
        {{ $order->address->full_name }}<br>
        {{ $order->address->address_line1 }}<br>
        {{ $order->address->city }},
        {{ $order->address->state->name }} - {{ $order->address->pincode }}
    </p>

    <hr>

    {{-- ITEMS TABLE --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->product->name ?? 'Product removed' }}</strong>
                </td>
                <td>₹{{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            @if($order->cgst > 0)
            <tr>
                <td colspan="3" class="text-end">CGST</td>
                <td>₹{{ number_format($order->cgst, 2) }}</td>
            </tr>
            @endif

            @if($order->sgst > 0)
            <tr>
                <td colspan="3" class="text-end">SGST</td>
                <td>₹{{ number_format($order->sgst, 2) }}</td>
            </tr>
            @endif

            @if($order->igst > 0)
            <tr>
                <td colspan="3" class="text-end">IGST</td>
                <td>₹{{ number_format($order->igst, 2) }}</td>
            </tr>
            @endif

            <tr>
                <td colspan="3" class="text-end"><strong>Grand Total</strong></td>
                <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

</div>

<script>document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.order-status-select').forEach(select => {
        select.addEventListener('change', function (e) {

            const form = this.closest('form');
            const oldStatus = this.dataset.currentStatus;
            const newStatus = this.value;

            // same status → kuch mat karo
            if (oldStatus === newStatus) {
                return;
            }

            const confirmed = confirm(
                `Are you sure you want to change order status from "${oldStatus}" to "${newStatus}"?`
            );

            if (confirmed) {
                form.submit();
            } else {
                // revert back
                this.value = oldStatus;
            }
        });
    });
});

// Print functionality
if(window.location.search.includes('print=true')) {
    window.onload = function() {
        window.print();
    }
}
</script>
<style>
@media print {

    /* SAB KUCH HIDE */
    body * {
        visibility: hidden !important;
    }

    /* SIRF INVOICE DIKHE */
    #print-invoice,
    #print-invoice * {
        visibility: visible !important;
    }

    #print-invoice {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    /* Buttons, dropdowns, links hatao */
    button, a, select, .btn {
        display: none !important;
    }

    /* Table clean */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 6px !important;
        font-size: 12px;
    }

    h3, h4 {
        margin-top: 10px;
    }
}
</style>

<!-- Print Styles -->
<style>
@media print {
    .btn, .navbar, .sidebar, .footer {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .card-header {
        background: #fff !important;
        color: #000 !important;
        border-bottom: 2px solid #000 !important;
    }
    body {
        padding: 20px !important;
    }
}
</style>
@endsection