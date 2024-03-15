<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends   Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'username',


    ];
    protected $hidden = [
        'password',
        'remember_token',

    ];

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }
}
