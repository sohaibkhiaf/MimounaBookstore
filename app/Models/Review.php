<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review',
        'user_id',
        'book_id',
        'published',
        'edited',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function upvotes(): HasMany
    {
        return $this->hasMany(Upvote::class);
    }

    public function scopeWithUpvotesData(Builder $query): Builder
    {
        return $query->withCount('upvotes')
            ->withCount(['upvotes as upvoted' => fn ($q) => $q->where('user_id', auth()->id() ?? -1)]);
    }

    public function scopeTop(Builder $query, int $records): Builder
    {
        return $query->limit($records)->orderBy('upvotes_count', 'desc');
    }
}
