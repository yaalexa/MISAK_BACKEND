<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material_User;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
class Material_UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $material_user = Material_User::all();
        return $material_user;
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
            'manejo_users' => 'required',
            //////////////////////////////////////////////////////////////////
            // recordar que es campo detalle material es el manejo del material
            'detalle_material' => 'required',
            'date_download' => 'required',
            'material_id' => 'required',
            'users_id' => 'required'
        ]); 
        if(!$validar ->fails()){
            $material_user = new Material_User();
            
            $material_user->manejo_users = $request ->manejo_users;
            $material_user->detalle_material = $request ->detalle_material;
            $material_user->date_download = $request ->date_download;
            $material_user->material_id = $request ->material_id;
            $material_user->users_id = $request ->users_id;
 
            $material_user->save();

            return response()->json([
                'res'=> true,
                'mensaje' => 'registro guardado' 
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
        $material_user = Material_User::where('id',$id)
        ->first();
        if (isset($material_user)){
            return response()->json([
                'res'=> true,
                'material' => $material_user
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
            'manejo_users' => 'required',
            'detalle_material' => 'required',
            'date_download' => 'required',
            'material_id' => 'required',
            'users_id' => 'required'
        ]);

        if(!$validar->fails()){
            $material_user = Material_User::find($id);
            if(isset($material_user)){
                $material_user->manejo_users = $request ->manejo_users;
                $material_user->detalle_material = $request ->detalle_material;
                $date = Carbon::now();
                $material_user->date_download = $date->format('Y-m-d H:i:s');
                $material_user->material_id = $request ->material_id;
                $material_user->users_id = $request ->users_id;

                $material->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'material actualizado' 
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
        $material_user = Material_User::find($id);
        if(isset($material_user)){
            $material_user->delete();
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
    public function visualizacion (){
        $visualizacion=DB::table('material__users')
        ->select('material__users.material_id as id','material__users.detalle_material','materials.name','materials.img', DB::raw('COUNT(material__users.material_id) as conteo'))
        ->join('materials','material__users.material_id','=','materials.id')
        ->where('material__users.detalle_material','=','visualizado')
        ->groupBy('material__users.material_id','material__users.detalle_material','materials.name','materials.img')
        ->orderBy('conteo','desc')
        ->take(5)
        ->get();
        
        return $visualizacion;
    }
    public function descarga (){
        $visualizacion=DB::table('material__users')
        ->select('material__users.material_id as id','material__users.detalle_material','materials.name','materials.img', DB::raw('COUNT(material__users.material_id) as conteo'))
        ->join('materials','material__users.material_id','=','materials.id')
        ->where('material__users.detalle_material','=','descargado')
        ->groupBy('material__users.material_id','material__users.detalle_material','materials.name','materials.img')
        ->orderBy('conteo','desc')
        ->take(5)
        ->get();
        
        return $visualizacion;
    }
    
    
}
