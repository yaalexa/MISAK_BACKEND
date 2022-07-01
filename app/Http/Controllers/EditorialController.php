<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use App\Models\Editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editorial = Editorial::all();
        return $editorial;
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
            'name'=> 'required|unique:editorials'
        ]);
        if(!$validar ->fails()){
            $editorial = new Editorial();
            
            $editorial->name = $request ->name;

            $editorial->save();

            return response()->json([
                'res'=> true,
                'mensaje' => 'Editorial Guardada' 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'Error Editorial Duplicada' 
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
        $editorial = Editorial::where('id',$id)
        ->first();
        if (isset($editorial)){
            return response()->json([
                'res'=> true,
                'editorial' => $editorial 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'Registro No Encontrado' 
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
            'name' => "required"
        ]);

        if(!$validar->fails()){
            $editorial = Editorial::find($id);
            if(isset($editorial)){
                $editorial->name= $request->name;

                $editorial->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'Editorial Actualizada' 
            ]);

            }else{
                return response()->json([
                    'res'=> false,
                    'mensaje' => 'Error al Actualizar'
                ]);
            }
        }else{
            return "Entrada Duplicada";

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $editorial = Editorial::find($id);
        if(isset($editorial)){
            $editorial->delete();
            return response()->json([
                'res'=> true,
                'mensaje' => 'Eliminar Editorial'
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'Falla al Eliminar Editorial'
            ]);
        }
    }
}
