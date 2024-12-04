<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'shipping_fee',
        'final_total',
        // 'shipping_address_id',
        // 'billing_address_id',
        'shipping_method',
        'payment_status',
        'payment_method',
        'transaction_id',
        'currency',
        'notes',
        'promo_code',
        'tracking_number',
        'shipped_at',
        'delivered_at',
        'canceled_at',
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
