<div>
    @section('meta_title'){{ $product->meta_title ?? $product->product_name }} @stop
    @section('meta_keywords') {{ $product->meta_title ?? $product->product_name }} @stop
    @section('meta_description') {{ $product->meta_title ?? $product->product_name }} @stop
    @section('meta_image'){{ uploaded_asset($product->image) }}@stop

   @section('site-styles')
        @isset($product->store->store_theam_color)
            <style>
                .top-bar,
                a.register-btn,
                .shop-contact ul li a i,
                form.WhatsApp-form button,
                .dicount,
                .call-action,
                .cart a:hover {
                    background: {{ $product->store->store_theam_color }};
                }


                .shop-logo {
                    border: 4px solid {{ $product->store->store_theam_color }};
                }

                form.WhatsApp-form input,
                .shop-description a,
                .cart a {
                    border: 1px solid {{ $product->store->store_theam_color }};
                }

                .shop-description h3,
                .shop-name a,
                .cart a,
                a.get-btn {
                    color: {{ $product->store->store_theam_color }};
                }

                .coupon-box {
                    border: 2px dashed {{ $product->store->store_theam_color }};
                }

                .product-title,
                .dicount-price span,
                .total-discount span,
                .valid-upto span,
                .coupon-left span,
                .nav-tabs .nav-link.active {
                    color: {{ $product->store->store_theam_color }};
                }

                .contact-form {
                    background: {{ $product->store->store_theam_color }};
                }

                .info-list li i {
                    background-color: {{ $product->store->store_theam_color }};
                }
           
                .thumbnail-img {
    width: 100%;
    height: auto;
    min-height: 50px;
    max-height: 50px;
    object-fit: cover;
    cursor: pointer;
    min-width: 80px;
    max-width: 80px;
    border-radius: 10px
}

.preview-pic img {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain;
    border-radius: 8px;  
   {{--order: 2px solid {{ $product->store->store_theam_color }}; --}}
    padding: 4px
    background: white; 
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); 
}

.thumbnail-wrapper {
    display: flex;
    /* align-items: center; */
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
                gap: 5px;
    width: 200px;
    height: 350px;
}
#thumbnail-container {
    display: flex;
    /* gap: 5px; */
    overflow-x: auto;
    white-space: nowrap;
    max-width: 90%;
    scrollbar-width: none;
}
#thumbnail-container::-webkit-scrollbar {
    display: none;


}
.arrow-btn {
    margin-bottom: -10px;
    margin-left: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    background: white;
    border: 2px solid #ccc;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease-in-out;
}

.arrow-btn::after {
    content: "▲"; 
    font-size: 18px;
    font-weight: bold;
    color: black;
}

.down-btn::after {
    content: "▼";
}

.arrow-btn:hover {
    background: #f0f0f0;
    border-color: #aaa;
}

