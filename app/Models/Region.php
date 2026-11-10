<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'ar_name',
        'fr_name',
        'enabled',
        'stop_desk',
        'a_domicile',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getNameAttribute(): string
    {
        return app()->isLocale('ar') ? $this->ar_name : $this->fr_name;
    }
}
