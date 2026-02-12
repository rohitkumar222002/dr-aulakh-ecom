<div>
     @section('meta_title'){{ $product->meta_title ?? $product->product_name }} @stop
    @section('meta_keywords') {{ $product->meta_title ?? $product->product_name }} @stop
    @section('meta_description') {{ $product->meta_title ?? $product->product_name }} @stop
    @section('meta_image'){{ uploaded_asset($product->image) }}@stop
    <link rel="stylesheet" href="{{ asset('site/product.css') }}">
    <!-- Breadcrumb -->
    <div class="breadcrumb-wrap">
        <div class="products-page-container">
            <nav class="breadcrumb">
                <a href="{{ route('site.products') }}">
                    <i class="fas fa-house"></i> Products
                </a>
                <span class="divider">›</span>
                <span class="active">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Detail Container -->
    <div class="product-detail-container">
        <!-- LEFT: Images -->
        <div class="product-gallery">
            <!-- Main Image -->
          
    {{-- MAIN IMAGE --}}
    @php
        $imageIds = $product->images ? explode(',', $product->images) : [];
    @endphp

    @if($selectedImage)
        <img src="{{ uploaded_asset($selectedImage) }}" 
             class="main-image" 
             alt="{{ $product->name }}">
    @elseif($product->primary_image)
        <img src="{{ uploaded_asset($product->primary_image) }}" 
             class="main-image" 
             alt="{{ $product->name }}">
    @elseif(!empty($imageIds))
        <img src="{{ uploaded_asset(trim($imageIds[0])) }}" 
             class="main-image" 
             alt="{{ $product->name }}">
    @else
        <img src="{{ asset('images/default-product.png') }}" 
             class="main-image" 
             alt="{{ $product->name }}">
    @endif

            <!-- Thumbnail Images -->
            <div class="thumbs">
                <!-- Primary Image -->
                @if($product->primary_image)
                    <img src="{{ uploaded_asset($product->primary_image) }}" 
                         class="thumb {{ $selectedImage == $product->primary_image ? 'active' : '' }}"
                         wire:click="selectImage('{{ $product->primary_image }}')"
                         alt="Thumbnail">
                @endif
                
                <!-- Other Images -->
              @if($product->images)
    @php
        $imageIds = explode(',', $product->images);
    @endphp

    @foreach($imageIds as $imageId)
        <img src="{{ uploaded_asset(trim($imageId)) }}" 
             class="thumb {{ $selectedImage == trim($imageId) ? 'active' : '' }}"
             wire:click="selectImage('{{ trim($imageId) }}')"
             alt="Thumbnail">
    @endforeach
