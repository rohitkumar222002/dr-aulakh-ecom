@extends('user.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Page Header -->
          <div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <div>
                <h4 class="page-title mb-0">
                    <i class="fas fa-shopping-bag me-2"></i>Products
                </h4>
            </div>
            
            <!-- Cart Button on Right -->
            <div class="cart-side-option">
                <a href="{{ route('user.cart.index') }}" class="btn btn-outline-primary position-relative">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Cart
                    @if($cartCount > 0)
                   <span id="cart-count-badge"
      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                        {{ $cartCount }}
                        <span class="visually-hidden">items in cart</span>
                    </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>

            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Search products by name..."
                               id="searchInput">
                        <button class="btn btn-primary" onclick="searchProducts()">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="80px">Image</th>
                                    <th>Product Name</th>
                                    <th width="150px" class="text-center">Price</th>
                                    <th width="100px" class="text-center">Quantity</th>
                                    <th width="120px" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <!-- Image -->
                                    <td class="text-center">
                                        @if($product->primary_image)
                                            <img src="{{ uploaded_asset($product->primary_image) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="rounded"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Product Name -->
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                    </td>
                                    
                                    <!-- Price -->
                                    <td class="text-center">
                                        @if($product->discount_price && $product->discount_price < $product->price)
                                            <div>
                                                <span class="text-success fw-bold">
                                                    ₹{{ number_format($product->discount_price, 0) }}
                                                </span><br>
                                                <small class="text-muted text-decoration-line-through">
                                                    ₹{{ number_format($product->price, 0) }}
                                                </small>
                                            </div>
                                        @else
                                            <span class="fw-bold">
                                                ₹{{ number_format($product->price, 0) }}
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Quantity -->
                                    <td class="text-center">
                                        @if($product->stock_qty <= 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($product->stock_qty <= 10)
                                            <span class="badge bg-warning">Only {{ $product->stock_qty }} left</span>
                                        @else
                                            <span class="badge bg-success">In Stock</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Action -->
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-success" 
                                                onclick="addToCart({{ $product->id }})"
                                                {{ $product->stock_qty <= 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-cart-plus me-1"></i> 
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $products->links("pagination::bootstrap-5") }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function searchProducts() {
        const search = document.getElementById('searchInput').value;
        const url = new URL(window.location.href);
        
        if (search.trim()) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }
        
        window.location.href = url.toString();
    }
    
    
    function addToCart(productId) {

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            location.reload();   // 🔥 Page refresh
        } else {
            alert(data.message || "Failed to add product");
        }

    })
    .catch(error => {
        console.error('Error:', error);
    });
}

</script>
@endsection