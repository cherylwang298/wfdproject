<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ClaimedPromo extends Model
{
    //

    use HasUuids;

    protected $table = 'claimed_promos';
    protected $fillable = [
        'user_id',
        'promo_id',
        'status'
    ];
}
