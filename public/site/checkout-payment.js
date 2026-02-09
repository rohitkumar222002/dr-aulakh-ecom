// Checkout Payment JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Razorpay integration
    window.initiateRazorpayPayment = function(data) {
        console.log('Initiating Razorpay payment for order:', data);
        
        // Show loading
        showPaymentLoading('Creating payment order...');
        
        // Create Razorpay order via backend
        route("{{ route('payment.create-order') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                amount: data.amount,
                order_id: data.order_id,
                order_number: data.order_number
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(razorpayOrder => {
            hidePaymentLoading();
            
            if (razorpayOrder.error) {
                alert('Error: ' + razorpayOrder.error);
                return;
            }
            
            // Razorpay options
            const options = {
                key: razorpayOrder.key || "{{ config('services.razorpay.key') }}",
                amount: razorpayOrder.amount, // Already in paise
                currency: razorpayOrder.currency || 'INR',
                order_id: razorpayOrder.order_id,
                name: data.name || "{{ get_setting('company_name') ?? config('app.name') }}",
                description: `Payment for Order #${data.order_number}`,
                handler: function (response) {
                    verifyPayment(response, data.order_id);
                },
                prefill: {
                    name: data.user_name || '',
                    email: data.user_email || '',
                    contact: data.user_phone || ''
                },
                theme: {
                    color: '#F37254'
                },
                modal: {
                    ondismiss: function() {
                        hidePaymentLoading();
                        // Optionally show retry option
                        if (confirm('Payment cancelled. Do you want to try again?')) {
                            initiateRazorpayPayment(data);
                        }
                    }
                },
                notes: {
                    order_id: data.order_id,
                    order_number: data.order_number
                }
            };
            
            // Create Razorpay instance
            const rzp = new Razorpay(options);
            
            // Handle payment failure
            rzp.on('payment.failed', function(response) {
                hidePaymentLoading();
                console.error('Payment failed:', response.error);
                
                // Show error message
                let errorMsg = 'Payment failed. ';
                if (response.error.description) {
                    errorMsg += response.error.description;
                }
                
                alert(errorMsg);
                
                // Update order status to failed
                updateOrderStatus(data.order_id, 'failed', response.error);
            });
            
            // Open Razorpay checkout
            rzp.open();
            
        })
        .catch(error => {
            hidePaymentLoading();
            console.error('Error:', error);
            alert('Failed to initiate payment. Please try again.');
        });
    };
    
    // Verify payment after successful transaction
    window.verifyPayment = function(response, orderId) {
        showPaymentLoading('Verifying payment...');
        
        route("{{ route('payment.verify') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                razorpay_signature: response.razorpay_signature,
                order_id: orderId
            })
        })
        .then(response => response.json())
        .then(data => {
            hidePaymentLoading();
            
            if (data.status === 'success') {
                // Payment successful - redirect to success page
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    window.location.href = "{{ route('order.success', '') }}/" + orderId;
                }
            } else {
                alert('Payment verification failed: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            hidePaymentLoading();
            console.error('Verification error:', error);
            alert('Payment verification failed. Please contact support.');
        });
    };
    
    // Update order status (for failed/cancelled payments)
    window.updateOrderStatus = function(orderId, status, error = null) {
        route("{{ route('payment.update-status') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                order_id: orderId,
                status: status,
                error: error
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Order status updated:', data);
        })
        .catch(error => {
            console.error('Failed to update order status:', error);
        });
    };
    
    // Show loading overlay
    window.showPaymentLoading = function(message = 'Processing...') {
        let overlay = document.getElementById('payment-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'payment-overlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 99999;
                backdrop-filter: blur(2px);
            `;
            document.body.appendChild(overlay);
        }
        
        overlay.innerHTML = `
            <div style="
                background: white;
                padding: 30px;
                border-radius: 12px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                min-width: 300px;
            ">
                <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4 style="margin-bottom: 10px;">${message}</h4>
                <p style="color: #666; margin: 0;">Please wait, do not refresh the page.</p>
            </div>
        `;
    };
    
    // Hide loading overlay
    window.hidePaymentLoading = function() {
        const overlay = document.getElementById('payment-overlay');
        if (overlay) {
            overlay.remove();
        }
    };
    
    // Livewire event listener for initiating payment
    window.addEventListener('initiate-razorpay', event => {
        console.log('Received payment initiation event:', event.detail);
        window.initiateRazorpayPayment(event.detail);
    });
    
    // Add CSS for spinner if not already present
    if (!document.querySelector('#payment-spinner-style')) {
        const style = document.createElement('style');
        style.id = 'payment-spinner-style';
        style.textContent = `
            .spinner-border {
                display: inline-block;
                width: 2rem;
                height: 2rem;
                vertical-align: text-bottom;
                border: 0.25em solid currentColor;
                border-right-color: transparent;
                border-radius: 50%;
                animation: spinner-border .75s linear infinite;
            }
            
            @keyframes spinner-border {
                to { transform: rotate(360deg); }
            }
            
            .visually-hidden {
                position: absolute !important;
                width: 1px !important;
                height: 1px !important;
                padding: 0 !important;
                margin: -1px !important;
                overflow: hidden !important;
                clip: rect(0,0,0,0) !important;
                white-space: nowrap !important;
                border: 0 !important;
            }
        `;
        document.head.appendChild(style);
    }
});