<?php

namespace App\Livewire\Site\Cart;

use Livewire\Component;
use App\Models\Cart;

class MiniCart extends Component
{
    
    public $open = false;

    protected $listeners = [
        'toggle-mini-cart' => 'toggle',
        'cart-updated' => 'refreshCart'
    ];

    public $items = [];

    public function mount()
    {
        $this->loadCart();
    }

    public function toggle()
    {
        $this->open = !$this->open;
        $this->loadCart();
    }

    public function refreshCart()
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
    }

    public function remove($id)
    {
        Cart::where('id', $id)->delete();
        $this->loadCart();
        $this->dispatch('cart-updated');
    }

    public function incrementQty($id)
{
    $cart = Cart::findOrFail($id);

    if ($cart->quantity >= $cart->product->stock_qty) {
        return; 
    }

    $cart->quantity += 1;
    $cart->save();

    $this->loadCart();
    $this->dispatch('cart-updated');
}

public function decrementQty($id)
{
    $cart = Cart::findOrFail($id);

    if ($cart->quantity <= 1) {
        return;
    }

    $cart->quantity -= 1;
    $cart->save();

    $this->loadCart();
    $this->dispatch('cart-updated');
}

    public function render()
    {
        return view('livewire.site.cart.mini-cart');
    }
}
