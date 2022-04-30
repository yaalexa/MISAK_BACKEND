<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Educational_Level;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Educational_LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educational_level =Educational_Level::all();
        return $educational_level;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validar= Validator::make($request->all(), [
            'name'=> 'required|unique:educational_levels'
        ]);
        if(!$validar ->fails()){
            $educational_level = new Educational_Level();
            
            $educational_level->name = $request ->name;

            $educational_level->save();

            return response()->json([
                'res'=> true,
                'mensaje' => 'Nivel de educacion creado' 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'error entrada duplicada' 
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $educational_level = Educational_level::where('id',$id)
        ->first();
        if (isset($educational_level)){
            return response()->json([
                'res'=> true,
                '$educational_level' => $educational_level 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'registro no encontrado' 
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validar= Validator::make($request->all(), [
            'name' => "required|unique:educational_levels"
        ]);

        if(!$validar->fails()){
            $educational_level = Educational_level::find($id);
            if(isset($educational_level)){
                $educational_level->name= $request->name;

                $educational_level->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'Nivel de educacion actualizado' 
            ]);

            }else{
                return response()->json([
                    'res'=> false,
                    'mensaje' => 'error al actualizar'
                ]);
            }
        }else{
            return "entrada duplicada";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $educational_level = Educational_level::find($id);
        if(isset($educational_level)){
            $educational_level->delete();
            return response()->json([
                'res'=> true,
                'mensaje' => 'exito al elimar'
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'falla al elimar no se encontro registro'
            ]);
        }
    }
}
