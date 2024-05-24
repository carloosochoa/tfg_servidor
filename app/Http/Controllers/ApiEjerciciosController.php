<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\Ejercicios;
use App\Models\Musculos;
use App\Models\User;
use App\Models\Rutinas;
use App\Models\Ejercicios_Rutinas;

class ApiEjerciciosController extends Controller
{
    
    public function index()
    {
        $ejercicios = Ejercicios::select('ejercicios.id', 'ejercicios.name', 'ejercicios.description', 'ejercicios.equipment', 'musculos.name as primary_muscle_id', 'ejercicios.multimedia', 'ejercicios.created_at', 'ejercicios.updated_at')
        ->join('musculos', 'ejercicios.primary_muscle_id', '=', 'musculos.id')
        ->get();

        return response()->json($ejercicios);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $ejercicios = [];
        $data = json_decode($request->getContent());
        try{
            foreach($data as $ejercicio){
                $nuevoEjercicio = new Ejercicios();
                $nuevoEjercicio->name = $ejercicio->nombre;
                $nuevoEjercicio->description = $ejercicio->description;
                $nuevoEjercicio->equipment = $ejercicio->equipment;
                $nuevoEjercicio->primary_muscle_id = Musculos::where('name', $ejercicio->primary_muscle_id)->first()->id;
                $nuevoEjercicio->multimedia = $ejercicio->multimedia;
                $nuevoEjercicio->save(); 
                $ejercicios[] = $nuevoEjercicio;
                
                
            }
            return response()->json($ejercicios,201);

        }catch(Exception $e){
         return response()->json(['error'=>"fergetr"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rutina = Rutinas::where('id', $id)->first(); 
        if($rutina){
        Ejercicios_Rutinas::where('routine_id', $rutina->id)->delete();
        $rutina->delete();

        return response()->json(['message' => 'Rutina ' . $rutina->name .' eliminada'], 200);
        }
        else{
            return response()->json(['message' => 'La rutina no existe'], 404);
        }
    }

    public function crearMusculos(Request $request){
        $musculos = [];
        $data = json_decode($request->getContent());
        foreach ($data as $musculo) {
            $nuevoMusculo = new Musculos();
            $nuevoMusculo->name = $musculo;
            $nuevoMusculo->save(); 
            $musculos[] = $nuevoMusculo;
        }
        return response()->json($musculos,201);
        
    }
    public function nombreMusculos(){
        $musculos = Musculos::select('id', 'name')->get();
        return response()->json($musculos,201);
    }

    public function nombreEjercicios(){
        $ejercicios = Ejercicios::select('id', 'name')->get();
        return response()->json($ejercicios,201);
    }

    public function filtroEjerciciosMusculos($musculoId){
        $ejercicios = [];
        try {
          
            $ejercicios = Ejercicios::select('ejercicios.id', 'ejercicios.name', 'ejercicios.description', 'ejercicios.equipment', 'musculos.name as primary_muscle_id', 'ejercicios.multimedia', 'ejercicios.created_at', 'ejercicios.updated_at')
                ->join('musculos', 'ejercicios.primary_muscle_id', '=', 'musculos.id')
                ->where('ejercicios.primary_muscle_id', $musculoId)
                ->get();

            return response()->json($ejercicios,201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al filtrar los ejercicios por músculo.']);
        }
    }

    public function iniciarSesion(Request $request){
        if(!$request->has('name') || !$request->has('password')){
            return response()->json(['success' => false,'message' => 'Please, fill in all fields ']);

        }elseif (empty($request->name) || empty($request->password)) {
            return response()->json(['success' => false, 'message' => 'Por favor, rellena todos los campos'], 400);
        }

        $usuario = User::where('name', $request->name)->first();
    
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Not found']);
        }
    
        if (Hash::check($request->password, $usuario->password)){
            return response()->json(['success' => true, 'user_id' => $usuario->id]);
        } else {
            return response()->json(['success' => false, 'message' => 'Incorrect password']);
        }
    }
    

    public function crearUsuario(Request $request){
        if(!$request->has('name') || !$request->has('password')){
            return response()->json(['success' => false,'message' => 'Please, fill in all fields ']);

        }elseif (empty($request->name) || empty($request->password)) {
            return response()->json(['success' => false, 'message' => 'Por favor, rellena todos los campos'], 400);
        }
        
        $nuevoUsuario = new User();
        $nuevoUsuario->name = $request->name;

        $hashedPassword = Hash::make($request->password);
        $nuevoUsuario->password = $hashedPassword;

        $nuevoUsuario->save(); 

        return response()->json(['success'=> true, 'user_id' => $nuevoUsuario->id]);
    }


    public function crearRutinas(Request $request){
        if (!$request->has('user_id') || !$request->has('name') || !$request->has('exerciseName') || !$request->has('exerciseSets') || !$request->has('exerciseReps')) {
            return response()->json(['success' => false, 'message' => 'Por favor, asegúrate de enviar todos los campos necesarios'], 400);
        }
        
        elseif(empty($request->user_id) || empty($request->name) || empty($request->exerciseName) || empty($request->exerciseSets) || empty($request->exerciseReps)) {
            return response()->json(['success' => false, 'message' => 'Por favor, asegúrate de no dejar ningún campo vacío'], 400);
        }

        $user_id = $request->input('user_id');
        $name = $request->input('name');
        $ejercicioId = $request->input('exerciseName');
        $sets = $request->input('exerciseSets');
        $reps = $request->input('exerciseReps');

        $nuevaRutina = new Rutinas();
        $nuevaRutina->user_id = $user_id;
        $nuevaRutina->name = $name;
        $nuevaRutina->save();

        
        for($i=0; $i<count($ejercicioId); $i++){
            $nuevoEjercicioRutina = new Ejercicios_Rutinas();
            $nuevoEjercicioRutina->routine_id = $nuevaRutina->id;

            $lineaEjercicio = Ejercicios::find($ejercicioId[$i]);
            $nuevoEjercicioRutina->exercise_id = $lineaEjercicio->id;

            $nuevoEjercicioRutina->sets = $sets[$i];
            $nuevoEjercicioRutina->reps = $reps[$i];

            $nuevoEjercicioRutina->save();
        }

        return response()->json(['message' => 'Datos recibidos correctamente', 'user_id' => $user_id, 'name' => $name, 'EjerName' => $ejercicioId, 'Sets' => $sets, 'Reps' => $reps]);
    }

    public function contarRutinas($id){

        $usuario = User::find($id);
        if($usuario){
            $cantidadRutinas = $usuario->rutinas()->count();
            return response()->json($cantidadRutinas,201);
        }else{
            return response()->json(['error' => 'El usuario no existe.'],404);
        }
    }

    public function mostrarRutinas($id){
        $rutinas = Rutinas::where('user_id', $id)->get();
        $datos = [];

    
        foreach($rutinas as $rutina){
            $rutinas_ejercicios = Ejercicios_Rutinas::where('routine_id', $rutina->id)->get();

            $datos_ejercicios_rutina = [];
            
            foreach ($rutinas_ejercicios as $rutina_ejercicio) {        
                $ejercicio = Ejercicios::find($rutina_ejercicio->exercise_id);
                $musculo = Musculos::select('name')
                ->where('id',$ejercicio->primary_muscle_id)
                ->first();

                $datos_ejercicios_rutina[] = [
                    'nombre' => $ejercicio->name,
                    'imagen' => $ejercicio->multimedia,
                    'equipamiento' => $ejercicio->equipment,
                    'musculo' => $musculo->name,
                    'series' => $rutina_ejercicio->sets,
                    'repeticiones' => $rutina_ejercicio->reps,
                    'id_rutina' => $rutina->id
                ];
            }
            $datos[$rutina->name] = $datos_ejercicios_rutina;
        }
        return response()->json(['datos' => $datos,201]);
    }

}
