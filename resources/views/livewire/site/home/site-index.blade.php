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

                

                <!-- <div class="hero-divider"></div> -->

                

            </div>
        </div>
    @endforeach

</section>

<section class="content-section philosophy-section" id="philosophy">
    <div class="section-header">
        <h2 class="section-title">About Us</h2>
        <div class="section-divider"></div>
        
    </div>

    <div class="philosophy-wrapper">
        <!-- LEFT: TEXT -->
        <div class="philosophy-content">
            <!-- <p class="philosophy-text">
                Health problems do not start suddenly. They develop slowly, silently, at the level of metabolism.
            </p> -->

            <div class="philosophy-list">
              {!! get_setting('about_description') !!}
            </div>
<!-- 
            <p class="philosophy-text">
                We focus on correcting the root cause, not chasing symptoms. Our approach is built on understanding
                the underlying metabolic processes that drive health and disease.
            </p> -->
        </div>

        <!-- RIGHT: IMAGE -->
        <div class="philosophy-image">
            <img src="{{ uploaded_asset(get_setting('about_image'))}}" alt="Metabolic Health Concept">
        </div>
    </div>
</section>

    
<section class="content-section" id="products">
    <div class="section-header">
        <h2 class="section-title">Trending health needs</h2>
        <div class="section-divider"></div>
        <p class="section-description">
            Evidence-based nutritional support. No hype. No shortcuts.
        </p>
    </div>
<div class="container">

    <div class="products-grid">
    @forelse($products as $product)
        <!-- PRODUCT -->
        
        <div class="product-card">
            <a wire:navigate href="{{ route('site.product', $product->slug) }}" class="text-decoration-none text-dark">
            <!-- Product Image -->
            @if($product->primary_image)
                <img src="{{ uploaded_asset($product->primary_image) }}" 
                     class="product-img" 
                     alt="{{ $product->name }}">
            @elseif($product->primary_image)
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
            
            <!-- Short Description -->
            @if($product->short_description)
                <p class="product-desc">{{ Str::limit(strip_tags($product->short_description),20) }}</p>
            @else
                <p class="product-desc">{{ Str::limit(strip_tags($product->description), 10) }}</p>
            @endif

            <div class="product-footer">
                <!-- Price -->
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
                    <!-- Add to Cart Button -->
                     @if($product->stock_qty <= 0)
                    <span class=" badge-outofstock">Out of Stock</span>
                @else
                    <!-- <span class=" badge-lowstock">Low Stock</span> -->
                    <button class="btn-buy" 
                            wire:click.stop="addToCart({{ $product->id }})"
        {{ $product->stock_qty <= 0 ? 'disabled' : '' }}
                            title="Add to Cart">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                @endif
                    
                    <!-- Buy Now Button -->
                    <button class="btn-buy d-none" 
                            wire:click="buyNow({{ $product->id }})">
                        Buy
                    </button>
                </div>
            </div>
            
            <!-- Badges for special products -->
            <div class="product-badges">
                @if($product->badge)
                    <span class="product-badge-index badge-featured">{{ $product->badge }}</span>
                @endif
                
                {{--@if($product->discount_price && $product->discount_price < $product->price)
                    @php
                        $discountPercentage = round((($product->price - $product->discount_price) / $product->price) * 100);
                    @endphp
                    <span class="product-badge-index badge-discount">{{ $discountPercentage }}% OFF</span>
                @endif--}}
                
                
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-12 text-center py-5">
            <div class="empty-state">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4>No Products Available</h4>
                <p class="text-muted">Check back soon for new products!</p>
            </div>
        </div>
    @endforelse
</div>
    </div>
