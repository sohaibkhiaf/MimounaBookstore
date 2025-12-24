<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_name',
        'ar_name',
        'fr_name',
        'fa_icon',
    ];

    public function books() : HasMany
    {
        return $this->hasMany(Book::class);
    }
}
