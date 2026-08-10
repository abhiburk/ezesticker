<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_transaction()
    {
        return $this->hasOne(OrderTransaction::class);
    }

    public function setCartConditionsAttribute($value)
    {
        $this->attributes['cart_conditions'] = json_encode(serialize($value));
    }

    public function getCartConditionsAttribute($value)
    {
        return unserialize(json_decode($value));
    }
}
