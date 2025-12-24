<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_message',
        'ar_message',
        'fr_message',
    ];

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }
}
