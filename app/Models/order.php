<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'first_name', 'last_name', 'email',
        'phone', 'street', 'city', 'state', 'zip', 'country',
        'shipping_method', 'shipping_cost', 'payment_method',
        'subtotal', 'tax', 'total', 'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
