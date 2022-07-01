<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $area =Area::all();
        return $area;
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
            'name'=> 'required|unique:areas'
        ]);
        if(!$validar ->fails()){
            $area = new Area();
            $area->name = $request ->name;
            $area->save();
            return response()->json([
                'res'=> true,
                'mensaje' => 'Area Guardada'
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'Error Area Duplicada'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $area = Area::where('id',$id)->get();

        return $area;

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
            'name' => "required|unique:areas"
        ]);

        if(!$validar->fails()){
            $area = Area::find($id);
            if(isset($area)){
                $area->name= $request->name;

                $area->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'Area Actualizada'
            ]);

            }else{
                return response()->json([
                    'res'=> false,
                    'mensaje' => 'Error al Actualizar'
                ]);
            }
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'Error Area Duplicada!'
            ]);
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
        $area = Area::find($id);
        if(isset($area)){
            $area->delete();
            return response()->json([
                'res'=> true,
                'mensaje' => 'Area Eliminada'
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'Error al Eliminar Area'
            ]);
        }
    }
}