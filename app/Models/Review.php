<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Review extends Model
{
    use HasUuids;

    protected $table = 'reviews';
   
    protected $fillable = [
        'user_id',
        'property_id',
        'rating',
        'comment',
        'reservation_id'
    ];

    protected static function booted()
    {
        static::creating(function ($review) {
            $review->id = (string) Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}