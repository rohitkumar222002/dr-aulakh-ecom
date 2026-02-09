<?php

namespace App\Livewire\Site\Cart;

use Livewire\Component;
use App\Models\Cart;

class CartPage extends Component
{
    public $items = [];
    public $totalAmount = 0;
    public $totalItems = 0;
    public $showDeleteConfirm = false;
    public $itemToDelete = null;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->items = Cart::where(function ($q) {
            if (auth()->check()) {
                $q->where('user_id', auth()->id());
            } else {
                $q->where('session_id', session()->getId());
            }
        })
        ->with('product')
        ->get();

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->totalItems = $this->items->sum('quantity');
        $this->totalAmount = $this->items->sum(fn($item) => $item->price_at_that_time * $item->quantity);
    }

    public function incrementQty($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->quantity < $cart->product->stock_qty) {
            $cart->quantity++;
            $cart->save();
            $this->dispatch('show-toast', type: 'success', message: 'Quantity updated');
        } else {
            $this->dispatch('show-toast', type: 'error', message: 'Maximum stock limit reached');
        }

        $this->loadCart();
        $this->dispatch('cart-updated');
    }

    public function decrementQty($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->quantity > 1) {
            $cart->quantity--;
            $cart->save();
            $this->dispatch('show-toast', type: 'success', message: 'Quantity updated');
        }

        $this->loadCart();
        $this->dispatch('cart-updated');
    }

    public function confirmRemove($id)
    {
        $this->itemToDelete = $id;
        $this->showDeleteConfirm = true;
    }

    public function remove()
    {
        Cart::where('id', $this->itemToDelete)->delete();
        $this->showDeleteConfirm = false;
        $this->itemToDelete = null;
        $this->dispatch('show-toast', type: 'success', message: 'Item removed from cart');
        $this->loadCart();
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        Cart::where(function ($q) {
            if (auth()->check()) {
                $q->where('user_id', auth()->id());
            } else {
                $q->where('session_id', session()->getId());
            }
        })->delete();
        
        $this->dispatch('show-toast', type: 'success', message: 'Cart cleared successfully');
        $this->loadCart();
        $this->dispatch('cart-updated');
    }
        public function saveForLater($id)
        {
            $cart = Cart::findOrFail($id);

            $cart->is_saved_for_later = 1;
            $cart->save();

            $this->dispatch('show-toast', type: 'success', message: 'Saved for Later');
            $this->loadCart();
        }
        public function applyCoupon()
    {
        if ($this->coupon === 'SAVE10') {
            $this->discount = $this->totalAmount * 0.10;
            $this->dispatch('show-toast', type: 'success', message: '10% discount applied!');
        } else {
            $this->discount = 0;
            $this->dispatch('show-toast', type: 'error', message: 'Invalid coupon code');
        }
    }

    public function render()
    {
        return view('livewire.site.cart.cart-page');
    }
}