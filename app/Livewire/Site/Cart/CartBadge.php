<?php
namespace App\Livewire\Site\Cart;

use Livewire\Component;
use App\Models\Cart;

class CartBadge extends Component
{
    protected $listeners = ['cart-updated' => 'updateCount'];

    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->count = Cart::where(function ($q) {
            if (auth()->check()) {
                $q->where('user_id', auth()->id());
            } else {
                $q->where('session_id', session()->getId());
            }
        })->sum('quantity');
    }

    public function render()
    {
        return view('livewire.site.cart.cart-badge');
    }
}
