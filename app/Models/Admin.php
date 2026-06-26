<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Foundation\Auth\User as Authenticatable; 


class Admin extends Authenticatable 
{
    use HasUuids;

    protected $table = 'admins';
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Sembunyikan password jika data model diubah ke array/JSON
    protected $hidden = [
        'password',
    ];
}