@media (max-width: 768px) {
    .thumbnail-wrapper {
        flex-direction: row;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        width: 100%;
        height: 85px;
        padding: 5px 0;
        scrollbar-width: none;
    }

    .thumbnail-wrapper::-webkit-scrollbar {
        display: none;
    }
    .li-padding{
    padding: 0.5rem 0.5rem !important;
        
    }

    #thumbnail-container {
        display: flex;
        flex-direction: row;
        /* gap: 8px; */
        flex-wrap: nowrap;
    }

    .thumbnail-img {
        height: 85px;
        width: auto;
        object-fit: cover;
        cursor: pointer;
    }

    .up-btn, .down-btn {
        display: none; 
    }
}




            </style>
        @endisset
    @stop


    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="{{ route('site.index') }}">Home</a></li>
                    <li><a href="{{ route('coupens') }}">Products</a></li>
                    <li><a href="{{ url()->current() }}">{{ $product->product_name }}</a></li>
                </ul>
            </div>
        </div>
    </div>




    <div class="product-details">
        <div class="container">
            <div class="row">
            <div class="preview col-md-6">
    <div class="preview-pic tab-content">
        @if ($product->multiple_image)
            @foreach (explode(',', $product->multiple_image) as $key => $image)
                <div class="tab-pane {{ $key === 0 ? 'active' : '' }}" id="pic-{{ $key + 1 }}">
                    <img src="{{ uploaded_asset($image) }}" alt="Product Image">
                </div>
            @endforeach
        @else
            <div class="tab-pane active" id="pic-1">
                <img src="{{ uploaded_asset($product->image) }}" alt="Product Image">
            </div>
        @endif
    </div>

    <!-- Thumbnails Container -->
    <div class="thumbnail-wrapper">
    <button class="arrow-btn up-btn"></button>
        <!-- <button id="prevBtn" class="arrow-btn">&lt;</button> -->
        <ul id="thumbnail-container" class="preview-thumbnail nav">
            @php
                $images = $product->multiple_image ? explode(',', $product->multiple_image) : [$product->image];
                $images = array_slice($images, 0, 10); // Max 10 thumbnails
            @endphp
            @foreach ($images as $key => $thumbnail)
                <li class="nav-item">
                    <a class="nav-link li-padding {{ $key === 0 ? 'active' : '' }}" data-toggle="tab" href="#pic-{{ $key + 1 }}">
                        <img src="{{ uploaded_asset($thumbnail) }}" alt="Thumbnail" class="img-fluid thumbnail-img">
                    </a>
                </li>
            @endforeach
        </ul>
        <button class="arrow-btn down-btn"></button> 
        <!-- <button id="nextBtn" class="arrow-btn">&gt;</button> -->
    </div>
