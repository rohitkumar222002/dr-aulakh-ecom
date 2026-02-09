<div>
   <div>

    <!-- Overlay -->
    <div 
        class="cart-overlay {{ $open ? 'visible' : '' }}" 
        wire:click="toggle">
    </div>

    <!-- Drawer -->
    <div class="mini-cart {{ $open ? 'open' : '' }}">

        <div class="mini-cart-header">
            <h2>Your Cart</h2>
            <button class="close-btn" wire:click="toggle">×</button>
        </div>

        <div class="cart-items-list">
            @forelse($items as $item)
                <div class="cart-item">
                    <img src="{{ uploaded_asset($item->product->primary_image) }}" class="ci-img">

                    <div class="ci-info">
                        <h4>{{ $item->product->name }}</h4>

                        <div class="ci-price">₹{{ number_format($item->price_at_that_time) }}</div>

                        <div class="ci-qty">
    <button 
        wire:click="decrementQty({{ $item->id }})"
        @if($item->quantity <= 1) disabled @endif
    >–</button>

    <span>{{ $item->quantity }}</span>

    <button 
        wire:click="incrementQty({{ $item->id }})"
        @if($item->quantity >= $item->product->stock_qty) disabled @endif
    >+</button>
</div>

                    </div>

                    <button class="ci-remove" wire:click="remove({{ $item->id }})">×</button>
                </div>
            @empty
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Your cart is empty</p>
                </div>
            @endforelse
        </div>

        @if(count($items))
            <div class="mini-cart-footer">

                <div class="subtotal-row">
                    <span>Subtotal:</span>
                    <strong>₹{{ number_format($items->sum(fn($i) => $i->price_at_that_time * $i->quantity)) }}</strong>
                </div>
                <div class="row">
                    <div class="col-md-12">
<a wire:navigate href="{{ route('cart') }}" class="btn-signin extra-display-button w-100">
    Cart
</a>
</div>
                    <div class="col-md-12">

<a  href="{{route('checkout')}}" class="btn-buy-now extra-display-button w-100">
    Proceed to Checkout
</a>
             

</div>
</div>
             

            </div>
        @endif

    </div>

</div>


<style>
/* Overlay */
.ci-qty button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.cart-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease;
    z-index: 9998;
}
.cart-overlay.visible {
    opacity: 1;
    pointer-events: auto;
}

/* Drawer Panel */
.mini-cart {
    position: fixed;
    top: 0;
    right: -380px;
    width: 360px;
    height: 100%;
    background: #fff;
    z-index: 9999;
    box-shadow: -2px 0 20px rgba(0,0,0,0.15);
    transition: right .3s ease;
    display: flex;
    flex-direction: column;
}
.mini-cart.open { right: 0; }

/* Header */
.mini-cart-header {
    padding: 15px 18px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.mini-cart-header h2 {
    font-size: 18px;
    margin: 0;
}
.close-btn {
    font-size: 26px;
    background: none;
    border: none;
    cursor: pointer;
}

/* Cart Items List */
.cart-items-list {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
}
.cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f3f3f3;
}
.ci-img {
    width: 65px;
    height: 65px;
    border-radius: 8px;
    object-fit: cover;
    margin-right: 12px;
}
.ci-info h4 {
    font-size: 14px;
    margin: 0;
    font-weight: 600;
}
.ci-price {
    font-size: 15px;
    margin: 4px 0;
    color: #333;
    font-weight: 600;
}
.ci-qty {
    background: #f4f4f4;
    padding: 4px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
}
.ci-qty button {
    background: none;
    border: none;
    font-size: 16px;
    width: 24px;
    cursor: pointer;
}
.ci-qty span {
    margin: 0 8px;
}

/* Remove */
.ci-remove {
    background: none;
    border: none;
    font-size: 20px;
    color: #ff4b4b;
    margin-left: auto;
    cursor: pointer;
}

/* Empty cart */
.empty-cart {
    text-align: center;
    padding: 40px;
    color: #777;
}
.empty-cart i {
    font-size: 40px;
    margin-bottom: 10px;
}

/* Footer */
.mini-cart-footer {
    padding: 15px;
    border-top: 1px solid #eee;
}
.subtotal-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 16px;
}
.btn-buy-now {
    width: 100%;
    background: #28a745;
    color: white;
    margin-top: 10px;
   border: none;
    padding: 10px 24px;
    cursor: pointer;
    padding: 7px 16px;
    font-size: 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    white-space: nowrap;
    transition: background 0.3s ease, transform 0.2s ease;
}
.btn-view-cart {
    width: 100%;
    background: #222;
    border: none;
    color: white;
    padding: 10px;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
}
</style>

</div>
