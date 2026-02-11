<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Get cart items based on auth or session
        if (auth()->check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();
        } else {
            $cartItems = Cart::with('product')
                ->where('session_id', session()->getId())
                ->get();
        }
        
        return view('user.cart.index', compact('cartItems'));
    }
    public function validateCart()
{
    $cartItems = Cart::with('product')
        ->where('user_id', auth()->id())
        ->get();

    foreach ($cartItems as $item) {

        if (!$item->product) {
            return response()->json([
                'success' => false,
                'message' => 'A product in your cart no longer exists.'
            ]);
        }

        if ($item->quantity > $item->product->stock_qty) {
            return response()->json([
                'success' => false,
                'message' => $item->product->name . 
                             ' only has ' . 
                             $item->product->stock_qty . 
                             ' items in stock.'
            ]);
        }
    }

    return response()->json(['success' => true]);
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem = Cart::findOrFail($id);
        
        // Check product exists and has stock
        if ($cartItem->product) {
            if ($cartItem->product->stock_qty < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $cartItem->product->stock_qty . ' items available in stock'
                ]);
            }
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully'
        ]);
    }
    
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }
    
    public function clear()
    {
        if (auth()->check()) {
            Cart::where('user_id', auth()->id())->delete();
        } else {
            Cart::where('session_id', session()->getId())->delete();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
    
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);
        
        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
            
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code'
            ]);
        }
        
        // Store coupon in session for checkout
        session(['applied_coupon' => [
            'code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value
        ]]);
        
        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully',
            'discount' => $coupon->discount_value
        ]);
    }
}