<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'flight_id', // Disimpan sebagai referensi UUID ke API Flights
        'flight_booking_id',
        'passenger_id',
        'seat_number',
        'seat_type',
        'price',
    ];

    protected static function booted()
    {
        static::creating(function ($ticket) {
            $ticket->id = (string) Str::uuid();
        });
    }

    public function flightBooking(): BelongsTo
    {
        return $this->belongsTo(FlightBooking::class);
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(Passenger::class);
    }
}