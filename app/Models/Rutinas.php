<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ejercicios_Rutinas;


class Rutinas extends Model
{
    use HasFactory;

    protected $table = 'rutinas';
    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ejercicios_rutinas(){
        return $this->hasMany(Ejercicios_Rutinas::class, 'routine_id');
    }
}

