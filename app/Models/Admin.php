<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //

    use HasUuids;

    protected $table = 'admins';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    }
