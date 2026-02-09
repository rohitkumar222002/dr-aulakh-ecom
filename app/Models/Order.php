<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    

    // Accessor for formatted order number
    public function getFormattedOrderNumberAttribute()
    {
        return '#' . $this->order_number;
    }

    // Accessor for delivery address (through address relationship)
    public function getDeliveryAddressAttribute()
    {
        if ($this->address) {
            return $this->address->full_address;
        }
        return null;
    }
}