@endif

            </div>
        </div>

        <!-- RIGHT: Info -->
        <div class="product-detail-info">
            <!-- Badge -->
            @if($product->badge)
                <span class="pd-badge">{{ $product->badge }}</span>
            @endif

            <!-- Title -->
            <h1 class="pd-title">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="d-none pd-rating">
                @if($product->rating_avg > 0)
                    @php
                        $fullStars = floor($product->rating_avg);
                        $hasHalfStar = ($product->rating_avg - $fullStars) >= 0.5;
                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                    @endphp
                    
                    @for($i = 0; $i < $fullStars; $i++)
                        ★
                    @endfor
                    
                    @if($hasHalfStar)
                        ☆
                    @endif
                    
                    @for($i = 0; $i < $emptyStars; $i++)
                        ☆
                    @endfor
                    
                    <span>({{ $product->rating_count }} reviews)</span>
                @else
                    ☆☆☆☆☆ <span>(No reviews yet)</span>
                @endif
            </div>

            <!-- Price -->
            <div class="pd-price">
                @if($product->discount_price && $product->discount_price < $product->price)
                    ₹{{ number_format($product->discount_price, 2) }}
                    <span class="old">₹{{ number_format($product->price, 2) }}</span>
                @else
                    ₹{{ number_format($product->price, 2) }}
                    @if($product->mrp && $product->mrp > $product->price)
                        <span class="old">₹{{ number_format($product->mrp, 2) }}</span>
                    @endif
                @endif
            </div>

            <!-- Short Description -->
            <p class="pd-short-desc">
                {{ $product->short_description ?: 'No description available.' }}
            </p>

            <!-- Actions -->
            <div class="pd-actions">
                <button class="btn-buy" 
                wire:click.stop="addToCart({{ $product->id }})"
        {{ $product->stock_qty <= 0 ? 'disabled' : '' }}>
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
                <button class="btn-wishlist" wire:click="addToWishlist">
                    <i class="far fa-heart"></i>
                </button>
            </div>

            <!-- Highlights -->
            <ul class="pd-highlights">
                
            </ul>
        </div>
    </div>
               
     @php
    function youtubeEmbedUrl($url) {
        // Handle Shorts URL
        if (str_contains($url, 'youtube.com/shorts/')) {
            $videoId = basename(parse_url($url, PHP_URL_PATH));
            return $videoId ? 'https://www.youtube.com/embed/' . $videoId : null;
        }

        // Handle normal YouTube URLs
        preg_match(
            '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $url,
            $matches
        );

        return $matches[1] ?? null
            ? 'https://www.youtube.com/embed/' . $matches[1]
            : null;
    }
    $embedUrl = youtubeEmbedUrl($product->youtube_link);
@endphp

@if ($embedUrl)
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <iframe width="100%" height="315"
                src="{{ $embedUrl }}"
                title="YouTube video player"
                frameborder="0"
                allowfullscreen>
            </iframe>
        </div>
    </div>
