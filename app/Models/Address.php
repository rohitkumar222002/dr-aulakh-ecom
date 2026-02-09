<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
class Address extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'full_name',
        'phone',
        'pincode',
        'address_line1',
        'address_line2',
        'city',
        'state_id',
        'landmark',
        'is_default'
    ];

   

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Accessor for full address
    public function getFullAddressAttribute()
    {
        $address = $this->address_line1;
        if ($this->address_line2) {
            $address .= ', ' . $this->address_line2;
        }
        if ($this->landmark) {
            $address .= ', Near ' . $this->landmark;
        }
        $address .= ', ' . $this->city . ', ' . $this->state . ' - ' . $this->pincode;
        
        return $address;
    }

    // Scope for default address
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
   
public function state()
{
    return $this->belongsTo(State::class, 'state_id');
}

}

