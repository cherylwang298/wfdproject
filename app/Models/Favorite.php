<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Favorite extends Model
{
    use HasUuids;

    protected $table = 'favorites';


    protected $fillable = [
        'property_id', 
        'user_id',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($favorite) {
            $favorite->id = (string) Str::uuid();
        });
    }


}