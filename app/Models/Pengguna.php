<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'penggunas';

    protected $fillable = [
        'email', 'password', 'level',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->level === 'admin';
    }
}