</div>


                @php
                    $salePrice = $product->offer_price ?? ($product->discounted_price ?? $product->mrp_price);
                    $mrp = $product->mrp_price;
                    $discountPercentage = calculateDiscountPercentage($mrp, $salePrice);
                @endphp

                <div class="details col-md-6">
                    <div class="brand-share">
                        <h3>{{ $product->category->category_name ?? ' ' }}</h3>
                        <i class="las la-heart"></i>
                    </div>

                    <h3 class="product-title">{{ $product->product_name }}</h3>
                    <h4 class="price">

                        @if ($mrp > $salePrice)
                            <del>Mrp:<span>Rs.{{ $mrp }}</span></del>
                        @endif

                    </h4>
                    <div class="dicount-price">
                        Price : <span>Rs.{{ $salePrice }}</span>
                    </div>

                    @if ($discountPercentage > 0)
                        <div class="total-discount">
                            Total discount : <span>{{ $discountPercentage }}%</span>
                        </div>
                    @endif

                    @if ($product->valid_upto)
                        <div class="valid-upto">
                            Valid upto : <span>{{ date('j F Y', strtotime($product->valid_upto)) }}</span>
                        </div>
                    @endif

                    @if ($product->quantity > 0)
                        <div class="coupon-left">
                            Coupon Left : <span>{{ $product->quantity }}</span>
                        </div>
                    @endif

                    <div class="descrition">
                        <h3>Description</h3>
                        <p>{{ Str::words($product->description, 40, '...') }}</p>
                    </div>


                    <div class="action">
                        @if ($product->type == 1 && $product->quantity > 0 && \Carbon\Carbon::now()->lessThan($product->valid_upto))
                            <button type="button" class="add-to-cart btn btn-default" data-toggle="modal"
                                data-target="#exampleModalLong">
                                Avail Now
                            </button>

                            <div class="modal fade bd-example-modal-lg" id="exampleModalLong" tabindex="-1"
                                wire:ignore.self role="dialog" aria-labelledby="exampleModalLongTitle"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document" data-keyboard="false">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Product Terms & Condition
                                            </h5>
                                            <button type="button" class="close btn btn-light" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                        </div>
                                        <div class="modal-body">
                                            @if (session()->has('message') || session()->has('error') || session()->has('success'))
                                                <div
                                                    class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                                                    {{ session('message') ?? (session('error') ?? session('success')) }}
                                                </div>
                                            @endif
                                            {!! $product->terms_conditions !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success "
                                                wire:click="toOrderPlace({{ $product->id }})">Confirm Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($product->type == 0)
                            <!-- Optionally handle type 0 case if needed -->
                        @else
                            <button class="add-to-cart btn btn-default" type="button">Out Of Stock</button>
                        @endif
                    </div>


                </div>
            </div>



            <div class="row mt-5">
                <div class="list-btn">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @if ($product->description || $product->terms_conditions)
                            <!-- Check if either Description or Terms exists -->
                            @if ($product->description)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                        aria-selected="true">Description</button>
                                </li>
                            @endif

                            @if ($product->terms_conditions)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if (!$product->description) active @endif"
                                        id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                                        role="tab" aria-controls="profile" aria-selected="false">Terms &
                                        Conditions</button>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    @if ($product->description)
                        <div class="tab-pane fade active show" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="product-description">
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($product->terms_conditions)
                        <div class="tab-pane fade @if ($product->description) '' @else active show @endif"
                            id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="product-description">
                                <p>{{ $product->terms_conditions }}</p>
                            </div>
                        </div>
                    @endif
                </div>
              @if($product->youtube_link)
@php
    $embedUrl = $product->youtube_link;

    $embedUrl = preg_replace('/watch\?v=/', 'embed/', $embedUrl);

    $embedUrl = preg_replace('/&.*$/', '', $embedUrl);
@endphp

<iframe width="100%" height="315"
    src="{{ $embedUrl }}"
    frameborder="0"
    allowfullscreen>
</iframe>
@endif



            </div>


        </div>
    </div>




    <div class="coupons related-products">
        <div class="container">
            <div class="row">
                <div class="title">
                    <!-- <h3>Related Products</h3> -->
                    <h3>More Coupons</h3>

                </div>
            </div>


            <div class="row">
                @foreach (App\Models\Product\Product::with(['category'])->where('status', 1)->where('user_id', $product->user_id)->where('type', $product->type)->orderby('priority', 'ASC')->take(8)->get() as $coupen)
                    @php
                        $salePrice = $coupen->offer_price ?? ($coupen->discounted_price ?? $coupen->mrp_price);
                        $mrp = $coupen->mrp_price;
                        $discountPercentage = calculateDiscountPercentage($mrp, $salePrice);
                    @endphp

                    <div class="col-6 col-md-2 mt-2">
                        <div class="coupon-box">
                            <div class="product-img">
                                <img src="{{ uploaded_asset($coupen->image) }}" class="w-100 responsive-img img-fluid">

                                @if ($discountPercentage > 0)
                                    <div class="dicount">
                                        {{ $discountPercentage }}% Off
                                    </div>
                                @endif
                            </div>

                            <div class="product-content">
                                <h3>
                                <a wire:navigate
       href="{{ route('product.detail', ['store' => $this->product->store->store_slug, 'slug' => $coupen->product_slug]) }}">
       {{ Str::limit($coupen->product_name, 13, '...') }}
    </a> </h3>
                                <div class="shop-name">
                                    <a wire:navigate href="{{ route('stores') }}"><i class="las la-user"></i>
                                        @if (isset($coupen->category->category_name))
                                            {{ Str::limit($coupen->category->category_name, 10, '...') ?? '' }}
                                        @endif
                                    </a>
                                </div>

                                @if ($coupen->type == 1 && $coupen->quantity > 0 && \Carbon\Carbon::now()->lessThan($coupen->valid_upto))
                                    <div class="price">
                                        <div class="mrp">
                                            @if ($mrp > $salePrice)
                                                <del>Rs.{{ number_format($mrp) }}</del>
                                            @endif
                                        </div>
                                        <div class="sale">
                                            Rs.{{ number_format($salePrice) }}
                                        </div>
                                    </div>
                                    <div class="cart">
                                    <a class="text-white" 
   href="{{ route('product.detail', ['store' => $this->product->store->store_slug, 'slug' => $coupen->product_slug]) }}">
   <i class="las la-shopping-bag"></i> Avail Now
</a>

                                    </div>
                                @elseif($coupen->type == 0)
                                @else
                                    <div class="cart ">
                                        <a href="javascript:void(0)" class="bg-dark text-white">
                                            Out Of StocK
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@push('site-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#exampleModalLong').modal({
                keyboard: false, // Disable closing the modal with ESC key
                backdrop: 'static' // Prevent closing modal by clicking outside
            });

            // Disable scrolling when the modal is shown
            $('#exampleModalLong').on('show.bs.modal', function() {
                $('body').css('overflow', 'hidden');
            });

            // Enable scrolling when the modal is hidden
            $('#exampleModalLong').on('hidden.bs.modal', function() {
                $('body').css('overflow', 'auto');
            });
        });
    </script>
  
  <script>
 document.addEventListener("DOMContentLoaded", function () {
    const thumbnails = document.querySelectorAll("#thumbnail-container .nav-link");
    const tabPanes = document.querySelectorAll(".tab-pane");
    const container = document.getElementById("thumbnail-container");
    const leftBtn = document.querySelector(".left-btn");
    const rightBtn = document.querySelector(".right-btn");

    // Thumbnail Click Event (Changes Main Image)
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener("click", function (e) {
            e.preventDefault();
            thumbnails.forEach(thumb => thumb.classList.remove("active"));
            tabPanes.forEach(pane => pane.classList.remove("active"));
            thumbnail.classList.add("active");
            document.getElementById(`pic-${index + 1}`).classList.add("active");
        });
    });

    // Check if Mobile
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Thumbnail Scrolling Logic (Mobile: Horizontal, Desktop: Vertical)
    let isDown = false, startPos, scrollPos;

    container.addEventListener("mousedown", (e) => {
        isDown = true;
        startPos = isMobile() ? e.pageX : e.pageY;
        scrollPos = isMobile() ? container.scrollLeft : container.scrollTop;
    });

    container.addEventListener("mouseleave", () => isDown = false);
    container.addEventListener("mouseup", () => isDown = false);

    container.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const pos = isMobile() ? e.pageX : e.pageY;
        const move = (pos - startPos) * 2;
        if (isMobile()) {
            container.scrollLeft = scrollPos - move;
        } else {
            container.scrollTop = scrollPos - move;
        }
    });

    // Mobile Touch Scroll
    let touchStart = 0;
    container.addEventListener("touchstart", (e) => {
        touchStart = isMobile() ? e.touches[0].clientX : e.touches[0].clientY;
    });

    container.addEventListener("touchmove", (e) => {
        let touchMove = isMobile() ? e.touches[0].clientX : e.touches[0].clientY;
        let moveDiff = touchStart - touchMove;
        if (isMobile()) {
            container.scrollLeft += moveDiff;
        } else {
            container.scrollTop += moveDiff;
        }
        touchStart = touchMove;
    });

    // Arrow Buttons Functionality
    leftBtn.addEventListener("click", () => {
        if (isMobile()) container.scrollLeft -= 100;
        else container.scrollTop -= 100;
    });

    rightBtn.addEventListener("click", () => {
        if (isMobile()) container.scrollLeft += 100;
        else container.scrollTop += 100;
    });
});

</script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const thumbnailContainer = document.getElementById("thumbnail-container");
    const upBtn = document.querySelector(".up-btn");
    const downBtn = document.querySelector(".down-btn");

    // Scroll Up (Desktop)
    upBtn.addEventListener("click", function () {
        thumbnailContainer.scrollBy({ top: -100, behavior: "smooth" });
    });

    // Scroll Down (Desktop)
    downBtn.addEventListener("click", function () {
        thumbnailContainer.scrollBy({ top: 100, behavior: "smooth" });
    });
});
</script>

@endpush
