<?php

namespace App\Livewire\Site\Order;

use Livewire\Component;
use App\Models\Order;
use NumberFormatter;

class OrderSuccess extends Component
{
    public $order;
    public $orderItems = [];
    
    public function mount($order)
    {
        $this->order = Order::with(['address', 'items.product'])
            ->where('id', $order)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        $this->orderItems = $this->order->items;
    }
    
    /**
     * Convert number to words (Indian Numbering System)
     */
    public function numberToWords($number)
    {
        $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
        $words = $formatter->format($number);
        return ucwords($words);
    }
    
    /**
     * Calculate tax percentage
     */
    public function getTaxPercentage($taxAmount, $taxableAmount)
    {
        if ($taxableAmount == 0) {
            return 0;
        }
        
        $percentage = ($taxAmount / $taxableAmount) * 100;
        return number_format($percentage, 2);
    }
    
    public function render()
    {
        return view('livewire.site.order.order-success');
    }
}