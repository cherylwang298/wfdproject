<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class FlightBooking extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'booking_code',
        'payment_status',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->id = (string) Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan ke tiket-tiket penumpang di dalam booking ini (hasMany)
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Hubungan ke pusat pembayaran payments (hasOne)
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function cancel_request()
    {
        // Pastikan nama kolom foreign key di tabel cancel_requests kamu adalah 'flight_booking_id'
        return $this->hasOne(CancelRequest::class, 'flight_booking_id');
    }
}