<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasUuids;

   protected $table = 'payments';

    protected $fillable = [
        'reservation_id',
        'flight_booking_id',
        'method',
        'amount',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($payment) {
            $payment->id = (string) Str::uuid();
        });
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function flightBooking(): BelongsTo
    {
        return $this->belongsTo(FlightBooking::class);
    }
}