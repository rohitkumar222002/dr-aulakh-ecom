<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get cart items
        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $cartItems = Cart::with('product')
                ->where('session_id', session()->getId())
                ->get();
        }
        
        if ($cartItems->count() == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Get saved addresses if logged in
        $addresses = null;
        if (Auth::check()) {
            $addresses = Address::with('state')
                ->where('user_id', Auth::id())
                ->orderBy('is_default', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        // Get states for dropdown
        $states = State::orderBy('name')->get();
        
        return view('user.checkout.index', compact('cartItems', 'addresses', 'states'));
    }
    
    public function placeOrder(Request $request)
    {
        // Validate request
        $request->validate([
            'address_id' => 'nullable|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
            'coupon_code' => 'nullable|string'
        ]);
        
        // Get user
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }
        
        // Get cart items
        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();
            
        if ($cartItems->count() == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Check stock availability
        foreach ($cartItems as $item) {
            if (!$item->product) {
                return redirect()->back()->with('error', 'A product in your cart is no longer available.');
            }
            
            if ($item->product->stock_qty < $item->quantity) {
                return redirect()->back()->with('error', 
                    $item->product->name . ' has only ' . $item->product->stock_qty . ' items in stock.');
            }
        }
        
        // Handle address
        $address = null;
        if ($request->address_id) {
            // Use existing address
            $address = Address::where('id', $request->address_id)
                ->where('user_id', $user->id)
                ->first();
        } else {
            // Create new address
            $request->validate([
                'new_full_name' => 'required|min:3',
                'new_phone' => 'required|digits:10',
                'new_address_line1' => 'required|min:10',
                'new_city' => 'required',
                'new_state_id' => 'required|exists:states,id',
                'new_pincode' => 'required|digits:6',
            ]);
            
            $addressData = [
                'user_id' => $user->id,
                'full_name' => $request->new_full_name,
                'phone' => $request->new_phone,
                'address_line1' => $request->new_address_line1,
                'address_line2' => $request->new_address_line2,
                'city' => $request->new_city,
                'state_id' => $request->new_state_id,
                'pincode' => $request->new_pincode,
                'type' => 'home',
                'is_default' => !$user->addresses()->exists()
            ];
            
            $address = Address::create($addressData);
        }
        
        if (!$address) {
            return redirect()->back()->with('error', 'Please select or add a delivery address.');
        }
        
        // Calculate totals
        $subtotal = $cartItems->sum(fn($item) => $item->price_at_that_time * $item->quantity);
        $gstRate = 18; // 18% GST
        $tax = ($subtotal * $gstRate) / 100;
        $cgst = $tax / 2;
        $sgst = $tax / 2;
        $totalAmount = $subtotal + $tax;
        
        // Generate order number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        
        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'order_number' => $orderNumber,
            'total_amount' => $totalAmount,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'igst' => 0,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method == 'cod' ? 'pending' : 'unpaid',
            'order_status' => 'processing',
            'phone' => $address->phone,
        ]);
        
        // Create order items and update stock
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->price_at_that_time,
                'quantity' => $item->quantity,
                'total' => $item->price_at_that_time * $item->quantity,
            ]);
            
            // Update product stock
            $item->product->decrement('stock_qty', $item->quantity);
        }
        
        // Clear cart
        Cart::where('user_id', $user->id)->delete();
        
        // Redirect based on payment method
        if ($request->payment_method == 'cod') {
            return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully!');
        } else {
            // Handle online payment (Razorpay, etc.)
            return redirect()->route('payment.create-order', $order->id);
        }
    }
}