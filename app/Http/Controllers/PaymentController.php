<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Create Razorpay Order
     */
    public function createOrder(Request $request)
    {
        try {
            Log::info('Create Order Request:', $request->all());

            $request->validate([
                'amount' => 'required|numeric|min:1',
                'order_number' => 'required|string',
                'order_id' => 'required|numeric'
            ]);

            // Find the order
            $order = Order::find($request->order_id);
            
            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            // Check if order is already paid
            if ($order->payment_status === 'paid') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order already paid'
                ], 400);
            }

            // Initialize Razorpay
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            // Create Razorpay order
            $razorpayOrder = $api->order->create([
                'receipt' => $order->order_number,
                'amount' => $request->amount, // Amount in paise
                'currency' => 'INR',
                'payment_capture' => 1 // Auto capture
            ]);

            Log::info('Razorpay Order Created:', [
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $razorpayOrder->amount,
                'currency' => $razorpayOrder->currency
            ]);

            // Update order with Razorpay order ID
            $order->update([
                'razorpay_order_id' => $razorpayOrder->id
            ]);

            return response()->json([
                'status' => 'success',
                'order_id' => $razorpayOrder->id,
                'amount' => $razorpayOrder->amount,
                'currency' => $razorpayOrder->currency
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment initialization failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify Payment Webhook
     */
    public function verifyPayment(Request $request)
    {
        try {
            Log::info('Payment Verification Request:', $request->all());

            $request->validate([
                'razorpay_payment_id' => 'required|string',
                'razorpay_order_id' => 'required|string',
                'razorpay_signature' => 'required|string'
            ]);

            // Verify signature
            $generatedSignature = hash_hmac(
                'sha256',
                $request->razorpay_order_id . "|" . $request->razorpay_payment_id,
                config('services.razorpay.secret')
            );

            if ($generatedSignature !== $request->razorpay_signature) {
                Log::error('Signature Mismatch:', [
                    'generated' => $generatedSignature,
                    'received' => $request->razorpay_signature
                ]);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid signature'
                ], 400);
            }

            // Find order by Razorpay order ID
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();
            
            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            // Update order payment status
            DB::transaction(function () use ($order, $request) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                    'paid_at' => now()
                ]);

                // Update stock
                foreach ($order->items as $item) {
                    $item->product->decrement('stock_qty', $item->quantity);
                }
            });

            Log::info('Payment Verified Successfully:', [
                'order_id' => $order->id,
                'payment_id' => $request->razorpay_payment_id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment verified successfully',
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            Log::error('Payment Verification Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed'
            ], 500);
        }
    }

    /**
     * Handle Razorpay Webhook
     */
    public function handleWebhook(Request $request)
    {
        try {
            Log::info('Razorpay Webhook Received:', $request->all());

            $webhookBody = $request->getContent();
            $webhookSignature = $request->header('X-Razorpay-Signature');
            
            $expectedSignature = hash_hmac(
                'sha256',
                $webhookBody,
                config('services.razorpay.webhook_secret')
            );

            if ($webhookSignature !== $expectedSignature) {
                Log::error('Webhook signature mismatch');
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $event = $request->input('event');
            $payload = $request->input('payload');

            switch ($event) {
                case 'payment.captured':
                    // Handle successful payment
                    $payment = $payload['payment']['entity'];
                    $this->handleSuccessfulPayment($payment);
                    break;
                    
                case 'payment.failed':
                    // Handle failed payment
                    $payment = $payload['payment']['entity'];
                    $this->handleFailedPayment($payment);
                    break;
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    private function handleSuccessfulPayment($payment)
    {
        $order = Order::where('razorpay_order_id', $payment['order_id'])->first();
        
        if ($order && $order->payment_status !== 'paid') {
            DB::transaction(function () use ($order, $payment) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_id' => $payment['id'],
                    'paid_at' => now()
                ]);
            });
        }
    }

    private function handleFailedPayment($payment)
    {
        $order = Order::where('razorpay_order_id', $payment['order_id'])->first();
        
        if ($order) {
            $order->update([
                'payment_status' => 'failed',
                'payment_error' => $payment['error_description'] ?? 'Payment failed'
            ]);
        }
    }
}