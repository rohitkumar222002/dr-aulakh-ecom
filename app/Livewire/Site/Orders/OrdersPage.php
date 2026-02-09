<?php

namespace App\Livewire\Site\Orders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Contracts\View\View;

class OrdersPage extends Component
{
    use WithPagination;
    
    public $search = '';
    public $status = '';

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    }

    public function getOrdersProperty()
    {
        return Order::query()
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_number', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhereHas('address', function ($addressQuery) {
                          $addressQuery->where('full_name', 'like', '%' . $this->search . '%')
                                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->status && $this->status !== 'all', function ($query) {
                $query->where('order_status', $this->status);
            })
            ->with(['items.product', 'address'])
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.site.orders.orders-page', [
            'orders' => $this->orders
        ]);
    }
}