</div>
@endif

    <!-- Latest Products Section -->
    <section class="latest-products">
        <h2 class="section-title">Latest Products</h2>

        <div class="latest-grid">
            @foreach($latestProducts as $latestProduct)
                <div class="latest-card">
                    <!-- Product Image -->
                    @if($latestProduct->primary_image)
                        <img src="{{ uploaded_asset($latestProduct->primary_image) }}" 
                             alt="{{ $latestProduct->name }}">
                    @elseif($latestProduct->images && $latestProduct->images->count() > 0)
                        <img src="{{ uploaded_asset($latestProduct->images->first()->image) }}" 
                             alt="{{ $latestProduct->name }}">
                    @else
                        <img src="{{ asset('images/default-product.png') }}" 
                             alt="{{ $latestProduct->name }}">
                    @endif

                    <h4>{{ $latestProduct->name }}</h4>
                    
                    <!-- Price -->
                    <span class="price">
                        @if($latestProduct->discount_price && $latestProduct->discount_price < $latestProduct->price)
                            ₹{{ number_format($latestProduct->discount_price, 2) }}
                        @else
                            ₹{{ number_format($latestProduct->price, 2) }}
                        @endif
                    </span>

                    <div class="latest-actions">
                        <a wire:navigate href="{{ route('site.product', $latestProduct->slug) }}" 
                           class="btn-view">
                            <i class="far fa-eye"></i> View
                        </a>
                        <button class="btn-cart"    wire:click.stop="addToCart({{ $product->id }})"
        {{ $product->stock_qty <= 0 ? 'disabled' : '' }} 
                              >
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
   <style>
    /* ===== MOBILE FIRST - SEXY DESIGN ===== */
    @media screen and (max-width: 768px) {
        /* Reset */
        .product-detail-container,
        .latest-grid,
        .pd-actions {
            all: revert;
        }

        /* === PRODUCT PAGE - CLEAN LAYOUT === */
        .product-detail-container {
            display: flex;
            flex-direction: column;
            padding: 12px;
            background: #fff;
        }

        /* === IMAGE SECTION - BOLD === */
        .product-gallery {
            width: 100%;
            background: #fafafa;
            border-radius: 20px;
            padding: 20px;
        }

        .main-image {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: contain;
            mix-blend-mode: multiply;
        }

        /* Thumbs - Minimal */
        .thumbs {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            overflow-x: auto;
            padding-bottom: 5px;
            -webkit-overflow-scrolling: touch;
        }

        .thumb {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid transparent;
            opacity: 0.7;
            transition: 0.2s;
        }

        .thumb.active {
            border-color: {{ get_setting('site_color') }} ;
            opacity: 1;
        }

        /* === INFO SECTION - CRISP === */
        .product-detail-info {
            padding: 20px 0 0;
        }

        .pd-badge {
            background: {{ get_setting('site_color') }} ;
            color: white;
            padding: 4px 12px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }

        .pd-title {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.2;
            margin: 0 0 8px;
            color: #1a1a1a;
        }

        /* Rating - Clean */
        .pd-rating {
            color: #ffb800;
            font-size: 16px;
            margin-bottom: 12px;
        }

        .pd-rating span {
            color: #666;
            font-size: 14px;
            margin-left: 6px;
        }

        /* Price - Bold */
        .pd-price {
            font-size: 28px;
            font-weight: 800;
            color: {{ get_setting('site_color') }} ;
            margin: 15px 0;
        }

        .pd-price .old {
            font-size: 18px;
            color: #999;
            text-decoration: line-through;
            font-weight: 400;
            margin-left: 10px;
        }

        /* Description */
        .pd-short-desc {
            font-size: 15px;
            line-height: 1.5;
            color: #444;
            margin: 15px 0;
            padding: 15px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        /* === BUTTONS - MODERN === */
        .pd-actions {
            display: flex;
            gap: 12px;
            margin: 20px 0;
        }

        .btn-buy {
            flex: 1;
            background: {{ get_setting('site_color') }} ;
            color: white;
            border: none;
            padding: 16px 20px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 10px 20px rgba(255,107,107,0.2);
        }

        .btn-wishlist {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            border: 1px solid #ddd;
            background: white;
            color: {{ get_setting('site_color') }} ;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* === YOUTUBE - SLEEK === */
        .container {
            padding: 0 12px;
            margin: 20px 0;
        }

        .container iframe {
            width: 100%;
            height: 200px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* === LATEST PRODUCTS - 2 COL GRID === */
        .latest-products {
            padding: 20px 12px;
            background: #f8f9fa;
            margin-top: 20px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a1a;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 50px;
            height: 4px;
            background: {{ get_setting('site_color') }} ;
            border-radius: 2px;
        }

        .latest-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .latest-card {
            background: white;
            border-radius: 20px;
            padding: 15px 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            transition: 0.2s;
        }

        .latest-card img {
            width: 100%;
            height: 140px;
            object-fit: contain;
            margin-bottom: 10px;
            mix-blend-mode: multiply;
        }

        .latest-card h4 {
            font-size: 15px;
            font-weight: 600;
            margin: 8px 0 4px;
            color: #1a1a1a;
            line-height: 1.2;
        }

        .latest-card .price {
            font-size: 18px;
            font-weight: 700;
            color: {{ get_setting('site_color') }} ;
            display: block;
            margin: 8px 0;
        }

        .latest-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-view {
            flex: 1;
            background: #f1f3f5;
            color: #495057;
            padding: 10px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
        }

        .btn-cart {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: {{ get_setting('site_color') }} ;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* Breadcrumb - Simple */
        .breadcrumb-wrap {
            padding: 12px;
            background: white;
            border-bottom: 1px solid #f0f0f0;
        }

        .breadcrumb {
            font-size: 13px;
            color: #868e96;
        }

        .breadcrumb a {
            color: #495057;
            text-decoration: none;
        }

        .breadcrumb .active {
            color: {{ get_setting('site_color') }} ;
            font-weight: 500;
        }
    }

    /* === SMALL PHONES === */
    @media screen and (max-width: 380px) {
        .latest-grid {
            grid-template-columns: 1fr;
        }
        
        .pd-title {
            font-size: 22px;
        }
        
        .btn-buy {
            padding: 14px;
        }
    }
</style>
</div>