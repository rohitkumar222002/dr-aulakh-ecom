<div>
    <!-- Delete Confirmation Modal -->
    @if($showDeleteConfirm)
    <div class="modal-overlay" wire:click="$set('showDeleteConfirm', false)">
        <div class="modal-content" wire:click.stop>
            <div class="modal-header">
                <h3>Remove Item</h3>
                <button wire:click="$set('showDeleteConfirm', false)" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this item from your cart?</p>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showDeleteConfirm', false)" class="btn-secondary">Cancel</button>
                <button wire:click="remove" class="btn-danger">Remove</button>
            </div>
        </div>
    </div>
    @endif

    <div class="cart-page">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-shopping-cart"></i>
                    Shopping Cart
                </h1>
                <div class="cart-stats">
                    <span class="stat-item">
                        <i class="fas fa-box"></i>
                        {{ $totalItems }} items
                    </span>
                </div>
            </div>

            @if(count($items) == 0)
                <!-- Empty Cart State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <h2>Your cart is empty</h2>
                    <p class="empty-state-text">
                        Looks like you haven't added any items to your cart yet.
                    </p>
                    <a href="{{ route('site.products') }}" class="btn-primary">
                        <i class="fas fa-store"></i>
                        Continue Shopping
                    </a>
                </div>
            @else
                <div class="cart-layout">
                    <!-- Main Cart Items -->
                    <div class="cart-main">
                        <!-- Cart Header -->
                        <div class="cart-header">
                            <h2 class="cart-section-title">Cart Items</h2>
                            <button wire:click="clearCart" class="btn-clear-cart">
                                <i class="fas fa-trash"></i>
                                Clear Cart
                            </button>
                        </div>

                        <!-- Cart Items List -->
                        <div class="cart-items-list">
                            @foreach($items as $item)
                            <div class="cart-item-card">
                                <!-- Product Image -->
                                <div class="cart-item-image">
                                    <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                         alt="{{ $item->product->name }}">
                                    @if($item->product->price > $item->price_at_that_time)
                                        <span class="discount-badge">
                                            {{ round((($item->product->price - $item->price_at_that_time) / $item->product->price) * 100) }}% OFF
                                        </span>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="cart-item-details">
                                    <div class="cart-item-header">
                                        <h3 class="product-name">{{ $item->product->name }}</h3>
                                        <div class="stock-status">
                                            @if($item->product->stock_qty > 0)
                                                <span class="in-stock">
                                                    <i class="fas fa-check-circle"></i>
                                                    In Stock
                                                </span>
                                            @else
                                                <span class="out-of-stock">
                                                    <i class="fas fa-times-circle"></i>
                                                    Out of Stock
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Price Information -->
                                    <div class="price-info">
                                        <div class="current-price">
                                            ₹{{ number_format($item->price_at_that_time) }}
                                            @if($item->product->price > $item->price_at_that_time)
                                                <span class="original-price">
                                                    ₹{{ number_format($item->product->price) }}
                                                </span>
                                                <span class="price-savings">
                                                    Save ₹{{ number_format($item->product->price - $item->price_at_that_time) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="quantity-section">
                                        <div class="quantity-controls">
                                            <button 
                                                wire:click="decrementQty({{ $item->id }})" 
                                                class="qty-btn minus"
                                                @if($item->quantity <= 1) disabled @endif>
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="quantity-display">{{ $item->quantity }}</span>
                                            <button 
                                                wire:click="incrementQty({{ $item->id }})" 
                                                class="qty-btn plus"
                                                @if($item->quantity >= $item->product->stock_qty) disabled @endif>
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="stock-info">
                                            Max {{ $item->product->stock_qty }} available
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="item-actions">
                                        <button 
                                            wire:click="confirmRemove({{ $item->id }})" 
                                            class="btn-remove">
                                            <i class="fas fa-trash"></i>
                                            Remove
                                        </button>
                                        <!-- <button class="btn-wishlist">
                                            <i class="fas fa-heart"></i>
                                            Save for later
                                        </button> -->
                                    </div>
                                </div>

                                <!-- Item Total -->
                                <div class="cart-item-total">
                                    <div class="total-label">Total</div>
                                    <div class="total-amount">
                                        ₹{{ number_format($item->price_at_that_time * $item->quantity) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="cart-sidebar">
                        <div class="order-summary-card">
                            <h3 class="summary-title">
                                <i class="fas fa-receipt"></i>
                                Order Summary
                            </h3>

                            <div class="summary-details">
                                <div class="summary-row">
                                    <span>Subtotal ({{ $totalItems }} items)</span>
                                    <span>₹{{ number_format($totalAmount) }}</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span>Shipping</span>
                                    <span class="free-shipping">
                                        <i class="fas fa-shipping-fast"></i>
                                        FREE
                                    </span>
                                </div>

                                <div class="summary-row">
                                    <span>Tax (GST)</span>
                                    <span>₹{{ number_format($totalAmount * 0.18) }}</span>
                                </div>

                                <div class="summary-row total">
                                    <span>Total Amount</span>
                                    <span class="grand-total">
                                        ₹{{ number_format($totalAmount + ($totalAmount * 0.18)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Coupon Code -->
                            <div class="coupon-section d-none">
                                <div class="coupon-input-group">
                                    <input type="text" placeholder="Enter coupon code" class="coupon-input">
                                    <button class="btn-coupon">Apply</button>
                                </div>
                                <div class="available-coupons">
                                    <p class="coupon-label">Available Coupons:</p>
                                    <div class="coupon-tags">
                                        <span class="coupon-tag">SAVE10 - Get 10% off</span>
                                        <span class="coupon-tag">FREESHIP - Free shipping</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                          <!-- <button 
    onclick="window.location.href='{{ auth()->check() ? route('checkout') : route('login', ['redirect' => 'checkout']) }}'"
    class="btn-checkout"
>
    Proceed to Checkout
</button> -->
<!-- <a wire:navigate href="{{ auth()->check() ? route('checkout') : route('login', ['redirect' => 'checkout']) }}" class="btn-signin extra-display-button w-100">
    Proceed to Checkout
</a> -->
<a  href="{{ route('checkout') }}" class="btn-signin extra-display-button w-100">
    Proceed to Checkout
</a>


                            

                            <!-- Payment Methods -->
                            <div class="payment-methods">
                                <p class="payment-label">We accept:</p>
                                <div class="payment-icons">
                                    <i class="fab fa-cc-visa"></i>
                                    <i class="fab fa-cc-mastercard"></i>
                                    <i class="fab fa-cc-amex"></i>
                                    <i class="fab fa-cc-paypal"></i>
                                    <i class="fas fa-university"></i>
                                </div>
                            </div>

                            <!-- Security Info -->
                            <div class="security-info">
                                <div class="security-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Secure SSL Encryption</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-sync"></i>
                                    <span>Easy Returns</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

<style>
:root {
    --primary-color: #2563eb;
    --primary-dark: #1d4ed8;
    --secondary-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --bg-light: #f9fafb;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
}

.cart-page {
    min-height: calc(100vh - 200px);
    background: linear-gradient(135deg, #f6f9fc 0%, #ffffff 100%);
    padding: 2rem 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    animation: fadeIn 0.2s ease;
}

.modal-content {
    background: white;
    border-radius: var(--radius-lg);
    width: 90%;
    max-width: 400px;
    animation: slideUp 0.3s ease;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.modal-header h3 {
    margin: 0;
    color: var(--text-primary);
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-secondary);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
}

.cart-stats {
    display: flex;
    gap: 1.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

.empty-state-icon {
    font-size: 4rem;
    color: var(--border-color);
    margin-bottom: 1.5rem;
}

.empty-state h2 {
    font-size: 1.875rem;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
}

.empty-state-text {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1.125rem;
}

/* Cart Layout */
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
}

/* Cart Main */
.cart-main {
    background: white;
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--bg-light);
}

.cart-section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.btn-clear-cart {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--danger-color);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-clear-cart:hover {
    background: #dc2626;
}

/* Cart Item Card */
.cart-item-card {
    display: grid;
    grid-template-columns: 140px 1fr 120px;
    gap: 1.5rem;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s;
}

.cart-item-card:hover {
    background: var(--bg-light);
}

.cart-item-image {
    position: relative;
    width: 140px;
    height: 140px;
    border-radius: var(--radius-md);
    overflow: hidden;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.cart-item-image:hover img {
    transform: scale(1.05);
}

.discount-badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    background: var(--secondary-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 600;
}

/* Product Details */
.cart-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.product-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.4;
}

.stock-status {
    font-size: 0.875rem;
}

.in-stock {
    color: var(--secondary-color);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.out-of-stock {
    color: var(--danger-color);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Price Information */
.price-info {
    margin-bottom: 1rem;
}

.current-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.original-price {
    font-size: 1rem;
    color: var(--text-secondary);
    text-decoration: line-through;
}

.price-savings {
    font-size: 0.875rem;
    color: var(--secondary-color);
    background: #d1fae5;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-sm);
}

/* Quantity Controls */
.quantity-section {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.quantity-controls {
    display: flex;
    align-items: center;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.qty-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.qty-btn:hover:not(:disabled) {
    background: var(--bg-light);
}

.qty-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.quantity-display {
    width: 50px;
    text-align: center;
    font-weight: 600;
}

.stock-info {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

/* Item Actions */
.item-actions {
    display: flex;
    gap: 1rem;
}

.btn-remove, .btn-wishlist {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: 1px solid var(--border-color);
    background: white;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.btn-remove {
    color: var(--danger-color);
}

.btn-remove:hover {
    background: #fef2f2;
    border-color: var(--danger-color);
}

.btn-wishlist:hover {
    background: var(--bg-light);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

/* Item Total */
.cart-item-total {
    text-align: right;
}

.total-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

/* Order Summary */
.cart-sidebar {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.order-summary-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow-lg);
}

.summary-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--bg-light);
}

.summary-details {
    margin-bottom: 1.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    color: var(--text-primary);
}

.summary-row.total {
    border-top: 2px solid var(--border-color);
    margin-top: 0.5rem;
    padding-top: 1rem;
    font-weight: 700;
}

.free-shipping {
    color: var(--secondary-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
}

.grand-total {
    font-size: 1.5rem;
    color: var(--primary-color);
}

/* Coupon Section */
.coupon-section {
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: var(--radius-md);
}

.coupon-input-group {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.coupon-input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
}

.btn-coupon {
    padding: 0.75rem 1.5rem;
    background: var(--text-secondary);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    font-weight: 600;
    transition: background 0.2s;
}

.btn-coupon:hover {
    background: var(--text-primary);
}

.available-coupons {
    font-size: 0.875rem;
}

.coupon-label {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.coupon-tags {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.coupon-tag {
    padding: 0.375rem 0.75rem;
    background: white;
    border: 1px dashed var(--secondary-color);
    border-radius: var(--radius-sm);
    color: var(--secondary-color);
    font-size: 0.75rem;
}

/* Checkout Button */
.btn-checkout {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 1.125rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    transition: all 0.3s;
    margin-bottom: 1.5rem;
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.checkout-arrow {
    margin-left: auto;
    font-size: 1.25rem;
}

/* Payment Methods */
.payment-methods {
    padding: 1rem;
    background: var(--bg-light);
    border-radius: var(--radius-md);
    margin-bottom: 1rem;
}

.payment-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.payment-icons {
    display: flex;
    gap: 1rem;
    font-size: 1.5rem;
    color: var(--text-secondary);
}

/* Security Info */
.security-info {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.security-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Buttons */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-secondary {
    padding: 0.5rem 1.5rem;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: var(--bg-light);
}

.btn-danger {
    padding: 0.5rem 1.5rem;
    background: var(--danger-color);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-danger:hover {
    background: #dc2626;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .cart-layout {
        grid-template-columns: 1fr;
    }
    
    .cart-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-item-card {
        grid-template-columns: 100px 1fr;
        grid-template-rows: auto auto;
    }
    
    .cart-item-total {
        grid-column: 1 / -1;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}

@media (max-width: 640px) {
    .container {
        padding: 0 1rem;
    }
    
    .cart-item-card {
        padding: 1rem;
        gap: 1rem;
    }
    
    .item-actions {
        flex-direction: column;
    }
    
    .btn-remove, .btn-wishlist {
        justify-content: center;
    }
}
</style>
</div>
