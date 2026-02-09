@extends('admin.layouts.app')
@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="card">
                <div class="row">
                        <div class="card-header">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Orders Management</h4>
                                         <span class="badge border border-success text-success bg-transparent">
    Today Orders: {{ $todayOrders }}
</span>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item  text-white active">Orders</li>
                                </ol>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Stats Cards -->
            

                <!-- Search and Filter Card -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                            
                                    <!-- Search Input -->
                                    <div class="col-md-6">
                                        <form method="GET" action="{{ route('admin.orders') }}">
                                            <div class="input-group">
                                                <input type="text" 
                                                       name="search" 
                                                       class="form-control" 
                                                       placeholder="Search by order number, customer name, phone or email..."
                                                       value="{{ request('search') }}">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bx bx-search"></i> Search
                                                </button>
                                                @if(request('search'))
                                                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                                                    <i class="bx bx-x"></i> Clear
                                                </a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- Status Filter -->
                                    <div class="col-md-6">
                                        <form method="GET" action="{{ route('admin.orders') }}" id="statusForm">
                                            <div class="input-group">
                                                <select name="status" class="form-select form-control" onchange="this.form.submit()">
                                                    <option value="all" {{ !request('status') || request('status') == 'all' ? 'selected' : '' }}>
                                                        All Status
                                                    </option>
                                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                                        Processing
                                                    </option>
                                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>
                                                        Shipped
                                                    </option>
                                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                                        Delivered
                                                    </option>
                                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                                        Cancelled
                                                    </option>
                                                </select>
                                                @if(request('status'))
                                                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                                                    <i class="bx bx-filter-alt"></i> Clear Filter
                                                </a>
                                                @endif
                                            </div>
                                            <!-- Keep search parameter when filtering -->
                                            @if(request('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Orders List</h4>
                                    <!-- <div class="text-muted">
                                        Showing {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-hover table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Total Price</th>
                                                <th>Order Date</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                                <td>
                                                    <strong>{{ $order->order_number }}</strong>
                                                    @if($order->user)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="bx bx-user"></i> {{ $order->user->name }}
                                                    </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->address)
                                                    <div>
                                                        <strong>{{ $order->address->full_name }}</strong><br>
                                                        <small class="text-muted">
                                                            <i class="bx bx-phone"></i> {{ $order->address->phone }}
                                                        </small>
                                                    </div>
                                                    @else
                                                    <span class="text-danger">No address</span>
                                                    @endif
                                                </td>
                                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->payment_method == 'cod' ? 'warning' : 'success' }} text-uppercase">
                                                        {{ $order->payment_method }}
                                                    </span>
                                                </td>
                                                <td>
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


                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.orders.view', $order->id) }}" 
                                                           class="btn btn-primary btn-sm" 
                                                           title="View Details">
                                                            <i class="bx bx-show"></i> View
                                                        </a>
                                                        <!-- <a href="{{ route('admin.orders.view', $order->id) }}?print=true" 
                                                           target="_blank"
                                                           class="btn btn-secondary btn-sm" 
                                                           title="Print Invoice">
                                                            <i class="bx bx-printer"></i>
                                                        </a> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                            @if($orders->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="empty-state">
                                                        <i class="bx bx-package display-4 text-muted"></i>
                                                        <h5 class="mt-3">No orders found</h5>
                                                        <p class="text-muted">
                                                            @if(request('search') || request('status'))
                                                            Try adjusting your search or filter criteria
                                                            @else
                                                            No orders have been placed yet
                                                            @endif
                                                        </p>
                                                        @if(request('search') || request('status'))
                                                        <a href="{{ route('admin.orders') }}" class="btn btn-primary mt-2">
                                                            <i class="bx bx-refresh"></i> Reset Filters
                                                        </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" role="status" aria-live="polite">
                                            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="d-flex justify-content-end">
                                            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX Status Update -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status change with AJAX
   
    
    function updateOrderStatus(orderId, status, dropdown) {
        const form = dropdown.closest('form');
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update original value
                dropdown.setAttribute('data-original-value', status);
                
                // Show success message
                showToast('Success', 'Order status updated successfully', 'success');
                
                // Update badge color if needed
                updateStatusBadge(dropdown, status);
                
                // Reload page after 1 second to update stats
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Reset to original value
                dropdown.value = dropdown.getAttribute('data-original-value');
                showToast('Error', data.message || 'Failed to update status', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            dropdown.value = dropdown.getAttribute('data-original-value');
            showToast('Error', 'Something went wrong. Please try again.', 'error');
        });
    }
    
    function updateStatusBadge(dropdown, status) {
        const row = dropdown.closest('tr');
        const badge = row.querySelector('.status-badge');
        if(badge) {
            // Update badge class based on status
            const statusClasses = {
                'pending': 'bg-warning',
                'processing': 'bg-info',
                'shipped': 'bg-primary',
                'delivered': 'bg-success',
                'cancelled': 'bg-danger'
            };
            
            // Remove existing status classes
            Object.values(statusClasses).forEach(cls => {
                badge.classList.remove(cls);
            });
            
            // Add new class
            badge.classList.add(statusClasses[status]);
            badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        }
    }
    
    function showToast(title, message, type = 'success') {
        // You can use your preferred toast notification library
        // For example, using Bootstrap toast or SweetAlert
        alert(message); // Simple alert for now
    }
});
document.addEventListener('DOMContentLoaded', function () {
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
</script>


<style>
/* Custom Styles */
.card-animate {
    transition: transform 0.3s;
}

.card-animate:hover {
    transform: translateY(-5px);
}

.status-dropdown {
    cursor: pointer;
    transition: all 0.3s;
}

.status-dropdown:hover {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.status-dropdown option[value="pending"] {
    background-color: #fff3cd;
}

.status-dropdown option[value="processing"] {
    background-color: #d1ecf1;
}

.status-dropdown option[value="shipped"] {
    background-color: #cce5ff;
}

.status-dropdown option[value="delivered"] {
    background-color: #d4edda;
}

.status-dropdown option[value="cancelled"] {
    background-color: #f8d7da;
}

.empty-state {
    text-align: center;
    padding: 2rem;
}

.empty-state i {
    opacity: 0.5;
}

/* Badge colors */
.badge.bg-warning {
    background-color: #ffc107 !important;
}

.badge.bg-info {
    background-color: #0dcaf0 !important;
}

.badge.bg-primary {
    background-color: #0d6efd !important;
}

.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-title-box {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .page-title-right {
        margin-top: 0.5rem;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
}
</style>
@endsection