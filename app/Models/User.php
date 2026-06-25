<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuids, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'profile_picture',
        'password',
    ];
}
