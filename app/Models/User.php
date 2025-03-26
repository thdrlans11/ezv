<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'sid';

    protected $hidden = [
        'sid'
    ];

    protected $guarded = [
        'sid'
    ];

    protected $casts = [
        'access' => 'object',
    ];

    public function event(){
        return $this->hasOne(Event::class, 'sid', 'esid');
    }
}
