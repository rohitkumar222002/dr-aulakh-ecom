<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
protected $fillable = [
    'user_id',
    'from_user_id',
    'level',
    'order_id',
    'amount',
    'trx_id',
    'trx_type',
    'tax',
    'note'
];
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function fromUser()
{
    return $this->belongsTo(User::class, 'from_user_id');
}

}
