@extends('user.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Breadcrumb -->
            <div class="row mb-3">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('user.dashboard') }}">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('user.orders') }}">My Orders</a>
                            </li>
                            <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Order Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="card-title text-success mb-1">
                                <i class="fas fa-receipt  me-2"></i>
                                Order #{{ $order->order_number }}
                            </h4>
                            <p class="text-muted mb-0">
                                <i class="far fa-clock me-1"></i>
                                Placed on {{ $order->created_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'processing' => 'info',
                                    'shipped' => 'primary',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$order->order_status] ?? 'secondary' }} fs-6 px-3 py-2">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column: Order Items -->
                <div class="col-lg-8">
                    <!-- Order Items Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-bag me-2"></i>Order Items
                                <span class="badge bg-secondary ms-2">{{ $order->items->count() }} items</span>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="60px"></th>
                                            <th>Product</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                @if($item->product && $item->product->primary_image)
                                                    <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                                         alt="{{ $item->product->name }}"
                                                         class="rounded" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <h6 class="mb-1">{{ $item->product->name ?? 'Product Removed' }}</h6>
                                                @if($item->variation_options)
                                                    <small class="text-muted">
                                                        {{ $item->variation_options }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">₹{{ number_format($item->price, 2) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark fs-6">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold">₹{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
   <!-- Shipping Address -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-truck me-2"></i>Shipping Address
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($order->address)
                            <div class="address-card">
                                <h6 class="mb-2">{{ $order->address->name }}</h6>
                                <p class="text-muted mb-1">
                                    {{ $order->address->address_line1 }}
                                    @if($order->address->address_line2)
                                        , {{ $order->address->address_line2 }}
                                    @endif
                                </p>
                                <p class="text-muted mb-1">
                              {{ $order->address->city }},
{{ $order->address->state?->name }} -
{{ $order->address->pincode }}

                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-phone me-1"></i> {{ $order->address->phone }}
                                </p>
                            </div>
                            @else
                            <p class="text-muted">No address found</p>
                            @endif
                        </div>
                    </div>
                    <!-- Order Timeline -->
                    {{--@if($order->order_status !== 'cancelled')
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-history me-2"></i>Order Status Timeline
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="steps">
                                <div class="step {{ $order->order_status == 'pending' || 
                                                   $order->order_status == 'processing' || 
                                                   $order->order_status == 'shipped' || 
                                                   $order->order_status == 'delivered' ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="far fa-clock"></i>
                                    </div>
                                    <div class="step-content">
                                        <h6>Order Placed</h6>
                                        <p class="text-muted mb-0">{{ $order->created_at->format('d M, h:i A') }}</p>
                                    </div>
                                </div>

                                <div class="step {{ $order->order_status == 'processing' || 
                                                   $order->order_status == 'shipped' || 
                                                   $order->order_status == 'delivered' ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="step-content">
                                        <h6>Processing</h6>
                                        @if($order->order_status == 'processing' || 
                                            $order->order_status == 'shipped' || 
                                            $order->order_status == 'delivered')
                                            <p class="text-muted mb-0">Order confirmed</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="step {{ $order->order_status == 'shipped' || 
                                                   $order->order_status == 'delivered' ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="step-content">
                                        <h6>Shipped</h6>
                                        @if($order->order_status == 'shipped')
                                            <p class="text-muted mb-0">Out for delivery</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="step {{ $order->order_status == 'delivered' ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="step-content">
                                        <h6>Delivered</h6>
                                        @if($order->order_status == 'delivered')
                                            <p class="text-muted mb-0">Successfully delivered</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif--}}
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-4">
                    <!-- Order Summary Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-file-invoice me-2"></i>Order Summary
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            
                            @if($order->discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount</span>
                                <span>-₹{{ number_format($order->discount, 2) }}</span>
                            </div>
                            @endif
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span>₹{{ number_format($order->shipping_charge, 2) }}</span>
                            </div>
                            
                            <!-- TAX Section - Check which tax fields exist -->
                            @if($order->tax > 0 && (!$order->cgst && !$order->sgst && !$order->igst))
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (GST)</span>
                                <span>₹{{ number_format($order->tax, 2) }}</span>
                            </div>
                            @endif
                            
                            <!-- If separate GST fields exist -->
                            @if($order->cgst || $order->sgst || $order->igst)
                            <div class="tax-breakdown mb-3">
                                <small class="d-block text-muted mb-1">Tax Breakdown:</small>
                                @if($order->cgst)
                                <div class="d-flex justify-content-between">
                                    <small>CGST:</small>
                                    <small>₹{{ number_format($order->cgst, 2) }}</small>
                                </div>
                                @endif
                                @if($order->sgst)
                                <div class="d-flex justify-content-between">
                                    <small>SGST:</small>
                                    <small>₹{{ number_format($order->sgst, 2) }}</small>
                                </div>
                                @endif
                                @if($order->igst)
                                <div class="d-flex justify-content-between">
                                    <small>IGST:</small>
                                    <small>₹{{ number_format($order->igst, 2) }}</small>
                                </div>
                                @endif
                                @if($order->cgst || $order->sgst || $order->igst)
                                <div class="d-flex justify-content-between fw-bold">
                                    <small>Total Tax:</small>
                                    <small>₹{{ number_format(($order->cgst ?? 0) + ($order->sgst ?? 0) + ($order->igst ?? 0), 2) }}</small>
                                </div>
                                @endif
                            </div>
                            @endif
                            
                            <hr>
                            <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                                <span>Total</span>
                                <span class="text-primary">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Payment Method</span>
                                <span class="badge bg-{{ $order->payment_method == 'cod' ? 'warning' : 'success' }}">
                                    {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Online Payment' }}
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Payment Status</span>
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                 

                    <!-- Order Actions -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-cogs me-2"></i>Order Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('user.orders') }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                                </a>
                                
                                <!-- @if(in_array($order->order_status, ['pending', 'processing']))
                                    <button class="btn btn-danger" 
                                            onclick="cancelOrder({{ $order->id }})">
                                        <i class="fas fa-times-circle me-2"></i>Cancel Order
                                    </button>
                                @endif -->
                                
                                @if($order->order_status === 'delivered')
                                    <button class="btn btn-success">
                                        <i class="fas fa-star me-2"></i>Rate Products
                                    </button>
                                    
                                    <button class="btn btn-outline-primary">
                                        <i class="fas fa-redo me-2"></i>Reorder All Items
                                    </button>
                                @endif
                                
                                <button onclick="printInvoice()" class="btn btn-info">
                                    <i class="fas fa-download me-2"></i>Download Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Invoice Template (Hidden) -->
<div id="invoiceTemplate" style="display: none;">
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="company-details">
                <div class="company-logo">
                    <h2>{{ get_setting('company_name',config('app.name') ) }}</h2>
                </div>
                <div class="company-address">
                    <p><strong>Registered Office:</strong></p>
                    <p>{{ get_setting('company_address') }}</p>
                    <p>Phone:{{get_setting('company_phone')}}</p>
                    <p>Email: {{ get_setting('company_email') }}</p>
                    <p>GSTIN: {{ get_setting('company_gst') }}</p>
                </div>
            </div>
            
            <div class="invoice-title">
                <h1>TAX INVOICE</h1>
                <p class="invoice-number">Invoice No: INV-{{ $order->order_number }}</p>
                <p class="invoice-date">Date: {{ $order->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
        
        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="bill-to">
                <h3>Bill To:</h3>
                @if($order->address)
                <p><strong>{{ $order->address->name }}</strong></p>
                <p>{{ $order->address->address_line1 }}</p>
                @if($order->address->address_line2)
                <p>{{ $order->address->address_line2 }}</p>
                @endif
                <p>{{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}</p>
                <p>Phone: {{ $order->address->phone }}</p>
                @endif
            </div>
            
            <div class="order-info">
                <h3>Order Information:</h3>
                <table class="info-table">
                    <tr>
                        <td><strong>Order Number:</strong></td>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Order Date:</strong></td>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Method:</strong></td>
                        <td>{{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Status:</strong></td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Order Status:</strong></td>
                        <td>{{ ucfirst($order->order_status) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Products Table -->
        <div class="products-table">
            <h3>Products/Services</h3>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Sr.</th>
                        <th style="width: 45%;">Description</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 15%;">Amount</th>
                        <th style="width: 10%;">Tax</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                        $totalTax = 0;
                    @endphp
                    
                    @foreach($order->items as $index => $item)
                    @php
                        $itemTotal = $item->price * $item->quantity;
                        $subtotal += $itemTotal;
                        // Calculate tax for each item if needed
                        $itemTax = $item->tax ?? 0;
                        $totalTax += $itemTax;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->product->name ?? 'Product Removed' }}</strong>
                            @if($item->product && $item->product->sku)
                            <br><small>SKU: {{ $item->product->sku }}</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">₹{{ number_format($itemTotal, 2) }}</td>
                        <td class="text-right">
                            @if($itemTax > 0)
                            ₹{{ number_format($itemTax, 2) }}
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Totals Section -->
        <div class="totals-section">
            <div class="amount-words">
                <p><strong>Amount in Words:</strong> 
                    @php
                        function numberToWords($num) {
                            $ones = array(
                                0 => "Zero", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four",
                                5 => "Five", 6 => "Six", 7 => "Seven", 8 => "Eight", 9 => "Nine",
                                10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen",
                                14 => "Fourteen", 15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen",
                                18 => "Eighteen", 19 => "Nineteen"
                            );
                            
                            $tens = array(
                                2 => "Twenty", 3 => "Thirty", 4 => "Forty", 5 => "Fifty",
                                6 => "Sixty", 7 => "Seventy", 8 => "Eighty", 9 => "Ninety"
                            );
                            
                            if ($num < 20) {
                                return $ones[$num];
                            } elseif ($num < 100) {
                                return $tens[floor($num/10)] . (($num%10 != 0) ? " " . $ones[$num%10] : "");
                            } elseif ($num < 1000) {
                                return $ones[floor($num/100)] . " Hundred" . (($num%100 != 0) ? " " . numberToWords($num%100) : "");
                            } elseif ($num < 100000) {
                                return numberToWords(floor($num/1000)) . " Thousand" . (($num%1000 != 0) ? " " . numberToWords($num%1000) : "");
                            } elseif ($num < 10000000) {
                                return numberToWords(floor($num/100000)) . " Lakh" . (($num%100000 != 0) ? " " . numberToWords($num%100000) : "");
                            } else {
                                return numberToWords(floor($num/10000000)) . " Crore" . (($num%10000000 != 0) ? " " . numberToWords($num%10000000) : "");
                            }
                        }
                    @endphp
                    {{ numberToWords(round($order->total_amount)) }} Rupees Only
                </p>
            </div>
            
            <div class="totals-table">
                <table class="totals">
                    <tr>
                        <td><strong>Sub Total:</strong></td>
                        <td>₹{{ number_format($order->sub_total, 2) }}</td>
                    </tr>
                    
                    @if($order->discount > 0)
                    <tr>
                        <td><strong>Discount:</strong></td>
                        <td>-₹{{ number_format($order->discount, 2) }}</td>
                    </tr>
                    @endif
                    
                    <tr>
                        <td><strong>Shipping Charges:</strong></td>
                        <td>₹{{ number_format($order->shipping_charge, 2) }}</td>
                    </tr>
                    
                    <!-- Tax Section -->
                    
                    
                 @if($order->total_tax > 0)

<tr class="tax-header">
    <td colspan="2"><strong>Tax Details:</strong></td>
</tr>

@if($order->cgst > 0)
<tr>
    <td style="padding-left: 20px;">CGST:</td>
    <td>₹{{ number_format($order->cgst, 2) }}</td>
</tr>
@endif

@if($order->sgst > 0)
<tr>
    <td style="padding-left: 20px;">SGST:</td>
    <td>₹{{ number_format($order->sgst, 2) }}</td>
</tr>
@endif

@if($order->igst > 0)
<tr>
    <td style="padding-left: 20px;">IGST:</td>
    <td>₹{{ number_format($order->igst, 2) }}</td>
</tr>
@endif

<tr>
    <td style="padding-left: 20px;"><strong>Total Tax:</strong></td>
    <td><strong>₹{{ number_format($order->total_tax, 2) }}</strong></td>
</tr>

@endif
                    
                 
                    <tr class="grand-total">
                        <td><strong>Grand Total:</strong></td>
                        <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="invoice-footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>This is a computer generated invoice. No signature required.</p>
            <p>For any queries, please contact: support@store.com | Phone: +91 9876543210</p>
            <p class="print-info">Printed on: {{ now()->format('d/m/Y h:i A') }}</p>
        </div>
    </div>
</div>

<style>
    /* Timeline Styles */
    .steps {
        position: relative;
        padding-left: 30px;
    }
    
    .steps::before {
        content: '';
        position: absolute;
        left: 24px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .step {
        position: relative;
        padding-bottom: 30px;
        display: flex;
        align-items: flex-start;
    }
    
    .step:last-child {
        padding-bottom: 0;
    }
    
    .step-icon {
        position: absolute;
        left: -30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    
    .step.active .step-icon {
        background: #0d6efd;
        color: white;
    }
    
    .step-content {
        padding-left: 15px;
    }
    
    .step h6 {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    /* Address Card */
    .address-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        border-left: 4px solid #0d6efd;
    }
    
    /* Tax Breakdown */
    .tax-breakdown {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #dee2e6;
    }
    
    /* Invoice Styles */
    #invoiceTemplate {
        font-family: 'Arial', sans-serif;
    }
    
    .invoice-container {
        max-width: 210mm;
        margin: 0 auto;
        padding: 20px;
        background: white;
        color: #000;
    }
    
    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 3px solid #333;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    
    .company-details {
        flex: 1;
    }
    
    .company-logo h2 {
        margin: 0;
        color: #2c3e50;
        font-size: 24px;
    }
    
    .company-address {
        margin-top: 10px;
        font-size: 12px;
        line-height: 1.4;
    }
    
    .invoice-title {
        text-align: right;
    }
    
    .invoice-title h1 {
        margin: 0;
        color: #2c3e50;
        font-size: 28px;
    }
    
    .invoice-number, .invoice-date {
        margin: 5px 0;
        font-size: 14px;
    }
    
    .invoice-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 30px;
    }
    
    .bill-to, .order-info {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
    }
    
    .bill-to h3, .order-info h3 {
        margin-top: 0;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    
    .info-table {
        width: 100%;
    }
    
    .info-table td {
        padding: 5px 0;
    }
    
    .products-table {
        margin: 30px 0;
    }
    
    .products-table h3 {
        margin-bottom: 15px;
    }
    
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    
    .invoice-table th, .invoice-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    
    .invoice-table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    
    .invoice-table td {
        text-align: left;
    }
    
    .invoice-table .text-right {
        text-align: right;
    }
    
    .invoice-table .text-center {
        text-align: center;
    }
    
    .totals-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        margin: 30px 0;
    }
    
    .amount-words {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .totals-table {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
    }
    
    .totals {
        width: 100%;
    }
    
    .totals tr {
        border-bottom: 1px solid #eee;
    }
    
    .totals td {
        padding: 8px 0;
        text-align: right;
    }
    
    .totals td:first-child {
        text-align: left;
        padding-right: 20px;
    }
    
    .tax-header td {
        font-weight: bold;
        background-color: #f9f9f9;
    }
    
    .grand-total td {
        font-size: 16px;
        border-top: 2px solid #333;
        padding-top: 15px;
        color: #e74c3c;
    }
    
    .invoice-footer {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
        font-size: 12px;
        color: #666;
    }
    
    .print-info {
        margin-top: 20px;
        font-style: italic;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        
        #invoiceTemplate, #invoiceTemplate * {
            visibility: visible;
        }
        
        #invoiceTemplate {
            display: block !important;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: white;
        }
        
        @page {
            margin: 15mm;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .steps {
            padding-left: 25px;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            left: -25px;
        }
        
        .step-icon i {
            font-size: 14px;
        }
        
        .invoice-details {
            grid-template-columns: 1fr;
        }
        
        .totals-section {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
function cancelOrder(orderId) {
    if(confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
        fetch(`/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Order cancelled successfully!');
                location.reload();
            } else {
                alert('Failed to cancel order: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong!');
        });
    }
}

function printInvoice() {
    const printWindow = window.open('', '_blank');
    
    const invoiceHTML = document.getElementById('invoiceTemplate').innerHTML;
    
    const completeHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Tax Invoice - {{ $order->order_number }}</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 0;
                    background: white;
                    color: #000;
                }
                
                .invoice-container {
                    max-width: 210mm;
                    margin: 0 auto;
                    padding: 20px;
                }
                
                .invoice-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    border-bottom: 3px solid #333;
                    padding-bottom: 20px;
                    margin-bottom: 30px;
                }
                
                .company-details {
                    flex: 1;
                }
                
                .company-logo h2 {
                    margin: 0;
                    color: #2c3e50;
                    font-size: 24px;
                }
                
                .company-address {
                    margin-top: 10px;
                    font-size: 12px;
                    line-height: 1.4;
                }
                
                .invoice-title {
                    text-align: right;
                }
                
                .invoice-title h1 {
                    margin: 0;
                    color: #2c3e50;
                    font-size: 28px;
                }
                
                .invoice-number, .invoice-date {
                    margin: 5px 0;
                    font-size: 14px;
                }
                
                .invoice-details {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 40px;
                    margin-bottom: 30px;
                }
                
                .bill-to, .order-info {
                    border: 1px solid #ddd;
                    padding: 15px;
                    border-radius: 5px;
                }
                
                .bill-to h3, .order-info h3 {
                    margin-top: 0;
                    border-bottom: 1px solid #eee;
                    padding-bottom: 10px;
                }
                
                .info-table {
                    width: 100%;
                }
                
                .info-table td {
                    padding: 5px 0;
                }
                
                .products-table {
                    margin: 30px 0;
                }
                
                .products-table h3 {
                    margin-bottom: 15px;
                }
                
                .invoice-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 12px;
                }
                
                .invoice-table th, .invoice-table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: center;
                }
                
                .invoice-table th {
                    background-color: #f5f5f5;
                    font-weight: bold;
                }
                
                .invoice-table td {
                    text-align: left;
                }
                
                .invoice-table .text-right {
                    text-align: right;
                }
                
                .invoice-table .text-center {
                    text-align: center;
                }
                
                .totals-section {
                    display: grid;
                    grid-template-columns: 2fr 1fr;
                    gap: 40px;
                    margin: 30px 0;
                }
                
                .amount-words {
                    border: 1px solid #ddd;
                    padding: 15px;
                    border-radius: 5px;
                    font-size: 14px;
                }
                
                .totals-table {
                    border: 1px solid #ddd;
                    padding: 15px;
                    border-radius: 5px;
                }
                
                .totals {
                    width: 100%;
                }
                
                .totals tr {
                    border-bottom: 1px solid #eee;
                }
                
                .totals td {
                    padding: 8px 0;
                    text-align: right;
                }
                
                .totals td:first-child {
                    text-align: left;
                    padding-right: 20px;
                }
                
                .tax-header td {
                    font-weight: bold;
                    background-color: #f9f9f9;
                }
                
                .grand-total td {
                    font-size: 16px;
                    border-top: 2px solid #333;
                    padding-top: 15px;
                    color: #e74c3c;
                }
                
                .invoice-footer {
                    text-align: center;
                    margin-top: 40px;
                    padding-top: 20px;
                    border-top: 1px solid #ddd;
                    font-size: 12px;
                    color: #666;
                }
                
                @media print {
                    @page {
                        margin: 15mm;
                    }
                    
                    body {
                        padding: 0;
                        margin: 0;
                    }
                    
                    .invoice-container {
                        max-width: 100%;
                        padding: 0;
                    }
                }
            </style>
        </head>
        <body>
            ${invoiceHTML}
            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(function() {
                        window.close();
                    }, 500);
                };
            <\/script>
        </body>
        </html>
    `;
    
    printWindow.document.write(completeHTML);
    printWindow.document.close();
}
</script>
@endsection