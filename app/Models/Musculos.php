<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ejercicios;

class Musculos extends Model
{
    use HasFactory;
    public function ejercicios(){
        return $this->hasMany(Ejercicios::class);
    }
}
