<div>
    <link rel="stylesheet" href="{{ asset('site/checkout-page.css') }}">

    <div class="checkout-wrapper">
        <!-- Progress Bar -->
        <div class="checkout-progress">
            <div class="progress-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Cart</div>
                </div>
                <div class="step-line active"></div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-label">Checkout</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
        </div>

        <div class="checkout-container">
            <!-- LEFT SIDE: ADDRESS FORM -->
            <div class="checkout-left">
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="icon-location"></i> Select Delivery Address
                    </h2>
                    <!-- Guest Login Form - Simple (No OTP) -->
@if($showGuestLoginForm)
<div class="guest-login-overlay">
    <div class="guest-login-modal">
        <div class="modal-header">
            <h2>Quick Checkout</h2>
            <p>Enter your details to continue</p>
        </div>
        
        <div class="modal-body">
            <div class="form-group">
                <label>Your Name *</label>
                <input type="text" class="form-input" 
                       wire:model="guestName" 
                       placeholder="Enter your full name"
                       wire:keydown.enter="loginOrRegister"
                       autofocus>
                @error('guestName') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label>Phone Number *</label>
                <div class="input-with-flag">
                    <span class="country-code">+91</span>
                    <input type="tel" class="form-input" 
                           wire:model="guestPhone" 
                           placeholder="9876543210" 
                           maxlength="10"
                           wire:keydown.enter="loginOrRegister">
                </div>
                @error('guestPhone') <span class="error-message">{{ $message }}</span> @enderror
                <small class="text-info">We'll save this for your future orders</small>
            </div>
            
            
            
            <button type="button" class="btn-continue" 
                    wire:click="loginOrRegister"
                    wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="loginOrRegister">
                    Continue to Checkout
                </span>
                <span wire:loading wire:target="loginOrRegister">
                    <i class="loading-spinner"></i> Processing...
                </span>
            </button>
            
           
            
            @if(session()->has('error'))
            <div class="alert alert-error mt-3">
                <i class="icon-error"></i> {{ session('error') }}
            </div>
            @endif
            
            @if(session()->has('success'))
            <div class="alert alert-success mt-3">
                <i class="icon-success"></i> {{ session('success') }}
            </div>
            @endif
            
            @if(session()->has('info'))
            <div class="alert alert-info mt-3">
                <i class="icon-info"></i> {{ session('info') }}
            </div>
            @endif
        </div>
        
        <div class="modal-footer">
            <p class="terms-text">
                By continuing, you agree to our Terms of Service
            </p>
        </div>
    </div>
</div>
@endif
                    <!-- Saved Addresses -->
