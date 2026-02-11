@extends('user.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Breadcrumb -->
            <div class="row mb-3">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.index') }}">
                                    <i class="fas fa-home"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Shopping Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            <i class="fas fa-shopping-cart me-2 text-primary"></i>My Shopping Cart
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Cart Table -->
            <div class="card">
                <div class="card-body">
                    @if($cartItems && $cartItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="60px"></th>
                                    <th>Product</th>
                                    <th width="120px" class="text-center">Price</th>
                                    <th width="150px" class="text-center">Quantity</th>
                                    <th width="120px" class="text-center">Total</th>
                                    <th width="80px" class="text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                    $shipping = 0;
                                @endphp
                                
                                @foreach($cartItems as $item)
                                @php
                                    $itemTotal = $item->price_at_that_time * $item->quantity;
                                    $subtotal += $itemTotal;
                                @endphp
                                <tr>
                                    <!-- Image -->
                                    <td class="text-center">
                                        @if($item->product && $item->product->primary_image)
                                            <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="rounded"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Product Details -->
                                    <td>
                                        @if($item->product)
                                            <a href="{{ route('site.product', $item->product->slug) }}" 
                                               class="text-decoration-none text-dark fw-bold">
                                                {{ $item->product->name }}
                                            </a>
                                            
                                            @if($item->product->stock_qty <= 0)
                                                <div class="mt-1">
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                </div>
                                            @elseif($item->product->stock_qty < $item->quantity)
                                                <div class="mt-1">
                                                    <span class="badge bg-warning">
                                                        Only {{ $item->product->stock_qty }} in stock
                                                    </span>
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-danger">Product removed</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Price -->
                                    <td class="text-center">
                                        ₹{{ number_format($item->price_at_that_time, 2) }}
                                    </td>
                                    
                                    <!-- Quantity -->
                                    <td class="text-center">
                                        <div class="quantity-control d-flex align-items-center justify-content-center">
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    onclick="updateQuantity({{ $item->id }}, 'decrease')"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            
                                            <input type="number" 
                                                   class="form-control form-control-sm text-center mx-2" 
                                                   value="{{ $item->quantity }}" 
                                                   min="1" 
                                                   max="{{ $item->product ? $item->product->stock_qty : 99 }}"
                                                   style="width: 60px;"
                                                   onchange="updateQuantityInput({{ $item->id }}, this.value)">
                                            
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    onclick="updateQuantity({{ $item->id }}, 'increase')"
                                                    {{ $item->product && $item->quantity >= $item->product->stock_qty ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    
                                    <!-- Total -->
                                    <td class="text-center fw-bold">
                                        ₹{{ number_format($itemTotal, 2) }}
                                    </td>
                                    
                                    <!-- Remove -->
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger" 
                                                onclick="removeFromCart({{ $item->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Summary -->
                    <div class="row mt-4">
                       
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">Cart Summary</h5>
                                    
                                
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                                        <span>Total</span>
                                        <span>₹{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                       <button onclick="proceedToCheckout()" 
        class="btn btn-primary text-white btn-lg">
    <i class="fas fa-shopping-bag me-2"></i>Proceed to Checkout
</button>
                                        
                                        <a href="{{ route('user.product') }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="fas fa-shopping-basket me-2"></i>Continue Shopping
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @else
                    <!-- Empty Cart -->
                    <div class="text-center py-5">
                        <div class="empty-cart-icon mb-4">
                            <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                        </div>
                        <h4>Your cart is empty</h4>
                        <p class="text-muted mb-4">Add some products to your cart to see them here.</p>
                        <a href="{{ route('user.product') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-basket me-2"></i>Start Shopping
                        </a>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function updateQuantity(cartId, action) {
        const quantityInput = document.querySelector(`input[onchange*="${cartId}"]`);
        let newQuantity = parseInt(quantityInput.value);
        
        if (action === 'increase') {
            newQuantity += 1;
        } else if (action === 'decrease') {
            newQuantity -= 1;
        }
        
        // Minimum quantity check
        if (newQuantity < 1) newQuantity = 1;
        
        updateCartItem(cartId, newQuantity);
    }
    
    function updateQuantityInput(cartId, quantity) {
        if (quantity < 1) quantity = 1;
        updateCartItem(cartId, parseInt(quantity));
    }
    
    function updateCartItem(cartId, quantity) {
        fetch('/cart/' + cartId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong!');
        });
    }
    
    function removeFromCart(cartId) {
        if (confirm('Are you sure you want to remove this item from cart?')) {
            fetch('/cart/' + cartId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to remove item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong!');
            });
        }
    }
    function proceedToCheckout() {

    fetch('/cart/validate', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {
            window.location.href = "{{ route('user.checkout') }}";
        } else {
            alert(data.message);
        }

    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong");
    });
}

    function clearCart() {
        if (confirm('Are you sure you want to clear your cart?')) {
            fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
</script>

<style>
    .quantity-control {
        max-width: 150px;
        margin: 0 auto;
    }
    
    .quantity-control input[type="number"] {
        -moz-appearance: textfield;
    }
    
    .quantity-control input[type="number"]::-webkit-outer-spin-button,
    .quantity-control input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    .empty-cart-icon {
        opacity: 0.5;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection