<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Type_Material;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Type_MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_material =Type_Material::all();
        return $type_material;
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
            'name'=> 'required|unique:type__materials'
        ]);
        if(!$validar ->fails()){
            $type_material = new Type_Material();
            
            $type_material->name = $request ->name;

            $type_material->save();

            return response()->json([
                'res'=> true,
                'mensaje' => 'tipo de material guardado' 
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
        $type_material = Type_Material::where('id',$id)
        ->first();
        if (isset($type_material)){
            return response()->json([
                'res'=> true,
                'type_material' => $type_material 
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
    public function update(Request $request, $id)
    {
        $validar= Validator::make($request->all(), [
            'name' => "required|unique:type__materials"
        ]);

        if(!$validar->fails()){
            $type_material = Type_Material::find($id);
            if(isset($type_material)){
                $type_material->name= $request->name;

                $type_material->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'tipo de material actualizado' 
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
        $type_material = Type_Material::find($id);
        if(isset($type_material)){
            $type_material->delete();
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
 