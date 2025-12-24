<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'subtotal',
        'shipping',
        'total',
        'shipping_region',
        'shipping_address',
        'shipping_type',
        'shipping_name',
        'shipping_phone',
        'user_id',
        'order_status_id',
    ];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus() : BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
