<div>
   
  <section id="heroCarousel"
         class="carousel slide hero-section hero-slider"
         data-bs-ride="carousel"
         data-bs-interval="5000">

    @foreach($sliders as $key => $slider)
   
        <div class="hero-slide {{ $key == 0 ? 'active' : '' }}"
             style="background-image:url({{ uploaded_asset($slider->images) }})">

            <div class="hero-overlay"></div>

            <div class="hero-content">

                @if($slider->title)
                    <h1 class="hero-title">{{ $slider->title }}</h1>
                @endif

            </div>
        </div>
    @endforeach

</section>

<!-- About Us / Philosophy - Pure E-commerce -->
<section class="content-section philosophy-section" id="philosophy">
    <div class="section-header">
        <h2 class="section-title">Who We Are</h2>
        <div class="section-divider"></div>
    </div>

    <div class="philosophy-wrapper">
        <div class="philosophy-content">
            <div class="philosophy-list">
                {!! get_setting('about_description') !!}
            </div>
        </div>

        <div class="philosophy-image">
            <img src="{{ uploaded_asset(get_setting('about_image')) }}" alt="About Our Store">
        </div>
    </div>
</section>

<!-- Products Section - Trending Products -->
<section class="content-section" id="products">
    <div class="section-header">
        <h2 class="section-title">Trending Now 🔥</h2>
        <div class="section-divider"></div>
        <p class="section-description">
            Most loved products by our customers this month
        </p>
    </div>
    
    <div class="container">
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <a wire:navigate href="{{ route('site.product', $product->slug) }}" class="text-decoration-none text-dark">
                        @if($product->primary_image)
                            <img src="{{ uploaded_asset($product->primary_image) }}" 
                                 class="product-img" 
                                 alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/default-product.png') }}" 
                                 class="product-img" 
                                 alt="{{ $product->name }}">
                        @endif

                        <h3 class="product-title">{{ $product->name }}</h3>
                    </a>
                    
                    @if($product->short_description)
                        <p class="product-desc">{{ Str::limit(strip_tags($product->short_description), 20) }}</p>
                    @else
                        <p class="product-desc">{{ Str::limit(strip_tags($product->description), 10) }}</p>
                    @endif

                    <div class="product-footer">
                        <span class="product-price">
                            @if($product->discount_price && $product->discount_price < $product->price)
                                <span class="original-price text-muted text-decoration-line-through me-2">
                                    ₹{{ number_format($product->price, 0) }}
                                </span>
                                <span class="discounted-price text-danger">
                                    ₹{{ number_format($product->discount_price, 0) }}
                                </span>
                            @else
                                <span class="price">₹{{ number_format($product->price, 0) }}</span>
                            @endif
                        </span>
                        
                        <div class="product-actions">
                            @if($product->stock_qty <= 0)
                                <span class="badge-outofstock">Out of Stock</span>
                            @else
                                <button class="btn-buy" 
                                        wire:click.stop="addToCart({{ $product->id }})"
                                        {{ $product->stock_qty <= 0 ? 'disabled' : '' }}
                                        title="Add to Cart">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <div class="product-badges">
                        @if($product->badge)
                            <span class="product-badge-index badge-featured">{{ $product->badge }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4>No Products Yet</h4>
                        <p class="text-muted">We're adding new products soon — stay tuned!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Values - What We Stand For (E-commerce) -->
<section class="content-section" id="values">
    <div class="section-header">
        <h2 class="section-title">Why Shop With Us</h2>
        <div class="section-divider"></div>
        <p class="section-description">
            Three simple promises we keep, every single day
        </p>
    </div>
    
    <div class="values-grid">
        <div class="value-card">
            <div class="value-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="value-title">100% Genuine Products</h3>
            <p class="value-description">
                We source directly from brands and authorised distributors. No duplicates, no lookalikes — only the real deal.
            </p>
        </div>
        
        <div class="value-card">
            <div class="value-icon">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <h3 class="value-title">Fair Prices, Always</h3>
            <p class="value-description">
                No MRP games. No fake discounts. Our pricing is honest, transparent, and often the best you'll find.
            </p>
        </div>
        
        <div class="value-card">
            <div class="value-icon">
                <i class="fas fa-box"></i>
            </div>
            <h3 class="value-title">Packaging That Cares</h3>
            <p class="value-description">
                Every order is packed with care — secure, damage-proof, and ready to unbox. Because presentation matters.
            </p>
        </div>
    </div>
</section>

<!-- Services - What We Offer -->
<section class="content-section services-section" id="services">
    <div class="section-header">
        <h2 class="section-title">Your Shopping Experience</h2>
        <div class="section-divider"></div>
        <p class="section-description">
            We've designed every step to be smooth, simple, and stress-free
        </p>
    </div>
    
    <div class="services-grid">
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <h3 class="service-title">Lightning Fast Delivery</h3>
            <p class="service-description">
                Most orders ship within 24 hours. Partnering with top courier services to get your order to you — fast.
            </p>
        </div>
        
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <h3 class="service-title">Easy Returns & Exchanges</h3>
            <p class="service-description">
                Size not right? Changed your mind? We offer simple, no-questions-asked returns within 7 days.
            </p>
        </div>
        
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-clock"></i>
            </div>
            <h3 class="service-title">7-Day Support</h3>
            <p class="service-description">
                Need help? Our team is available 7 days a week. Real humans, real replies — no bots, no auto-replies.
            </p>
        </div>
        
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h3 class="service-title">Secure Checkout</h3>
            <p class="service-description">
                100% secure payments. Your data is encrypted and never shared. Shop with complete peace of mind.
            </p>
        </div>
    </div>
</section>

<!-- Trust Section -->
<section class="content-section trust-section" id="trust">
    <div class="section-header">
        <h2 class="section-title">Trusted by Thousands</h2>
        <div class="section-divider"></div>
        <p class="section-description">
            Here's why customers keep coming back
        </p>
    </div>
    
    <div class="trust-content">
        <div class="trust-badge">
            <i class="fas fa-handshake"></i>
            <h3>Our Promise to You</h3>
            <p>Every product you see is something we'd buy ourselves</p>
        </div>
        
        <ul class="trust-list">
            <li><i class="fas fa-check"></i> Authentic products with original packaging</li>
            <li><i class="fas fa-check"></i> No hidden charges — what you see is what you pay</li>
            <li><i class="fas fa-check"></i> Order tracking from warehouse to your door</li>
            <li><i class="fas fa-check"></i> Replacement guaranteed if damaged in transit</li>
            <li><i class="fas fa-check"></i> No spam emails or SMS — ever</li>
            <li><i class="fas fa-check"></i> Loyalty rewards for regular customers</li>
        </ul>
    </div>
</section>

<!-- Message Section - Brand Voice -->
<section class="message-section">
    <div class="message-content">
        <div class="message-quote">
            "We're not just selling products. We're building a place you can trust — where quality meets honesty, and every customer is treated like family."
        </div>
    </div>
</section>

<!-- Vision Section - Pure E-commerce -->
<section class="content-section vision-section">
    <div class="section-header">
        <h2 class="section-title">Our Vision</h2>
        <div class="section-divider"></div>
    </div>
    
    <div class="vision-content">
        <p class="vision-text">
            To become India's most trusted online destination for quality products — known not for loud discounts, but for consistent reliability.
        </p>
        
        <p class="vision-text">
            We're building a store where you never have to second-guess. Genuine products. Fair prices. Support that actually helps. Simple.
        </p>
        
        <p class="vision-text">
            No gimmicks. No pressure. Just a clean, honest shopping experience — the way it should be.
        </p>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-content">
        <h2 class="cta-title">Ready to Shop With Confidence?</h2>
        <p class="cta-description">
            Browse our collections — from everyday essentials to special finds. All genuine. All fairly priced.
        </p>
        <div class="cta-buttons">
            <button class="btn-cta-primary">Shop Now</button>
            <button class="btn-cta-secondary">Explore Collections</button>
        </div>
    </div>
</section>

<style>
    .product-badge-index {
        position: absolute;
        top: 4px;
        right: 2px;
        border-radius: 4px;
        padding: 2px 8px;
        background: var(--primary-blue);
        color: var(--white);
        font-size: 0.7rem;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .product-card {
        overflow: hidden;
        position: relative;
    }
    .hero-slide {
        transition: opacity 1.2s ease;
    }
</style>
        
</div>