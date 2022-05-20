<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\material_educational_level;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Material_EducationalController extends Controller
{
    public function index()
    {
        $material_educational = Material_educational::all();
        return $material_educational;
    }
    public function store(Request $request)
    {
        $validar= Validator::make($request->all(), [
            'material_id'=> 'required',
            'educational_level_id'=> 'required'
        ]);
        if(!$validar ->fails()){
            $material_educational = new Material_educational();

            $material_educational->educational_level_id = $request ->educational_level_id;
            $material_educational->material_id = $request ->material_id;

            $material_educational->save();

            return response()->json([
                'res'=> true,
                'mensaje' => 'Guardado con exito' 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'error entrada duplicada' 
            ]);
        }
    }

    public function show($id)
    {
        $material_educational = Material_educational::where('id',$id)
        ->first();
        if (isset($material_educational)){
            return response()->json([
                'res'=> true,
                'material_educational' => $material_educational 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'registro no encontrado' 
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $validar= Validator::make($request->all(), [
            'material_id'=> 'required',
            'educational_level_id'=> 'required'
        ]);

        if(!$validar->fails()){
            $material_educational = Material_educational::find($id);
            if(isset($material_educational)){
                $material_educational->educational_level_id= $request->educational_level_id;
                $material_educational->material_id= $request->material_id;

                $material_educational->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'Se actualizado el registro' 
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

    public function destroy($id)
    {
        $material_educational = Material_educational::find($id);
        if(isset($material_educational)){
            $material_educational->delete();
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