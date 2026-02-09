<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Helper: images array
    
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }
    
}
