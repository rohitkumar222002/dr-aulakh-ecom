<div>
   
    <div class="breadcrumb-wrap">
        <div class="products-page-container">
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">
                    <i class="fas fa-house"></i> Home
                </a>
                <span class="divider">›</span>
                <span class="active">Orders</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="orders-main">
        <div class="container">
            <div class="orders-grid">
                <!-- Sidebar Filters -->
                <div class="orders-sidebar">
                    <div class="filter-card">
                        <div class="filter-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                            </svg>
                            <h4>Filters</h4>
                        </div>
                        
                        <div class="filter-section">
                            <h5>Search Order</h5>
                            <div class="search-box w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" 
                                       placeholder="Order number..."
                                       wire:model.live.debounce.300ms="search">
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <h5>Order Status</h5>
                            <div class="status-filters">
                                <label class="status-option {{ !$status ? 'active' : '' }}">
                                    <input type="radio" name="status" wire:model.live="status" value="">
                                    <span class="status-dot" style="background: #6c757d"></span>
                                    <span>All Orders</span>
                                    <span class="status-count">{{ $orders->total() }}</span>
                                </label>
                                
                                <!-- <label class="status-option {{ $status === 'pending' ? 'active' : '' }}">
                                    <input type="radio" name="status" wire:model.live="status" value="pending">
                                    <span class="status-dot" style="background: #ff9800"></span>
                                    <span>Pending</span>
                                    <span class="status-count">{{ $orders->where('order_status', 'pending')->count() }}</span>
                                </label> -->
                                
                                <label class="status-option {{ $status === 'processing' ? 'active' : '' }}">
                                    <input type="radio" name="status" wire:model.live="status" value="processing">
                                    <span class="status-dot" style="background: #2196f3"></span>
                                    <span>Processing</span>
                                    <span class="status-count">{{ $orders->where('order_status', 'processing')->count() }}</span>
                                </label>
                                
                                <!-- <label class="status-option {{ $status === 'shipped' ? 'active' : '' }}">
                                    <input type="radio" name="status" wire:model.live="status" value="shipped">
                                    <span class="status-dot" style="background: #9c27b0"></span>
                                    <span>Shipped</span>
                                    <span class="status-count">{{ $orders->where('order_status', 'shipped')->count() }}</span>
                                </label> -->
                                
                                <label class="status-option {{ $status === 'delivered' ? 'active' : '' }}">
                                    <input type="radio" name="status" wire:model.live="status" value="delivered">
                                    <span class="status-dot" style="background: #4caf50"></span>
                                    <span>Delivered</span>
                                    <span class="status-count">{{ $orders->where('order_status', 'delivered')->count() }}</span>
                                </label>
                                
                                <!-- <label class="status-option {{ $status === 'cancelled' ? 'active' : '' }}">
                                    <input type="radio" name="status" wire:model.live="status" value="cancelled">
                                    <span class="status-dot" style="background: #f44336"></span>
                                    <span>Cancelled</span>
                                    <span class="status-count">{{ $orders->where('order_status', 'cancelled')->count() }}</span>
                                </label> -->
                            </div>
                        </div>
                        
                        <!-- <div class="filter-section">
                            <h5>Payment Type</h5>
                            <div class="payment-filters">
                                <label class="payment-option">
                                    <input type="checkbox">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                    <span>Online Payment</span>
                                </label>
                                
                                <label class="payment-option">
                                    <input type="checkbox">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                    <span>Cash on Delivery</span>
                                </label>
                            </div>
                        </div> -->
                        
                        <!-- <button class="btn-clear-filters">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Clear All Filters
                        </button> -->
                    </div>
                    
                    <!-- Quick Help -->
                    <div class="help-card">
                        <div class="help-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            <h4>Need Help?</h4>
                        </div>
                        <p>Having issues with your order?</p>
                        <button class="btn-help">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                            </svg>
                            Contact Support
                        </button>
                    </div>
                </div>
                
                <!-- Orders List -->
                <div class="orders-content">
                    @if($orders->isEmpty())
                        <!-- Empty State -->
                        <div class="empty-orders">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#dee2e6" stroke-width="1">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </div>
                            <h3>No orders found</h3>
                            <p class="empty-text">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                            <a href="{{ route('site.products') }}" class="btn-start-shopping">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                Start Shopping
                            </a>
                        </div>
                    @else
                        <!-- Orders Grid -->
                        <div class="orders-list">
                            @foreach($orders as $order)
                                <div class="order-card">
                                    <!-- Order Header -->
                                    <div class="order-header">
                                        <div class="order-meta">
                                            <div class="order-id">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                                <span>Order #{{ $order->order_number }}</span>
                                            </div>
                                            <div class="order-date">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg>
                                                {{ $order->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        
                                        <div class="order-badges">
                                            <span class="status-badge status-{{ $order->order_status }}">
                                                @php
                                                    $statusIcons = [
                                                        'pending' => '⏳',
                                                        'processing' => '⚙️',
                                                        'shipped' => '🚚',
                                                        'delivered' => '✅',
                                                        'cancelled' => '❌'
                                                    ];
                                                @endphp
                                                {{ $statusIcons[$order->order_status] ?? '📦' }}
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                            
                                            <span class="payment-badge payment-{{ $order->payment_method }}">
                                                @if($order->payment_method === 'cod')
                                                    💵 COD
                                                @else
                                                    💳 Paid
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Order Items -->
                                    <div class="order-items">
                                        @foreach($order->items->take(2) as $item)
                                            <div class="order-item">
                                                <div class="item-image">
                                                    @if($item->product && $item->product->primary_image)
                                                        <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                                             alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="image-placeholder">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                                <polyline points="21 15 16 10 5 21"></polyline>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="item-details">
                                                    <h4>{{ $item->product->name ?? 'Product removed' }}</h4>
                                                    <div class="item-meta">
                                                        <span class="item-quantity">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                            </svg>
                                                            Qty: {{ $item->quantity }}
                                                        </span>
                                                        <span class="item-price">
                                                            ₹{{ number_format($item->price) }} each
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="item-total">
                                                    ₹{{ number_format($item->total, 2) }}
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        @if($order->items->count() > 2)
                                            <div class="more-items">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                </svg>
                                                +{{ $order->items->count() - 2 }} more items
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Order Footer -->
                                    <div class="order-footer">
                                        <div class="order-total">
                                            <span>Total Amount</span>
                                            <h3>₹{{ number_format($order->total_amount, 2) }}</h3>
                                        </div>
                                        
                                        <div class="order-actions">
                                            <a href="{{ route('order.success', $order->id) }}" 
                                               class="btn-action btn-view">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                                View Details
                                            </a>
                                            
                                            @if(in_array($order->order_status, ['pending', 'processing']))
                                                <button class="btn-action btn-cancel">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                                    </svg>
                                                    Cancel Order
                                                </button>
                                            @endif
                                            
                                            @if($order->order_status === 'delivered')
                                                <button class="btn-action btn-reorder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="9" cy="21" r="1"></circle>
                                                        <circle cx="20" cy="21" r="1"></circle>
                                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                                    </svg>
                                                    Reorder
                                                </button>
                                                
                                                <button class="btn-action btn-review">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                                    </svg>
                                                    Review
                                                </button>
                                            @endif
                                            
                                            @if($order->order_status === 'shipped')
                                                <button class="btn-action btn-track">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="18" cy="18" r="3"></circle>
                                                        <circle cx="6" cy="6" r="3"></circle>
                                                        <path d="M13 6h3l2 4h-6l-2-4z"></path>
                                                        <line x1="6" y1="9" x2="6" y2="21"></line>
                                                        <line x1="18" y1="9" x2="18" y2="21"></line>
                                                    </svg>
                                                    Track Order
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($orders->hasPages())
                            <div class="pagination-wrapper">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
       .breadcrumb-wrap {
            background: linear-gradient(
                to right,
                rgba(218,165,32,0.08),
                rgba(218,165,32,0.02)
            );
            border-bottom: 1px solid #eee;
            padding: 25px;
        }

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    /* font-size: 0.75rem; */
    font-weight: 500;
    color: var(--gray);
    justify-content: center
}

.breadcrumb a {
    color: var(--gray);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.25s ease;
}

.breadcrumb a i {
    font-size: 1rem;
    opacity: 0.7;
}

.breadcrumb a:hover {
    color: var(--primary-blue);
}

.breadcrumb .divider {
    color: #bbb;
    font-size: 0.8rem;
}

.breadcrumb .active {
    color: var(--dark);
    font-weight: 600;
    letter-spacing: 0.2px;
}
.orders-main{
    padding-top: 50px;
}
        
        .title-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .header-title h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }
        
        .header-stats {
            display: flex;
            gap: 1.5rem;
        }
        
        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            min-width: 150px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Main Content */
        .orders-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        /* Sidebar */
        .filter-card, .help-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }
        
        .filter-header, .help-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f5f5f5;
        }
        
        .filter-header h4, .help-header h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .filter-section {
            margin-bottom: 1.5rem;
        }
        
        .filter-section h5 {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }
        
        .search-box {
            position: relative;
            margin-bottom: 1rem;
        }
        
        .search-box svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .status-filters {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .status-option {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .status-option:hover {
            background: #f8f9fa;
        }
        
        .status-option.active {
            background: #f0f4ff;
            border-left: 3px solid #667eea;
        }
        
        .status-option input {
            display: none;
        }
        
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        .status-option span:not(.status-dot):not(.status-count) {
            flex: 1;
            font-size: 0.9rem;
        }
        
        .status-count {
            background: #f5f5f5;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            color: #666;
        }
        
        .payment-filters {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .payment-option {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-option:hover {
            background: #f8f9fa;
        }
        
        .payment-option input {
            display: none;
        }
        
        .btn-clear-filters {
            width: 100%;
            padding: 0.75rem;
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .btn-clear-filters:hover {
            background: #e9ecef;
        }
        
        .help-card p {
            color: #666;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .btn-help {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-help:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Orders List */
        .orders-content {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }
        
        .empty-orders {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-icon {
            margin-bottom: 1.5rem;
        }
        
        .empty-orders h3 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .empty-text {
            color: #666;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-start-shopping {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-start-shopping:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        /* Order Card */
        .order-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #f0f0f0;
            transition: all 0.3s;
        }
        
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border-color: #e0e0e0;
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f5f5f5;
        }
        
        .order-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .order-id {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
        
        .order-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .order-badges {
            display: flex;
            gap: 0.5rem;
        }
        
        .status-badge, .payment-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d1ecf1; color: #0c5460; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        .payment-cod { background: #fff3cd; color: #856404; }
        .payment-online { background: #d4edda; color: #155724; }
        
        .order-items {
            margin-bottom: 1.5rem;
        }
        
        .order-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            background: #f8f9fa;
            margin-bottom: 0.75rem;
        }
        
        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .image-placeholder {
            width: 100%;
            height: 100%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-details h4 {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .item-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: #666;
        }
        
        .item-quantity {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .item-total {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
        
        .more-items {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #666;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .more-items:hover {
            background: #e9ecef;
        }
        
        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.5rem;
            border-top: 2px solid #f5f5f5;
        }
        
        .order-total h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin: 0;
        }
        
        .order-total span {
            display: block;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.25rem;
        }
        
        .order-actions {
            display: flex;
            gap: 0.75rem;
        }
        
        .btn-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            border: none;
        }
        
        .btn-view {
            background: #f0f4ff;
            color: #667eea;
            border: 1px solid #d0d9ff;
        }
        
        .btn-view:hover {
            background: #667eea;
            color: white;
        }
        
        .btn-cancel {
            background: #fff5f5;
            color: #f56565;
            border: 1px solid #fed7d7;
        }
        
        .btn-cancel:hover {
            background: #f56565;
            color: white;
        }
        
        .btn-reorder {
            background: #f0fff4;
            color: #48bb78;
            border: 1px solid #c6f6d5;
        }
        
        .btn-reorder:hover {
            background: #48bb78;
            color: white;
        }
        
        .btn-review {
            background: #faf5ff;
            color: #9f7aea;
            border: 1px solid #e9d8fd;
        }
        
        .btn-review:hover {
            background: #9f7aea;
            color: white;
        }
        
        .btn-track {
            background: #e6fffa;
            color: #38b2ac;
            border: 1px solid #b2f5ea;
        }
        
        .btn-track:hover {
            background: #38b2ac;
            color: white;
        }
        
        /* Pagination */
        .pagination-wrapper {
            margin-top: 2rem;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .page-link:hover {
            background: #f8f9fa;
            border-color: #667eea;
            color: #667eea;
        }
        
        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .orders-grid {
                grid-template-columns: 1fr;
            }
            
            .header-stats {
                width: 100%;
                justify-content: space-between;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .title-icon {
                margin-left: auto;
                margin-right: auto;
            }
            
            .header-stats {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }
            
            .stat-item {
                width: 100%;
                text-align: center;
            }
            
            .order-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .order-footer {
                flex-direction: column;
                gap: 1.5rem;
                align-items: stretch;
            }
            
            .order-actions {
                flex-wrap: wrap;
            }
            
            .btn-action {
                flex: 1;
                min-width: 120px;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .orders-content {
                padding: 1rem;
            }
            
            .order-item {
                flex-direction: column;
                text-align: center;
            }
            
            .item-details {
                text-align: center;
            }
            
            .item-meta {
                justify-content: center;
            }
        }
        
    </style>
</div>