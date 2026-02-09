<div>
    
@section('meta_title'){{ 'Products  in '.config('app.name') }} @stop
@section('meta_keywords') {{ 'Products in '.config('app.name') }} @stop
@section('meta_description') {{ 'Products in '.config('app.name')}} @stop
    <link rel="stylesheet" href="{{ asset('site/product.css') }}">
    
    <!-- Breadcrumb -->
    <div class="breadcrumb-wrap">
        <div class="products-page-container">
            <nav class="breadcrumb">
                <a href="{{ route('site.index') }}">
                    <i class="fas fa-house"></i> Home
                </a>
                <span class="divider">›</span>
                <span class="active">Products</span>
            </nav>
        </div>
    </div>

    <!-- Main Products Page -->
    <div class="products-page-container">
        <!-- Category Scroll -->
        <div class="category-scroll">
            <div class="category-track">
                <button class="cat-pill {{ !$selectedCategory ? 'active' : '' }}" 
                        wire:click="$set('selectedCategory', '')">
                    All Products
                </button>
                @foreach($categories as $category)
                    <button class="cat-pill {{ $selectedCategory == $category->slug ? 'active' : '' }}" 
                            wire:click="$set('selectedCategory', '{{ $category->slug }}')">
                        {{ $category->name }}
                    </button>
                @endforeach
             

            </div>
        </div>

        <div class="container-fluid">
            <!-- Two Column Layout -->
            <div class="products-layout">
                <!-- Sidebar Filters -->
                <aside class="filter-sidebar">
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <div class="filter-title">
                            <h3>Categories</h3>
                        </div>
                        <div class="filter-options">
                            @foreach($categories as $category)
                                <div class="filter-option" wire:click="$set('selectedCategory', '{{ $category->slug }}')">
                                    <div class="filter-checkbox {{ $selectedCategory == $category->slug ? 'checked' : '' }}"></div>
                                    <span class="filter-label">{{ $category->name }}</span>
                                    <span class="filter-count">({{ $category->products_count }})</span>
                                </div>
                                <!-- Subcategories -->
                                @if($selectedCategory == $category->slug && $category->subcategories->count() > 0)
                                    @foreach($category->subcategories as $subcategory)
                                        <div class="filter-option ml-3" wire:click="$set('selectedSubcategory', {{ $subcategory->slug }})">
                                            <div class="filter-checkbox {{ $selectedSubcategory == $subcategory->slug ? 'checked' : '' }}"></div>
                                            <span class="filter-label">{{ $subcategory->name }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-group">
                        <div class="filter-title">
                            <h3>Price Range</h3>
                        </div>
                        <div class="filter-options">
                            <div class="filter-option" wire:click="$set('selectedPriceRange', 'under_500')">
                                <div class="filter-checkbox {{ $selectedPriceRange == 'under_500' ? 'checked' : '' }}"></div>
                                <span class="filter-label">Under ₹500</span>
                                <span class="filter-count">({{ $priceCounts['under_500'] ?? 0 }})</span>
                            </div>
                            <div class="filter-option" wire:click="$set('selectedPriceRange', '500_1000')">
                                <div class="filter-checkbox {{ $selectedPriceRange == '500_1000' ? 'checked' : '' }}"></div>
                                <span class="filter-label">₹500 - ₹1000</span>
                                <span class="filter-count">({{ $priceCounts['500_1000'] ?? 0 }})</span>
                            </div>
                            <div class="filter-option" wire:click="$set('selectedPriceRange', '1000_2000')">
                                <div class="filter-checkbox {{ $selectedPriceRange == '1000_2000' ? 'checked' : '' }}"></div>
                                <span class="filter-label">₹1000 - ₹2000</span>
                                <span class="filter-count">({{ $priceCounts['1000_2000'] ?? 0 }})</span>
                            </div>
                            <div class="filter-option" wire:click="$set('selectedPriceRange', 'over_2000')">
                                <div class="filter-checkbox {{ $selectedPriceRange == 'over_2000' ? 'checked' : '' }}"></div>
                                <span class="filter-label">Over ₹2000</span>
                                <span class="filter-count">({{ $priceCounts['over_2000'] ?? 0 }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Badge Filter -->
                    

                    <button class="btn-clear-filters" wire:click="clearFilters">
                        Clear All Filters
                    </button>
                </aside>

                <!-- Main Products Area -->
                <main class="products-main">
                    <!-- Products Header -->
                    <div class="products-header">
                        <div class="results-count">
                            <span>
                                {{ $products->firstItem() }} - {{ $products->lastItem() }} 
                                of {{ $products->total() }} results
                            </span>
                            <button class="mobile-filter-btn" onclick="openFilters()">
                                <i class="fas fa-sliders-h"></i> Filters
                            </button>
                        </div>

                        <div class="sort-options">
                            <span class="sort-label">Sort by:</span>
                            <select class="sort-select" wire:model="sortBy">
                                <option value="recommended">Recommended</option>
                                <option value="newest">Newest</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="rating">Highest Rated</option>
                                <option value="popular">Most Popular</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="search-bar mb-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   placeholder="Search products..." 
                                   wire:model.debounce.300ms="search">
                            @if($search)
                                <button class="btn btn-outline-secondary" wire:click="$set('search', '')">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid">
                        @forelse($products as $product)
                            <div class="product-card">
                                <a wire:navigate href="{{ route('site.product', $product->slug) }}" class="text-decoration-none text-dark">
                                <!-- Product Badges -->
                                @if($product->badge)
                                    <div class="product-badge {{ $product->badge == 'BESTSELLER' ? 'best-seller' : ($product->badge == 'NEW' ? 'new-badge' : 'premium') }}">
                                        {{ $product->badge }}
                                    </div>
                                @endif
                                
                                {{--@if($product->is_featured)
                                    <div class="product-badge" style="background: #8b5cf6; left: 80px;">
                                        FEATURED
                                    </div>
                                @endif --}}

                                <!-- Product Image -->
                                <div class="product-image-container">
                                    @if($product->primary_image)
                                        <img src="{{ uploaded_asset($product->primary_image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="product-image">
                                    @elseif($product->images && $product->images->count() > 0)
                                        <img src="{{ uploaded_asset($product->images->first()->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="product-image">
                                    @else
                                        <img src="{{ asset('images/default-product.png') }}" 
                                             alt="{{ $product->name }}" 
                                             class="product-image">
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="product-info">
                                    <h3 class="product-title">{{ $product->name }}</h3>
                                    
                                    <p class="product-description">
                                        {{ $product->short_description ?: Str::limit(strip_tags($product->description), 100) }}
                                    </p>

                                    <div class="product-categories">
                                        @if($product->category)
                                            <span class="product-category">{{ $product->category->name }}</span>
                                        @endif
                                        @if($product->subcategory)
                                            <span class="product-category">{{ $product->subcategory->name }}</span>
                                        @endif
                                    </div>

                                    <!-- Rating -->
                                    @if($product->rating_avg > 0)
                                        <div class="product-rating">
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($product->rating_avg))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $product->rating_avg)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="rating-count">
                                                ({{ $product->rating_count }} reviews)
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Price Section -->
                                    <div class="product-price-section">
                                        <div>
                                            @if($product->discount_price && $product->discount_price < $product->price)
                                                <span class="product-price">₹{{ number_format($product->discount_price, 0) }}</span>
                                                <span class="original-price">₹{{ number_format($product->price, 0) }}</span>
                                                @php
                                                    $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                                                @endphp
                                                <span class="discount-percent">({{ $discountPercent }}% OFF)</span>
                                            @else
                                                <span class="product-price">₹{{ number_format($product->price, 0) }}</span>
                                                @if($product->mrp && $product->mrp > $product->price)
                                                    <span class="original-price">₹{{ number_format($product->mrp, 0) }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Stock Status -->
                                  <div class="stock-status-wrapper mb-2">
    @if($product->stock_qty <= 0)
        <div class="stock-status out-of-stock">
            <i class="fas fa-times-circle"></i> Out of Stock
        </div>

    @elseif($product->stock_qty <= 10)
        <div class="stock-status low-stock">
            <i class="fas fa-exclamation-triangle"></i> Only {{ $product->stock_qty }} left!
        </div>

    @else
        <div class="stock-status in-stock">
            <i class="fas fa-check-circle"></i> In Stock
        </div>
    @endif
</div>



                                    <!-- Actions -->
                                    <div class="product-actions">
                                        <a 
                                           class="btn-quick-view d-none">
 <i class="fas fa-shopping-cart"></i> Buy
                                        </a>
                                      <button class="btn-add-cart"
        wire:click.stop="addToCart({{ $product->id }})"
        {{ $product->stock_qty <= 0 ? 'disabled' : '' }}>
    <i class="fas fa-cart-plus"></i>
</button>

                                    </div>
                                </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h4>No products found</h4>
                                    <p class="text-muted">Try adjusting your filters or search terms</p>
                                    <button class="btn btn-primary mt-3" wire:click="clearFilters">
                                        Clear All Filters
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="pagination-wrapper mt-4">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile Filter Drawer -->
    <div class="filter-drawer" id="filterDrawer">
        <div class="filter-drawer-header">
            <h4>Filters</h4>
            <button class="fillter-button" onclick="closeFilters()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="filter-drawer-body">
            <!-- Add mobile filter content here -->
            <div class="filter-group">
                <div class="filter-title">
                    <h3>Categories</h3>
                </div>
                <div class="filter-options">
                    @foreach($categories as $category)
                        <div class="filter-option" wire:click="$set('selectedCategory', {{ $category->id }})">
                            <div class="filter-checkbox {{ $selectedCategory == $category->id ? 'checked' : '' }}"></div>
                            <span class="filter-label">{{ $category->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Add other filters for mobile -->
        </div>
    </div>

    <div class="filter-overlay" id="filterOverlay" onclick="closeFilters()"></div>

    @push('scripts')
    <script>
        function openFilters() {
            document.getElementById('filterDrawer').style.transform = 'translateX(0)';
            document.getElementById('filterOverlay').style.display = 'block';
        }
        
        function closeFilters() {
            document.getElementById('filterDrawer').style.transform = 'translateX(100%)';
            document.getElementById('filterOverlay').style.display = 'none';
        }
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeFilters();
        });
    </script>
    @endpush
</div>