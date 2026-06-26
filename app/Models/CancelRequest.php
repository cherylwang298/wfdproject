<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CancelRequest extends Model
{
    //

    use HasUuids;
    
    protected $table = 'cancel_requests';

    protected $fillable = [
        'reservation_id',
        'flight_booking_id',
        'reason',
        'status',
    ];

}