</section>
    <section class="content-section" id="values">
        <div class="section-header">
            <h2 class="section-title">What We Stand For</h2>
            <div class="section-divider"></div>
            <p class="section-description">
                Our core principles that guide every aspect of our work
            </p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <h3 class="value-title">Science-First Approach</h3>
                <p class="value-description">
                    Every concept, explanation, and formulation is based on established physiology 
                    and clinical reasoning, not trends or hype. We rely on evidence-based medicine 
                    and peer-reviewed research.
                </p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="value-title">Education Before Medication</h3>
                <p class="value-description">
                    We believe knowledge is the most powerful treatment. When people understand why 
                    something is happening in their body, they make better, sustainable choices for 
                    long-term health.
                </p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3 class="value-title">Lifestyle-Centric Health</h3>
                <p class="value-description">
                    No supplement can replace: correct nutrition, physical activity, quality sleep, 
                    and stress management. Our guidance always starts with lifestyle foundations.
                </p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="value-title">Clean & Transparent Formulations</h3>
                <p class="value-description">
                    When supplements are used, they are: supportive (not curative), clearly labelled, 
                    free from exaggerated claims, and designed for long-term safety and effectiveness.
                </p>
            </div>
        </div>
    </section>

     <section class="content-section services-section" id="services">
        <div class="section-header">
            <h2 class="section-title">What We Do</h2>
            <div class="section-divider"></div>
            <p class="section-description">
                Comprehensive health education and support for sustainable wellness
            </p>
        </div>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3 class="service-title">Health Education</h3>
                <p class="service-description">
                    We simplify complex medical topics into clear, practical language for everyday people:
                </p>
                <ul class="service-list">
                    <li><i class="fas fa-check"></i> Insulin resistance</li>
                    <li><i class="fas fa-check"></i> Blood sugar control</li>
                    <li><i class="fas fa-check"></i> Post-meal glucose spikes</li>
                    <li><i class="fas fa-check"></i> Metabolic flexibility</li>
                    <li><i class="fas fa-check"></i> Mineral and micronutrient balance</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-video"></i>
                </div>
                <h3 class="service-title">Digital Content & Public Awareness</h3>
                <p class="service-description">
                    Through videos, articles, and guides, we aim to correct common myths and misinformation 
                    surrounding diabetes, nutrition, and supplements. We provide evidence-based information 
                    that empowers informed decisions.
                </p>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-capsules"></i>
                </div>
                <h3 class="service-title">Nutritional Support (When Needed)</h3>
                <p class="service-description">
                    Our products are designed only as support tools, not replacements for lifestyle change. 
                    We never promote dependency. Our goal is self-sufficiency in health through understanding 
                    and proper lifestyle implementation.
                </p>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="content-section trust-section" id="trust">
        <div class="section-header">
            <h2 class="section-title">Why People Trust Us</h2>
            <div class="section-divider"></div>
            <p class="section-description">
                Building trust through transparency and honest communication
            </p>
        </div>
        
        <div class="trust-content">
            <p class="section-description">
                We believe trust is built when truth is spoken simply. Our commitment to honest health 
                education sets us apart in an industry filled with exaggerated claims and quick fixes.
            </p>
            
            <div class="trust-badge">
                <i class="fas fa-handshake"></i>
                <h3>Our Promise of Integrity</h3>
                <p>We maintain the highest standards of honesty in all our communications</p>
            </div>
            
            <ul class="trust-list">
                <li><i class="fas fa-check"></i> Medical clarity without fear-mongering</li>
                <li><i class="fas fa-check"></i> No miracle claims or exaggerated promises</li>
                <li><i class="fas fa-check"></i> No unnecessary supplements promoted</li>
                <li><i class="fas fa-check"></i> Honest discussion of limitations and challenges</li>
                <li><i class="fas fa-check"></i> Long-term health perspective over quick fixes</li>
                <li><i class="fas fa-check"></i> Evidence-based recommendations only</li>
            </ul>
        </div>
    </section>

    <!-- Message Section -->
    <section class="message-section">
        <div class="message-content">
            <div class="message-quote">
                "You don't need to consume more products to become healthy. You need to understand your body better. Once you do that, health becomes predictable."
            </div>
            <!-- <div class="message-author">— A Message from Dr. Aulakh</div> -->
        </div>
    </section>

    <!-- Vision Section -->
    <section class="content-section vision-section">
        <div class="section-header">
            <h2 class="section-title">Our Vision</h2>
            <div class="section-divider"></div>
        </div>
        
        <div class="vision-content">
            <p class="vision-text">
                To create a platform where health education is simple, supplements are ethical, 
                lifestyle change is prioritised, and people regain control over their health.
            </p>
            
            <p class="vision-text">
                Not through shortcuts — but through understanding. We envision a world where individuals 
                are empowered with knowledge about their own bodies, making informed decisions that lead 
                to sustainable health improvements.
            </p>
            
            <p class="vision-text">
                Our mission is to bridge the gap between complex medical science and practical everyday 
                application, making health education accessible, understandable, and actionable for everyone.
            </p>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Start Your Journey Toward Better Metabolic Health</h2>
            <p class="cta-description">
                Explore our educational resources, research-based insights, and carefully designed 
                health support solutions — all built with honesty at the core.
            </p>
            <div class="cta-buttons">
                <button class="btn-cta-primary">Explore Educational Resources</button>
                <button class="btn-cta-secondary">Learn About Our Approach</button>
            </div>
        </div>
    </section>
    <style>
        .product-badge-index {
               position: absolute;
    top: 4px;
    right: 2px;
    border-radius: 4px;
    padding: 2px;
    background: var(--primary-blue);
    color: var(--white);
    font-size: 0.7rem;
    min-width: 18px;
    height: 18px;
    /* border-radius: 50%; */
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
        }
        .product-card{
            overflow: hidden;
    position: relative;
        }
        .hero-slide {
    transition: opacity 1.2s ease;
}

        </style>
        
</div>
