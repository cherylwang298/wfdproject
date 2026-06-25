<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasUuids;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'unit_id',
        'check_in',
        'check_out',
        'total_price',
        'guest_name',
        'guest_email',
        'guest_phone_number',
        'status',
        'payment_status',
        'promo_id',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($reservation) {
            $reservation->id = (string) Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    // Hubungan ke pusat pembayaran payments (hasOne)
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}