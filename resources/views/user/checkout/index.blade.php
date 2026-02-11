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
                            <li class="breadcrumb-item">
                                <a href="{{ route('user.cart.index') }}">Cart</a>
                            </li>
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            <i class="fas fa-shopping-bag me-2 text-primary"></i>Checkout
                        </h4>
                    </div>
                </div>
            </div>

            @if(!$cartItems || $cartItems->count() == 0)
            <!-- Empty Cart -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4>Your cart is empty</h4>
                    <p class="text-muted mb-4">Add some products to your cart before checkout.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-basket me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
            @else
            <!-- Checkout Form -->
            <form method="POST" action="{{ route('user.checkout.place') }}" id="checkoutForm">
                @csrf
                
                <div class="row">
                    <!-- Left Column: Address & Payment -->
                    <div class="col-lg-8">
                        <!-- Delivery Address -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-map-marker-alt me-2"></i>Delivery Address
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($addresses && $addresses->count() > 0)
                                <!-- Saved Addresses -->
                                <div class="row mb-3">
                                    @foreach($addresses as $address)
                                    <div class="col-md-6 mb-3">
                                        <label class="address-card d-block">
                                            <input type="radio" 
                                                   name="address_id" 
                                                   value="{{ $address->id }}"
                                                   {{ $address->is_default ? 'checked' : '' }}
                                                   class="d-none"
                                                   required>
                                            <div class="card border {{ $address->is_default ? 'border-primary' : 'border-light' }} h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <strong>{{ $address->full_name }}</strong>
                                                        @if($address->is_default)
                                                        <span class="badge bg-primary">Default</span>
                                                        @endif
                                                    </div>
                                                    <p class="mb-1">{{ $address->phone }}</p>
                                                    <p class="text-muted small mb-1">
                                                        {{ $address->address_line1 }}
                                                        @if($address->address_line2)
                                                        <br>{{ $address->address_line2 }}
                                                        @endif
                                                    </p>
                                                    <p class="text-muted small mb-0">
                                                        {{ $address->city }}, 
                                                        {{ $address->state->name ?? $address->state_id }} - {{ $address->pincode }}
                                                    </p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                
                                <!-- Add New Address Button -->
                                <button type="button" 
                                        class="btn btn-outline-primary w-100" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#newAddressForm">
                                    <i class="fas fa-plus me-2"></i>Add New Address
                                </button>
                                
                                <!-- New Address Form -->
                                <div class="collapse mt-3" id="newAddressForm">
                                    <div class="card card-body">
                                        <h6 class="mb-3">Add New Address</h6>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Full Name *</label>
                                                <input type="text" 
                                                       name="new_full_name" 
                                                       class="form-control" 
                                                       placeholder="John Doe">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Phone Number *</label>
                                                <input type="tel" 
                                                       name="new_phone" 
                                                       class="form-control" 
                                                       placeholder="9876543210">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label>Address Line 1 *</label>
                                                <input type="text" 
                                                       name="new_address_line1" 
                                                       class="form-control" 
                                                       placeholder="House no., Street, Area">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label>Address Line 2 (Optional)</label>
                                                <input type="text" 
                                                       name="new_address_line2" 
                                                       class="form-control" 
                                                       placeholder="Apartment, Floor, etc.">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>City *</label>
                                                <input type="text" 
                                                       name="new_city" 
                                                       class="form-control" 
                                                       placeholder="Mumbai">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>State *</label>
                                                <select name="new_state_id" class="form-control">
                                                    <option value="">Select State</option>
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Pincode *</label>
                                                <input type="text" 
                                                       name="new_pincode" 
                                                       class="form-control" 
                                                       placeholder="400001">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           name="save_new_address" 
                                                           class="form-check-input" 
                                                           id="saveAddress" checked>
                                                    <label class="form-check-label" for="saveAddress">
                                                        Save this address for future orders
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-credit-card me-2"></i>Payment Method
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="payment-option d-block">
                                            <input type="radio" 
                                                   name="payment_method" 
                                                   value="cod" 
                                                   class="d-none" 
                                                   checked required>
                                            <div class="card border h-100">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-money-bill-wave fa-2x text-warning mb-3"></i>
                                                    <h6>Cash on Delivery</h6>
                                                    <p class="small text-muted">Pay when you receive the order</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="payment-option d-block">
                                            <input type="radio" 
                                                   name="payment_method" 
                                                   value="online" 
                                                   class="d-none">
                                            <div class="card border h-100">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-globe fa-2x text-primary mb-3"></i>
                                                    <h6>Online Payment</h6>
                                                    <p class="small text-muted">Pay securely with UPI/Card/Net Banking</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Order Summary -->
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-receipt me-2"></i>Order Summary
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Order Items Table -->
                                <div class="table-responsive mb-3">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $subtotal = 0;
                                            @endphp
                                            @foreach($cartItems as $item)
                                            @php
                                                $itemTotal = $item->price_at_that_time * $item->quantity;
                                                $subtotal += $itemTotal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <small>{{ $item->product->name ?? 'Product removed' }}</small>
                                                </td>
                                                <td class="text-end">
                                                    <small>₹{{ number_format($item->price_at_that_time, 2) }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <small>{{ $item->quantity }}</small>
                                                </td>
                                                <td class="text-end">
                                                    <small>₹{{ number_format($itemTotal, 2) }}</small>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal</span>
                                        <span>₹{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    
                                    <!-- Tax Calculation -->
                                    @php
                                        $taxableAmount = $subtotal;
                                        $gstRate = 18; // 18% GST
                                        $cgst = 0;
                                        $sgst = 0;
                                        $igst = 0;
                                        
                                        // You can implement state-based tax logic here
                                        $tax = ($taxableAmount * $gstRate) / 100;
                                        $cgst = $tax / 2;
                                        $sgst = $tax / 2;
                                    @endphp
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>CGST ({{ $gstRate/2 }}%)</span>
                                        <span>₹{{ number_format($cgst, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>SGST ({{ $gstRate/2 }}%)</span>
                                        <span>₹{{ number_format($sgst, 2) }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping</span>
                                        <span class="text-success">FREE</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                                        <span>Total</span>
                                        <span>₹{{ number_format($subtotal + $cgst + $sgst, 2) }}</span>
                                    </div>
                                    
                                    <!-- Coupon Code -->
                                    <div class="mb-3">
                                        <label class="form-label">Coupon Code (Optional)</label>
                                        <div class="input-group">
                                            <input type="text" 
                                                   name="coupon_code" 
                                                   class="form-control" 
                                                   placeholder="Enter coupon code">
                                            <button type="button" 
                                                    class="btn btn-outline-secondary" 
                                                    onclick="applyCoupon()">
                                                Apply
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Place Order Button -->
                                    <button type="submit" 
                                            class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-shopping-bag me-2"></i>
                                        Place Order
                                    </button>
                                    
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-lock me-1"></i>
                                            Your payment information is secure
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Need Help -->
                        <div class="card">
                            <div class="card-body">
                                <h6><i class="fas fa-question-circle me-2 text-primary"></i>Need Help?</h6>
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-phone me-1"></i>
                                    Call us: +91 9876543210
                                </p>
                                <p class="small text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    Support available: 9AM - 6PM
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif

        </div>
    </div>
</div>

<script>
    function applyCoupon() {
        const couponCode = document.querySelector('input[name="coupon_code"]').value;
        
        if (!couponCode.trim()) {
            alert('Please enter a coupon code');
            return;
        }
        
        // You can add AJAX call here to validate coupon
        alert('Coupon code applied: ' + couponCode);
    }
    
    // Address selection
    document.querySelectorAll('.address-card input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.address-card .card').forEach(card => {
                card.classList.remove('border-primary');
                card.classList.add('border-light');
            });
            
            this.closest('.address-card').querySelector('.card').classList.add('border-primary');
            this.closest('.address-card').querySelector('.card').classList.remove('border-light');
        });
    });
    
    // Payment method selection
    document.querySelectorAll('.payment-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-option .card').forEach(card => {
                card.classList.remove('border-primary');
            });
            
            this.closest('.payment-option').querySelector('.card').classList.add('border-primary');
        });
    });
    
    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const addressSelected = document.querySelector('input[name="address_id"]:checked');
        const newAddress = document.getElementById('newAddressForm').classList.contains('show');
        
        if (!addressSelected && !newAddress) {
            e.preventDefault();
            alert('Please select or add a delivery address');
            return false;
        }
        
        if (newAddress) {
            const requiredFields = [
                'new_full_name',
                'new_phone',
                'new_address_line1',
                'new_city',
                'new_state_id',
                'new_pincode'
            ];
            
            for (const fieldName of requiredFields) {
                const field = document.querySelector(`input[name="${fieldName}"], select[name="${fieldName}"]`);
                if (field && !field.value.trim()) {
                    e.preventDefault();
                    alert(`Please fill in ${fieldName.replace('new_', '').replace('_', ' ')}`);
                    field.focus();
                    return false;
                }
            }
        }
        
        return true;
    });
</script>

<style>
    .address-card .card {
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .address-card .card:hover {
        border-color: #0d6efd !important;
    }
    
    .address-card input:checked + .card {
        border-color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .payment-option .card {
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .payment-option .card:hover {
        border-color: #0d6efd !important;
    }
    
    .payment-option input:checked + .card {
        border-color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .table-sm th,
    .table-sm td {
        padding: 0.5rem;
    }
    
    .table-sm {
        font-size: 0.875rem;
    }
    
    @media (max-width: 768px) {
        .payment-option .card-body {
            padding: 1rem;
        }
        
        .payment-option i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection