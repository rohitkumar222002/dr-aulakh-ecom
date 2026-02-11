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
            <div class="pd-rating">
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
                @if($product->description)
                    <!-- Parse highlights from description or use default -->
                    @php
                        $highlights = explode("\n", strip_tags($product->description));
                        $defaultHighlights = [
                            '✔ Clinically dosed ingredients',
                            '✔ No added sugar', 
                            '✔ GMP Certified',
                            '✔ Vegetarian Capsules'
                        ];
                        $displayHighlights = array_slice($highlights, 0, 4);
                        if(count($displayHighlights) < 4) {
                            $displayHighlights = array_merge($displayHighlights, 
                                array_slice($defaultHighlights, 0, 4 - count($displayHighlights)));
                        }
                    @endphp
                    
                    @foreach($displayHighlights as $highlight)
                        @if(trim($highlight))
                            <li>{{ $highlight }}</li>
                        @endif
                    @endforeach
                @else
                    <li>✔ Clinically dosed ingredients</li>
                    <li>✔ No added sugar</li>
                    <li>✔ GMP Certified</li>
                    <li>✔ Vegetarian Capsules</li>
                @endif
            </ul>
        </div>
    </div>
  @php
    $embedUrl = getYoutubeEmbedUrl($product->youtube_link);
@endphp

@if ($embedUrl)
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <iframe width="100%" height="315"
    src="{{ $embedUrl }}"
    title="YouTube video player"
    frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
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
</div>