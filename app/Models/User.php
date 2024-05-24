<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Rutinas;

class User extends Authenticatable
{
    use HasFactory;
    public function rutinas()
    {
        return $this->hasMany(Rutinas::class, 'user_id');
    }
}
