<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiEjerciciosController;


Route::get('/mostrar_ejercicios', [ApiEjerciciosController::class, 'index']);
Route::post('/crear_ejercicios', [ApiEjerciciosController::class, 'store']);
Route::post('/crear_musculos', [ApiEjerciciosController::class, 'crearMusculos']);
Route::post('/iniciar_sesion', [ApiEjerciciosController::class, 'iniciarSesion']);
Route::post('/crear_usuario', [ApiEjerciciosController::class, 'crearUsuario']);
Route::get('/nombre_musculos', [ApiEjerciciosController::class,'nombreMusculos']);
Route::get('/nombre_ejercicios', [ApiEjerciciosController::class,'nombreEjercicios']);
Route::get('/filtro_ejercicios_musculos/{musculoId}', [ApiEjerciciosController::class, 'filtroEjerciciosMusculos']);
Route::post('/crear_rutinas', [ApiEjerciciosController::class, 'crearRutinas']);
Route::get('/contar_rutinas/{id}', [ApiEjerciciosController::class, 'contarRutinas']);
Route::get('/mostrar_rutinas/{id}', [ApiEjerciciosController::class, 'mostrarRutinas']);
Route::delete('borrar_rutina/{id}', [ApiEjerciciosController::class, 'destroy']);

