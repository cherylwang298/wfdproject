<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Passenger extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'phone_number',
        'nik',
        'passport_number',
    ];

    protected static function booted()
    {
        static::creating(function ($passenger) {
            $passenger->id = (string) Str::uuid();
        });
    }

    // Hubungan ke tabel tickets (hasMany)
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}