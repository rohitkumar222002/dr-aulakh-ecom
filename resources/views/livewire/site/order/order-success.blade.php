<div>
    <div class="order-success-page">
        <div class="success-container">
            <!-- Success Icon -->
            <div class="success-icon">
                <div class="checkmark">✓</div>
            </div>
            
            <!-- Success Message -->
            <div class="success-message">
                <h1>Order Confirmed Successfully!</h1>
                <p class="subtitle">Thank you for your purchase. Your order has been received.</p>
            </div>
            
            <!-- Order Details Card -->
            <div class="order-details-card">
                <div class="card-header">
                    <h3><i class="icon-receipt"></i> Order Details</h3>
                    <span class="order-status-badge {{ $order->order_status }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                
                <div class="order-info-grid">
                    <div class="info-item">
                        <span class="info-label">Order Number:</span>
                        <strong class="info-value order-number">{{ $order->order_number }}</strong>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Order Date:</span>
                        <span class="info-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Payment Method:</span>
                        <span class="info-value payment-method">
                            @if($order->payment_method == 'cod')
                                <i class="icon-cod"></i> Cash on Delivery
                            @else
                                <i class="icon-online"></i> Online Payment
                            @endif
                        </span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Payment Status:</span>
                        <span class="info-value payment-status {{ $order->payment_status }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Total Amount:</span>
                        <strong class="info-value total-amount">₹{{ number_format($order->total_amount, 2) }}</strong>
                    </div>
                </div>
                
                <!-- Delivery Address -->
                @if($order->address)
                <div class="delivery-info">
                    <h4><i class="icon-location"></i> Delivery Address</h4>
                    <div class="address-box">
                        <strong>{{ $order->address->full_name }}</strong>
                        <p>{{ $order->address->phone }}</p>
                        <p class="address-text">
                            {{ $order->address->address_line1 }}
                            @if($order->address->address_line2)
                            <br>{{ $order->address->address_line2 }}
                            @endif
                            @if($order->address->landmark)
                            <br>Near {{ $order->address->landmark }}
                            @endif
                            <br>{{ $order->address->city }}, {{ $order->address->state?->name }} - {{ $order->address->pincode }}
                        </p>
                    </div>
                </div>
                @endif
                
                <!-- Order Items -->
                <div class="order-items-section">
                    <h4><i class="icon-package"></i> Order Items</h4>
                    <div class="items-list">
                        @foreach($orderItems as $item)
                        <div class="order-item-row">
                            <div class="item-image">
                                <img src="{{ uploaded_asset($item->product->primary_image) }}" 
                                     alt="{{ $item->product->name }}">
                            </div>
                            <div class="item-details">
                                <h5>{{ $item->product->name }}</h5>
                                <p class="item-meta">Quantity: {{ $item->quantity }} × ₹{{ number_format($item->price) }}</p>
                            </div>
                            <div class="item-total">
                                ₹{{ number_format($item->total) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
             <div class="order-tax-summary">
    <h4><i class="icon-receipt"></i> Tax Summary</h4>

    @if($order->cgst)
    <div class="summary-row">
        <span>CGST:</span>
        <span>₹{{ number_format($order->cgst, 2) }}</span>
    </div>
    @endif
    
    @if($order->sgst)
    <div class="summary-row">
        <span>SGST:</span>
        <span>₹{{ number_format($order->sgst, 2) }}</span>
    </div>
    @endif
    
    @if($order->igst)
    <div class="summary-row">
        <span>IGST:</span>
        <span>₹{{ number_format($order->igst, 2) }}</span>
    </div>
    @endif
    
    <hr>

    <div class="summary-row total">
        <span>Total Tax:</span>
        <strong>₹{{ number_format($order->cgst + $order->sgst + $order->igst, 2) }}</strong>
    </div>

    <div class="summary-row total">
        <span>Grand Total:</span>
        <strong>₹{{ number_format($order->total_amount, 2) }}</strong>
    </div>
</div>

                <!-- Order Timeline -->
                <div class="order-timeline">
                    <h4><i class="icon-timeline"></i> Order Status</h4>
                    <div class="timeline-steps">
                        <div class="timeline-step @if(in_array($order->order_status, ['processing', 'packed', 'shipped', 'out_for_delivery', 'delivered'])) active @endif">
                            <div class="step-icon">📦</div>
                            <div class="step-label">Order Placed</div>
                            <div class="step-time">{{ $order->created_at->format('h:i A') }}</div>
                        </div>
                        
                        <div class="timeline-connector @if(in_array($order->order_status, ['packed', 'shipped', 'out_for_delivery', 'delivered'])) active @endif"></div>
                        
                        <div class="timeline-step @if(in_array($order->order_status, ['packed', 'shipped', 'out_for_delivery', 'delivered'])) active @endif">
                            <div class="step-icon">📦</div>
                            <div class="step-label">Packed</div>
                            <div class="step-time">Soon</div>
                        </div>
                        
                        <div class="timeline-connector @if(in_array($order->order_status, ['shipped', 'out_for_delivery', 'delivered'])) active @endif"></div>
                        
                        <div class="timeline-step @if(in_array($order->order_status, ['shipped', 'out_for_delivery', 'delivered'])) active @endif">
                            <div class="step-icon">🚚</div>
                            <div class="step-label">Shipped</div>
                            <div class="step-time">Soon</div>
                        </div>
                        
                        <div class="timeline-connector @if(in_array($order->order_status, ['out_for_delivery', 'delivered'])) active @endif"></div>
                        
                        <div class="timeline-step @if(in_array($order->order_status, ['out_for_delivery', 'delivered'])) active @endif">
                            <div class="step-icon">📦</div>
                            <div class="step-label">Out for Delivery</div>
                            <div class="step-time">Soon</div>
                        </div>
                        
                        <div class="timeline-connector @if($order->order_status == 'delivered') active @endif"></div>
                        
                        <div class="timeline-step @if($order->order_status == 'delivered') active @endif">
                            <div class="step-icon">✅</div>
                            <div class="step-label">Delivered</div>
                            <div class="step-time">
                                @if($order->delivered_at)
                                    {{ $order->delivered_at->format('h:i A') }}
                                @else
                                    Soon
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                     <button onclick="printProfessionalInvoice()" class="btn-print">
                        <i class="icon-print"></i> Download/Print Invoice
                    </button>
                    
                 {{--   <a href="{{ route('track.order', $order->order_number) }}" class="btn-track">
                        <i class="icon-track"></i> Track Order
                    </a>
                    
                    <a href="{{ route('orders') }}" class="btn-view-orders">
                        <i class="icon-orders"></i> View All Orders
                    </a>
                    --}}
                </div>
            </div>
            
            <!-- What's Next Section -->
            <div class="next-steps d-none">
                <h3><i class="icon-info"></i> What's Next?</h3>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-icon">📧</div>
                        <h4>Order Confirmation</h4>
                        <p>You'll receive an email/SMS confirmation shortly</p>
                    </div>
                    
                    <div class="step-card">
                        <div class="step-icon">📦</div>
                        <h4>Order Processing</h4>
                        <p>Your order will be processed within 24 hours</p>
                    </div>
                    
                    <div class="step-card">
                        <div class="step-icon">🚚</div>
                        <h4>Shipping</h4>
                        <p>You'll receive tracking details once shipped</p>
                    </div>
                    
                    <div class="step-card">
                        <div class="step-icon">📞</div>
                        <h4>Need Help?</h4>
                        <p>Contact our support team for any queries</p>
                    </div>
                </div>
            </div>
            
            <!-- Continue Shopping -->
            <div class="continue-shopping">
                <a href="{{ route('site.index') }}" class="btn-continue-shopping">
                    <i class="icon-cart"></i> Continue Shopping
                </a>
                {{--
                <p class="help-text">
                    Need help? <a href="{{ route('contact') }}">Contact Support</a> or call us at +91 XXX-XXX-XXXX
                </p>
                --}}
            </div>
        </div>
         <div id="invoiceTemplate" style="display: none;">
        <div class="invoice-container">
            <!-- Invoice Header -->
            <div class="invoice-header">
                <div class="company-details">
                    <div class="company-logo">
                        <!-- Add your logo here -->
                        <h2>{{ config('app.name', 'Your Store') }}</h2>
                    </div>
                    <div class="company-address">
                        <p><strong>Registered Office:</strong></p>
                        <p>{{ get_setting('company_address') }}</p>
                        <p>Phone: {{ get_setting('company_phone') }}</p>
                        <p>Email: {{ get_setting('company_email') }}</p>
                    </div>
                </div>
                
                <div class="invoice-title">
                    <h1>TAX INVOICE</h1>
                    <p class="invoice-number">Invoice No: {{ $order->order_number }}</p>
                    <p class="invoice-date">Date: {{ $order->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            
            <!-- Invoice Details -->
            <div class="invoice-details">
                <div class="bill-to">
                    <h3>Bill To:</h3>
                    @if($order->address)
                    <p><strong>{{ $order->address->full_name }}</strong></p>
                    <p>{{ $order->address->address_line1 }}</p>
                    @if($order->address->address_line2)
                    <p>{{ $order->address->address_line2 }}</p>
                    @endif
                    @if($order->address->landmark)
                    <p>Near {{ $order->address->landmark }}</p>
                    @endif
                    <p>{{ $order->address->city }}, {{ $order->address->state?->name }} - {{ $order->address->pincode }}</p>
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
                            <th style="width: 40%;">Description</th>
                            <th style="width: 10%;">HSN/SAC</th>
                            <th style="width: 10%;">Qty</th>
                            <th style="width: 10%;">Price</th>
                            <th style="width: 10%;">Discount</th>
                            <th style="width: 10%;">Taxable Amt</th>
                            <th style="width: 15%;">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                            $taxable_amount = 0;
                        @endphp
                        
                        @foreach($orderItems as $index => $item)
                        @php
                            $itemSubtotal = $item->price * $item->quantity;
                            $subtotal += $itemSubtotal;
                            $taxable_amount += $itemSubtotal;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->product->name }}</strong>
                                @if($item->product->sku)
                                <br><small>SKU: {{ $item->product->sku }}</small>
                                @endif
                            </td>
                            <td>{{ $item->product->hsn_code ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>₹0.00</td>
                            <td>₹{{ number_format($itemSubtotal, 2) }}</td>
                            <td>₹{{ number_format($itemSubtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Totals and Tax Breakdown -->
            <div class="totals-section">
                <div class="amount-words">
                    <p><strong>Amount in Words:</strong> {{ $this->numberToWords(round($order->total_amount)) }} Rupees Only</p>
                </div>
                
                <div class="totals-table">
                    <table class="totals">
                        <tr>
                            <td><strong>Sub Total:</strong></td>
                            <td>₹{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Shipping Charges:</strong></td>
                            <td>₹{{ number_format($order->shipping_charge ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Discount:</strong></td>
                            <td>₹{{ number_format($order->discount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Taxable Amount:</strong></td>
                            <td>₹{{ number_format($taxable_amount, 2) }}</td>
                        </tr>
                        
                        <!-- Tax Breakdown -->
                        @if($order->cgst || $order->sgst || $order->igst)
                        <tr class="tax-header">
                            <td colspan="2"><strong>Tax Details:</strong></td>
                        </tr>
                        @endif
                        
                        @if($order->cgst)
                        <tr>
                            <td style="padding-left: 20px;">CGST ({{ $this->getTaxPercentage($order->cgst, $taxable_amount) }}%):</td>
                            <td>₹{{ number_format($order->cgst, 2) }}</td>
                        </tr>
                        @endif
                        
                        @if($order->sgst)
                        <tr>
                            <td style="padding-left: 20px;">SGST ({{ $this->getTaxPercentage($order->sgst, $taxable_amount) }}%):</td>
                            <td>₹{{ number_format($order->sgst, 2) }}</td>
                        </tr>
                        @endif
                        
                        @if($order->igst)
                        <tr>
                            <td style="padding-left: 20px;">IGST ({{ $this->getTaxPercentage($order->igst, $taxable_amount) }}%):</td>
                            <td>₹{{ number_format($order->igst, 2) }}</td>
                        </tr>
                        @endif
                        
                        <tr class="grand-total">
                            <td><strong>Grand Total:</strong></td>
                            <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                        
                        @if($order->payment_method == 'cod' && $order->payment_status == 'pending')
                        <tr>
                            <td><strong>Amount Payable:</strong></td>
                            <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            
            
            
           
            
            <!-- Footer -->
            <div class="invoice-footer">
                <p><strong>Thank you for your business!</strong></p>
                <p>For any queries, please contact: {{ get_setting('company_email') }} | {{ get_setting('company_phone') }}8</p>
            </div>
        </div>
    </div>
    
    <style>
        /* Regular Page Styles */
        .order-success-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .success-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }
        
        /* Invoice Print Styles */
        #invoiceTemplate {
            font-family: 'Arial', sans-serif;
        }
        
        .invoice-container {
            max-width: 210mm; /* A4 width */
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
        
        /* Products Table */
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
        
        .invoice-table td:nth-child(4),
        .invoice-table td:nth-child(5),
        .invoice-table td:nth-child(6),
        .invoice-table td:nth-child(7),
        .invoice-table td:nth-child(8) {
            text-align: right;
        }
        
        /* Totals Section */
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
        
       
        
        /* Footer */
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
        
        /* Print Specific Styles */
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
                padding: 0;
                margin: 0;
            }
            
            .invoice-container {
                max-width: 100%;
                padding: 15mm;
                box-shadow: none;
            }
            
            .no-print {
                display: none !important;
            }
            
            @page {
                margin: 15mm;
            }
            
            /* Force black and white for printing */
            * {
                color: #000 !important;
                background-color: white !important;
            }
            
            .invoice-table th {
                background-color: #f0f0f0 !important;
            }
        }
    </style>
    
    <script>
    function printProfessionalInvoice() {
        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        
        // Get invoice template HTML
        const invoiceHTML = document.getElementById('invoiceTemplate').innerHTML;
        
        // Create complete HTML document with styles
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
                    
                    /* Copy all the invoice styles from above */
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
                    
                    .invoice-table td:nth-child(4),
                    .invoice-table td:nth-child(5),
                    .invoice-table td:nth-child(6),
                    .invoice-table td:nth-child(7),
                    .invoice-table td:nth-child(8) {
                        text-align: right;
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
                    
                    .payment-info {
                        border: 1px solid #ddd;
                        padding: 15px;
                        border-radius: 5px;
                        margin: 20px 0;
                    }
                    
                    .terms {
                        margin: 20px 0;
                        font-size: 12px;
                    }
                    
                    .terms ol {
                        margin: 10px 0;
                        padding-left: 20px;
                    }
                    
                    .terms li {
                        margin-bottom: 5px;
                    }
                    
                    .signatures {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 40px;
                        margin: 40px 0;
                        padding-top: 40px;
                        border-top: 2px dashed #ddd;
                    }
                    
                    .customer-sign, .company-sign {
                        text-align: center;
                    }
                    
                    .sign-line {
                        height: 1px;
                        background: #333;
                        margin: 40px 0 10px 0;
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
        
        // Write to print window
        printWindow.document.write(completeHTML);
        printWindow.document.close();
    }
    
    // Fallback function if popup is blocked
    function printFallbackInvoice() {
        const originalContent = document.body.innerHTML;
        const invoiceContent = document.getElementById('invoiceTemplate').innerHTML;
        
        document.body.innerHTML = invoiceContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
    }
    </script>
    </div>
    
    <style>
        .order-tax-summary {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e5e7eb;
    margin: 20px 0;
}

.order-tax-summary h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #1f2937;
    margin-bottom: 20px;
    font-size: 18px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    color: #4b5563;
    border-bottom: 1px solid #f3f4f6;
}

.summary-row:last-child {
    border-bottom: none;
}

.summary-row.total {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
}

.summary-row.total strong {
    color: #3b82f6;
    font-size: 18px;
}

.order-tax-summary hr {
    border: none;
    border-top: 2px dashed #e5e7eb;
    margin: 15px 0;
}

        /* Order Success Page */
        .order-success-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .success-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }
        
        /* Success Icon */
        .success-icon {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .checkmark {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            animation: checkmarkAnimation 0.5s ease-in-out;
        }
        
        @keyframes checkmarkAnimation {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        /* Success Message */
        .success-message {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .success-message h1 {
            font-size: 32px;
            color: #1f2937;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .subtitle {
            color: #6b7280;
            font-size: 18px;
            margin: 0;
        }
        
        /* Order Details Card */
        .order-details-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .card-header h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            color: #1f2937;
            font-size: 20px;
        }
        
        .order-status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .order-status-badge.processing {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .order-status-badge.packed {
            background: #fef3c7;
            color: #92400e;
        }
        
        .order-status-badge.shipped {
            background: #f0f9ff;
            color: #0c4a6e;
        }
        
        .order-status-badge.out_for_delivery {
            background: #f3e8ff;
            color: #5b21b6;
        }
        
        .order-status-badge.delivered {
            background: #d1fae5;
            color: #065f46;
        }
        
        .order-status-badge.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }
        
        /* Order Info Grid */
        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 640px) {
            .order-info-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .info-label {
            font-size: 14px;
            color: #6b7280;
        }
        
        .info-value {
            font-size: 16px;
            color: #1f2937;
        }
        
        .order-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1px;
            font-family: 'Courier New', monospace;
        }
        
        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .payment-status {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .payment-status.pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .payment-status.paid {
            background: #d1fae5;
            color: #065f46;
        }
        
        .payment-status.failed {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .total-amount {
            font-size: 24px;
            color: #3b82f6;
            font-weight: 700;
        }
        
        /* Delivery Info */
        .delivery-info {
            margin-bottom: 30px;
        }
        
        .delivery-info h4 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .address-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }
        
        .address-box strong {
            display: block;
            margin-bottom: 5px;
            color: #1f2937;
            font-size: 16px;
        }
        
        .address-box p {
            margin: 5px 0;
            color: #4b5563;
            font-size: 14px;
        }
        
        .address-text {
            line-height: 1.6;
        }
        
        /* Order Items */
        .order-items-section {
            margin-bottom: 30px;
        }
        
        .order-items-section h4 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1f2937;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .items-list {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .order-item-row {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
            gap: 20px;
        }
        
        .order-item-row:last-child {
            border-bottom: none;
        }
        
        .item-image {
            flex-shrink: 0;
        }
        
        .item-image img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-details h5 {
            margin: 0 0 8px 0;
            color: #1f2937;
            font-size: 16px;
            font-weight: 500;
        }
        
        .item-meta {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
        
        .item-total {
            font-weight: 600;
            color: #1f2937;
            font-size: 16px;
        }
        
        /* Order Timeline */
        .order-timeline {
            margin-bottom: 30px;
        }
        
        .order-timeline h4 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1f2937;
            margin-bottom: 25px;
            font-size: 18px;
        }
        
        .timeline-steps {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        
        @media (max-width: 768px) {
            .timeline-steps {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            
            .timeline-connector {
                display: none !important;
            }
        }
        
        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 2;
            text-align: center;
            min-width: 80px;
        }
        
        .timeline-step.active .step-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
        }
        
        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s;
        }
        
        .step-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .step-time {
            font-size: 11px;
            color: #9ca3af;
        }
        
        .timeline-connector {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
            position: relative;
            top: -25px;
        }
        
        .timeline-connector.active {
            background: #3b82f6;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 30px;
        }
        
        @media (max-width: 640px) {
            .action-buttons {
                grid-template-columns: 1fr;
            }
        }
        
        .btn-print, .btn-track, .btn-view-orders {
            padding: 15px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-print {
            background: white;
            border: 2px solid #3b82f6;
            color: #3b82f6;
        }
        
        .btn-print:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-track {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
        }
        
        .btn-track:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }
        
        .btn-view-orders {
            background: #f3f4f6;
            border: 2px solid #d1d5db;
            color: #374151;
        }
        
        .btn-view-orders:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }
        
        /* What's Next Section */
        .next-steps {
            background: #f0f9ff;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .next-steps h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1f2937;
            margin-bottom: 25px;
            font-size: 20px;
        }
        
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        @media (max-width: 1024px) {
            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 640px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .step-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        
        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .step-card .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #dbeafe;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .step-card h4 {
            margin: 0 0 10px 0;
            color: #1f2937;
            font-size: 16px;
            font-weight: 600;
        }
        
        .step-card p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }
        
        /* Continue Shopping */
        .continue-shopping {
            text-align: center;
            padding-top: 30px;
            border-top: 2px solid #f3f4f6;
        }
        
        .btn-continue-shopping {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            padding: 16px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-continue-shopping:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.3);
        }
        
        .help-text {
            margin-top: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        
        .help-text a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .help-text a:hover {
            text-decoration: underline;
        }
        
        /* Icons */
        .icon-receipt::before { content: "🧾"; }
        .icon-cod::before { content: "💰"; }
        .icon-online::before { content: "💳"; }
        .icon-location::before { content: "📍"; }
        .icon-package::before { content: "📦"; }
        .icon-timeline::before { content: "⏳"; }
        .icon-print::before { content: "🖨️"; }
        .icon-track::before { content: "📍"; }
        .icon-orders::before { content: "📋"; }
        .icon-info::before { content: "ℹ️"; }
        .icon-cart::before { content: "🛒"; }
        
        /* Print Styles */
        @media print {
            .order-success-page {
                background: white;
                padding: 0;
            }
            
            .success-container {
                box-shadow: none;
                max-width: 100%;
            }
            
            .btn-print,
            .btn-track,
            .btn-view-orders,
            .btn-continue-shopping,
            .next-steps,
            .help-text {
                display: none !important;
            }
        }
    </style>
</div>