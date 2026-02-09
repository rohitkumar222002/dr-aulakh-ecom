<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'short_description',
        'price',
        'mrp',
        'discount_price',
        'stock_qty',
        'badge',
        'rating_avg',
        'rating_count',
        'primary_image',
        'images',
        'is_active',
    ];

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
