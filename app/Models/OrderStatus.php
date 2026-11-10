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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getMessageAttribute(): string
    {
        return match (app()->getLocale()) {
            'ar' => $this->ar_message,
            'fr' => $this->fr_message,
            default => $this->en_message,
        };
    }
}