@if($addresses && $addresses->count() > 0)
                    <div class="saved-addresses">
                        @foreach($addresses as $address)
                        <label class="address-option @if($selectedAddressId == $address->id) selected @endif">
                            <input type="radio" name="selectedAddress" 
                                   wire:model="selectedAddressId" @if($selectedAddressId == $address->id) checked @endif 
                                   value="{{ $address->id }}" hidden>
                            <div class="address-card">
                                <div class="address-header">
                                    <span class="address-type {{ $address->type }}">
                                        {{ ucfirst($address->type) }}
                                    </span>
                                    @if($address->is_default)
                                    <span class="default-badge">Default</span>
                                    @endif
                                </div>
                                <div class="address-details">
                                    <h4>{{ $address->full_name }}</h4>
                                    <p class="phone">{{ $address->phone }}</p>
                                    <p class="address-text">
                                        {{ $address->address_line1 }}
                                        @if($address->address_line2)
                                        <br>{{ $address->address_line2 }}
                                        @endif
                                        @if($address->landmark)
                                        <br>Near {{ $address->landmark }}
                                        @endif
                                        <br>{{ $address->city }}, {{ $address->state?->name }} - {{ $address->pincode }}
                                    </p>
                                </div>
                                <div class="address-selector">
                                    <div class="radio-circle"></div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @endif
                    
                    <!-- Add New Address Button -->
                    <button type="button" class="btn-add-address" 
                            wire:click="$toggle('showNewAddressForm')">
                        <i class="icon-plus"></i>
                        {{ $showNewAddressForm ? 'Cancel' : 'Add New Address' }}
                    </button>
                    
                    <!-- New Address Form -->
                    @if($showNewAddressForm)
                    <div class="new-address-form">
                        <h3 class="form-subtitle">Add New Address</h3>
                        
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" class="form-input" placeholder="John Doe" 
                                   wire:model="full_name">
                            @error('full_name') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <div class="input-with-flag">
                                <span class="country-code">+91</span>
                                <input type="tel" class="form-input" placeholder="9876543210" 
                                       wire:model="phone">
                            </div>
                            @error('phone') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Address Type</label>
                            <div class="address-type-selector">
                                <label class="type-option @if($address_type == 'home') selected @endif">
                                    <input type="radio" wire:model="address_type" value="home" hidden>
                                    <i class="icon-home"></i>
                                    <span>Home</span>
                                </label>
                                <label class="type-option @if($address_type == 'office') selected @endif">
                                    <input type="radio" wire:model="address_type" value="office" hidden>
                                    <i class="icon-office"></i>
                                    <span>Office</span>
                                </label>
                                <label class="type-option @if($address_type == 'other') selected @endif">
                                    <input type="radio" wire:model="address_type" value="other" hidden>
                                    <i class="icon-other"></i>
                                    <span>Other</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Address Line 1 *</label>
                            <input type="text" class="form-input" placeholder="House no., Street, Area" 
                                   wire:model="address_line1">
                            @error('address_line1') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Address Line 2 (Optional)</label>
                            <input type="text" class="form-input" placeholder="Apartment, Floor, etc." 
                                   wire:model="address_line2">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Landmark (Optional)</label>
                                <input type="text" class="form-input" placeholder="Nearby landmark" 
                                       wire:model="landmark">
                            </div>
                            <div class="form-group">
                                <label>Pincode *</label>
                                <input type="text" class="form-input" placeholder="400001" 
                                       wire:model="pincode">
                                @error('pincode') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>City *</label>
                                <input type="text" class="form-input" placeholder="Mumbai" 
                                       wire:model="city">
                                @error('city') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                            <label>State *</label>
                            <select class="form-input" wire:model="state_id">
                                <option value="">Select State</option>
                                @foreach($states as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>

                            @error('state_id') 
                                <span class="error-message">{{ $message }}</span> 
                            @enderror
                        </div>

                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" wire:model="save_address" checked>
                                <span>Save this address for future orders</span>
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-save-address" 
                                    wire:click="saveNewAddress" 
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveNewAddress">
                                    {{ $save_address ? 'Save Address' : 'Use This Address' }}
                                </span>
                                <span wire:loading wire:target="saveNewAddress">
                                    <i class="loading-spinner"></i> Processing...
                                </span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="form-section">
                    <h2 class="section-title">
                        <i class="icon-credit-card"></i> Payment Method
                    </h2>
                    <div class="payment-methods">
                        <label class="payment-option @if($paymentMethod === 'cod') selected @endif" 
                               wire:click="$set('paymentMethod', 'cod')">
                            <input type="radio" wire:model="paymentMethod" value="cod" hidden>
                            <div class="payment-icon">
                                <i class="icon-cash"></i>
                            </div>
                            <div class="payment-info">
                                <h4>Cash on Delivery</h4>
                                <p>Pay when you receive the order</p>
                            </div>
                            <div class="payment-selector">
                                <div class="radio-circle"></div>
                            </div>
                        </label>

                        <label class="payment-option @if($paymentMethod === 'online') selected @endif" 
                               wire:click="$set('paymentMethod', 'online')">
                            <input type="radio" wire:model="paymentMethod" value="online" hidden>
                            <div class="payment-icon">
                                <i class="icon-online"></i>
                            </div>
                            <div class="payment-info">
                                <h4>Online Payment</h4>
                                <p>Pay securely with UPI/Card/Net Banking</p>
                            </div>
                            <div class="payment-selector">
                                <div class="radio-circle"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: ORDER SUMMARY -->
            <div class="checkout-right">
                <div class="order-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="cart-items">
                        @foreach($cartItems as $item)
                            <div class="cart-item">
                                <div class="item-image">
                                    <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                         alt="{{ $item->product->name }}">
                                    <span class="item-quantity">{{ $item->quantity }}</span>
                                </div>
                                <div class="item-details">
                                    <h4>{{ $item->product->name }}</h4>
                                    <p class="item-price">₹{{ number_format($item->price_at_that_time) }} each</p>
                                </div>
                                <div class="item-total">
                                    ₹{{ number_format($item->price_at_that_time * $item->quantity) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                   <div class="price-breakdown">
    <div class="price-row">
        <span>Subtotal</span>
        <span>₹{{ number_format($subtotal) }}</span>
    </div>
    
    @if($discount > 0)
    <div class="price-row discount">
        <span>Discount</span>
        <span class="discount-amount">-₹{{ number_format($discount) }}</span>
    </div>
    @endif
    
    <div class="price-row">
        <span>Taxable Amount</span>
        <span>₹{{ number_format($taxableAmount) }}</span>
    </div>
    
    <!-- Tax Details - यहाँ tax show करो -->
   @if($selectedAddressId)
    @if($cgst > 0)
        <div class="price-row">
            <span>CGST ({{ $gstRate / 2 }}%)</span>
            <span>₹{{ number_format($cgst, 2) }}</span>
        </div>
        <div class="price-row">
            <span>SGST ({{ $gstRate / 2 }}%)</span>
            <span>₹{{ number_format($sgst, 2) }}</span>
        </div>
    @elseif($igst > 0)
        <div class="price-row">
            <span>IGST ({{ $gstRate }}%)</span>
            <span>₹{{ number_format($igst, 2) }}</span>
        </div>
    @endif
@endif

    
    <div class="price-row">
        <span>Shipping</span>
        @if($shipping == 0)
    <span class="free-shipping">FREE</span>
@else
    ₹{{ number_format($shipping, 2) }}
@endif

    </div>
    <div class="coupon-box">
    <label for="coupon-input" class="coupon-label">
        Have a Coupon?
    </label>

    <div class="coupon-input-wrapper">
        <input type="text" 
               id="coupon-input" 
               wire:model="couponCode"
               placeholder="Enter coupon code">
        
        <button type="button"
                wire:click="applyCoupon"
                wire:loading.attr="disabled"
                class="apply-coupon-btn">
            Apply
        </button>
    </div>

    @if($couponApplied)
        <p class="coupon-success">
            Coupon <strong>{{ $couponCode }}</strong> applied successfully!
        </p>
    @endif

    @if($couponError)
        <p class="coupon-error">
            {{ $couponError }}
        </p>
    @endif
</div>

    
   <div class="price-row total">
    <span>Grand Total</span>
    <!-- <span class="total-amount">₹{{ number_format($taxableAmount + $cgst + $sgst + $igst + $shipping, 2) }}</span> -->
<span class="total-amount">₹{{ number_format($grandTotal, 2) }}</span>

</div>

</div>

<!-- Tax Information Box -->
@if($selectedAddressId)
    <div class="tax-info-box d-none">
        @php
            $adminState = $states->find($adminGstStateId);
            $customerState = null;
            
            if($selectedAddressId !== 'temp') {
                $address = $addresses->where('id', $selectedAddressId)->first();
                $customerState = $address ? $states->find($address->state_id) : null;
            } else {
                $customerState = $states->find($state_id);
            }
        @endphp
        
        <!-- <h5><i class="icon-info-circle"></i> Tax Information</h5> -->
        
        @if($adminState && $customerState)
            @if($customerState && $customerState->id == $adminState->id)
            @elseif($customerState)
            @endif
        @else
            <p>Select a delivery address to see tax calculation</p>
        @endif
    </div>
@endif

                    <!-- Delivery Address Preview -->
                    @if($selectedAddressId && $selectedAddressId !== 'temp')
                        @php $selectedAddress = $addresses->where('id', $selectedAddressId)->first() @endphp
                        @if($selectedAddress)
                        <div class="delivery-preview">
                            <h4><i class="icon-truck"></i> Delivering to:</h4>
                            <div class="preview-address">
                                <strong>{{ $selectedAddress->full_name }}</strong>
                                <p>{{ $selectedAddress->phone }}</p>
                                <p class="address-text">
                                    {{ $selectedAddress->address_line1 }}
                                    @if($selectedAddress->address_line2)
                                    <br>{{ $selectedAddress->address_line2 }}
                                    @endif
                                    @if($selectedAddress->landmark)
                                    <br>Near {{ $selectedAddress->landmark }}
                                    @endif
                                    <br>{{ $selectedAddress->city }}, {{ $selectedAddress->state?->name }} - {{ $selectedAddress->pincode }}
                                </p>
                            </div>
                        </div>
                        @endif
                    @elseif($showNewAddressForm)
                        <div class="delivery-preview">
                            <h4><i class="icon-truck"></i> New Delivery Address:</h4>
                            <div class="preview-address">
                                <strong>{{ $full_name ?: 'Not specified' }}</strong>
                                <p>{{ $phone ?: 'Not specified' }}</p>
                                <p class="address-text">
                                    {{ $address_line1 ?: 'Not specified' }}
                                    @if($address_line2)
                                    <br>{{ $address_line2 }}
                                    @endif
                                    @if($landmark)
                                    <br>Near {{ $landmark }}
                                    @endif
                                    <br>{{ $city ?: 'Not specified' }}, {{ $state_id ? ($states->find($state_id)->name ?? 'Not specified') : 'Not specified' }} - {{ $pincode ?: 'Not specified' }}
                                </p>
                                <small class="text-warning">
                                    {{ $save_address ? 'This address will be saved' : 'This address is for one-time use only' }}
                                </small>
                            </div>
                        </div>
                    @endif
                            @if($paymentMethod === 'cod')

                   <button type="button" class="btn-place-order" 
                            wire:click="placeOrder" 
                            wire:loading.attr="disabled"
                            id="place-order-btn"
                            @if(!$selectedAddressId) disabled @endif>
                        <span wire:loading.remove wire:target="placeOrder">
                                Place Order (₹{{ number_format($grandTotal,2) }})
                           
                        </span>
                        <span wire:loading wire:target="placeOrder">
                            <i class="loading-spinner"></i> Processing...
                        </span>
                    </button>
                            @else

                    <button type="button"
        class="btn-place-order"
        wire:click="startOnlinePayment"
        wire:loading.attr="disabled"
        wire:target="startOnlinePayment"
        id="online-pay-btn">
    <span wire:loading.remove wire:target="startOnlinePayment">
        Pay Online ₹{{ number_format($grandTotal,2) }}
    </span>
    <span wire:loading wire:target="startOnlinePayment">
        <i class="loading-spinner"></i> Initializing Payment...
    </span>
</button>


 @endif
                    @if(session()->has('error'))
                    <div class="alert alert-error">
                        <i class="icon-error"></i> {{ session('error') }}
                    </div>
                    @endif

                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        <i class="icon-success"></i> {{ session('message') }}
                    </div>
                    @endif

                    <div class="security-notice">
                        <i class="icon-shield"></i>
                        <span>Your payment information is secure and encrypted</span>
                    </div>

                    <div class="return-policy">
                        <h4><i class="icon-return"></i> Easy Returns</h4>
                        <p>30-day return policy. Full refund if items are unused and in original condition.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('site-scripts')
        
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    console.log("Checkout page loaded");

    // Livewire initialization
    document.addEventListener('livewire:init', () => {
        console.log("✅ Livewire initialized");

        // Razorpay event listener
        Livewire.on('startRazorpayCheckout', (data) => {
            console.log("🎯 Razorpay event received:", data);
            
            // Check if Razorpay is loaded
            if (typeof Razorpay === 'undefined') {
                console.error("❌ Razorpay script not loaded!");
                alert("Payment gateway loading error. Please refresh page.");
                return;
            }
            
            console.log("💰 Amount to pay:", data.amount);
            console.log("🆔 Order ID:", data.order_id);
            
            // Razorpay options
            var options = {
                key: "{{ config('services.razorpay.key') }}",
                amount: data.amount,
                currency: "INR",
                name: "{{ config('app.name') }}",
                description: "Order Payment",
                order_id: data.order_id,
                handler: function (response) {
                    console.log("✅ Payment success:", response);
                    
                    // Dispatch to Livewire
                    Livewire.dispatch('razorpaySuccess', {
                        paymentId: response.razorpay_payment_id,
                        orderId: response.razorpay_order_id,
                        signature: response.razorpay_signature
                    });
                },
                prefill: {
                    name: data.name,
                    contact: data.phone,
                    email: data.email || "customer@example.com"
                },
                theme: {
                    color: "#3399cc"
                },
                modal: {
                    ondismiss: function() {
                        console.log("Payment modal closed by user");
                    }
                }
            };
            
            var rzp = new Razorpay(options);
            
            // Event listeners for debugging
            rzp.on('payment.failed', function(response) {
                console.error("❌ Payment failed:", response.error);
                alert("Payment failed: " + response.error.description);
            });
            
            rzp.on('payment.cancelled', function() {
                console.log("Payment cancelled by user");
            });
            
            // Open Razorpay modal
            console.log("Opening Razorpay modal...");
            rzp.open();
        });
    });

    // Debug: Check if event is being dispatched
    document.addEventListener('livewire:navigated', () => {
        console.log("Livewire navigated - reinitializing listeners");
    });
</script>

<!-- Button click debug -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payBtn = document.getElementById('online-pay-btn');
        if (payBtn) {
            payBtn.addEventListener('click', function() {
                console.log("🔘 Pay Online button clicked at:", new Date().toLocaleTimeString());
            });
        }
        
        // Check for line 977 error
        // Add this to find which script is causing error
        const scripts = document.getElementsByTagName('script');
        scripts.forEach((script, index) => {
            if (script.innerHTML.includes('classList')) {
                console.log("⚠️ Script with classList found at index:", index);
            }
        });
    });
</script>
@endpush
</div>