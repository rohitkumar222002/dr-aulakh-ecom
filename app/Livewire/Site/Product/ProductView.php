<?php

namespace App\Livewire\Site\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Product;

class ProductView extends Component
{
    public $product;
    public $selectedImage;
    public $latestProducts;
    public $quantity = 1;

    public function mount($slug)
    {
        // Get main product
        $this->product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Set selected image
        $this->selectedImage = $this->product->primary_image;

        // Get latest products (excluding current product)
        $this->latestProducts = Product::with('category')
            ->where('id', '!=', $this->product->id)
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();
    }

    public function selectImage($image)
    {
        $this->selectedImage = $image;
    }

  

    public function addToWishlist()
    {
        // Wishlist logic here
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Added to wishlist!'
        ]);
    }

    public function buyNow()
    {
        $this->addToCart();
        return redirect()->route('cart');
    }

    public function render()
    {
        return view('livewire.site.product.product-view');
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