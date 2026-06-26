<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ReviewImages extends Model
{
    //

    use HasUuids;

    protected $table='review_images';
    protected $fillable = [
        'review_id',
        'path'
    ];
}
