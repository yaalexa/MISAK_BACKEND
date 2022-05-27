<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\material_educational_level;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Material_EducationalController extends Controller
{
    public function index()
    {
        $material_educational = Material_Educational_level::all();
        return $material_educational;
    }
    public function store(Request $request)
    {
        $validar= Validator::make($request->all(), [
            'material_id'=> 'required',
            'educational_level_id'=> 'required'
        ]);
        if(!$validar ->fails()){
            $material_educational = new Material_Educational_level();

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
        $material_educational = DB::table('educational_levels')
        ->join('material__educational_levels','material__educational_levels.educational_level_id','=','educational_levels.id')
        ->where('material__educational_levels.material_id','=',$id)
        ->select('material__educational_levels.id','educational_levels.name')
        ->get();
        return $material_educational;
    }
    public function update(Request $request, $id)
    {
        $validar= Validator::make($request->all(), [
            'material_id'=> 'required',
            'educational_level_id'=> 'required'
        ]);

        if(!$validar->fails()){
            $material_educational = Material_Educational_level::find($id);
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
        $material_educational = Material_Educational_level::find($id);
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