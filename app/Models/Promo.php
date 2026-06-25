<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Promo extends Model
{
    use HasFactory;
    use HasUuids;

    // protected $keyType = 'string';
    // public $incrementing = false;

    protected $table = 'promos';
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_purchase',
        'quota',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($promo) {
            $promo->id = (string) Str::uuid();
        });
    }

    // Hubungan ke tabel reservations (hasMany)
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}