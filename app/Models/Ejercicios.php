<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Musculos;
use App\Models\Ejercicios_Rutinas;

class Ejercicios extends Model
{
    use HasFactory;

    protected $table = 'ejercicios';
    public function musculos(){
        return $this->belongsTo(Musculos::class);
    }

    public function ejercicios_rutinas(){
        return $this->hasMany(Ejercicios_Rutinas::class, 'exercise_id');
    }
}
