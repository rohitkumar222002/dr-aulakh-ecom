<?php

namespace App\Livewire\Site\Home;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Slider\Slider;
use Livewire\Component;

class SiteIndex extends Component
{
    public function render()
    {
        $products = Product::with('category')->latest()->take(12)->get();
    $sliders = Slider::where('status', 1)->latest()->get();
        return view('livewire.site.home.site-index', compact('products','sliders'));
    }
public function addToCart($productId)
{
    $product = Product::findOrFail($productId);

    $identifier = auth()->check()
        ? ['user_id' => auth()->id()]
        : ['session_id' => session()->getId()];

    $cart = Cart::firstOrCreate(
        array_merge($identifier, ['product_id' => $productId]),
        ['quantity' => 0]
    );

    $cart->quantity += 1;
    $cart->price_at_that_time = $product->discount_price ?? $product->price;
    $cart->save();

    $this->dispatch('cart-updated');
    $this->dispatch('toast', 'Added to cart!');

}
}
 