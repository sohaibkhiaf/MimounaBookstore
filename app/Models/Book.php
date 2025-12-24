<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'discount',
        'quantity',
        'image_url',
        'bestseller',
        'bookshelf',
        'genre_id',
    ];

    public function genre() : BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function likes() : HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function reviews() : HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public static function scopeFilter(Builder $query, array $filters) : Builder
    {
        return $query->when($filters['search'] ?? null , fn($query, $search) => $query->where('title' , 'like' , '%'.$search.'%'))
            ->when($filters['gid'] ?? null , fn($query, $gid) => $query->where('genre_id' , '=' , $gid));
    }

    protected static function booted()
    {
        static::deleting(function ($book) {
            // delete the image from storage if it exists
            if ($book->image_url && Storage::disk('public')->exists($book->image_url)) {
                Storage::disk('public')->delete($book->image_url);
            }
        });
    }

}
