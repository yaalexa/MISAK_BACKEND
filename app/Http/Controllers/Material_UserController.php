<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material_User;
use App\Models\Material;
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
            $material_user->material_id = $request ->material_id;
            $material_user->users_id = $request ->users_id;
            $date = Carbon::now();
            $material_user->date_download = $date->format('Y-m-d H:i:s');
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
        $visualizacion1 = Material::select(
            'materials.id as id',
            'materials.name as nombre',
            'materials.priority AS prioridad',
            'editorials.name AS editorial',
            'areas.name AS area',
            'type__materials.name AS tipo_material',
            'materials.img AS imagen',
            'a.autores AS autor',
            't.nivel AS nivel_educativo',
            DB::raw('COUNT(material_id) as conteo')
        )
            ->leftjoin('areas', 'areas.id', '=', 'materials.area_id')
            ->leftjoin('type__materials', 'type__materials.id', '=', 'materials.type_material_id')
            ->leftjoin('editorials', 'editorials.id', '=', 'materials.editorial_id')
            /* Como hacer subconsultas AUTORES (muchos a muchos) */
            ->leftjoin(DB::raw("(select materials.id as idmaterial,group_concat(authors.name separator ',') as autores
                    from authors
                    left join author__materials on authors.id=author__materials.author_id
                    left join materials on materials.id=author__materials.material_id
                    GROUP BY idmaterial
                        ) as a"), function ($join) {
                $join->on("a.idmaterial", "=", "materials.id");
            })
            /* Como hacer subconsultas NIVEL EDUCACIONAL (muchos a muchos) */
            ->leftjoin(DB::raw("(select materials.id as idmaterialt,group_concat(educational_levels.name separator ',') as nivel
            from educational_levels
                left join material__educational_levels on material__educational_levels.educational_level_id=educational_levels.id
                left join materials on materials.id=material__educational_levels.material_id
                GROUP BY idmaterialt)
                    as t"), function ($join1) {
                $join1->on("t.idmaterialt", "=", "materials.id");
            })
            /* Como hacer subconsultas usuarios (muchos a muchos) */
            ->leftjoin(DB::raw("(select materials.id AS idmaterialc, material__users.material_id, material__users.detalle_material
            from users
            left join material__users on users.id=material__users.users_id
            left join materials on materials.id=material__users.material_id)
            as c"), function($join){
                $join->on("c.idmaterialc","=","materials.id");
            })
        ->where('c.detalle_material', '=', 'visualizado')
        ->groupBy('materials.id',
        'materials.name',
        'materials.priority',
        'editorials.name',
        'areas.name',
        'type__materials.name',
        'materials.img',
        'a.autores',
        't.nivel',)
        ->orderBy('conteo','desc')
        ->take(5)
        ->get();
        
        return $visualizacion1;
    }
    public function descarga()
    {
        $visualizacion1 = Material::select(
            'materials.id as id',
            'materials.name as nombre',
            'materials.priority AS prioridad',
            'editorials.name AS editorial',
            'areas.name AS area',
            'type__materials.name AS tipo_material',
            'materials.img AS imagen',
            'a.autores AS autor',
            't.nivel AS nivel_educativo',
            DB::raw('COUNT(material_id) as conteo')
        )
            ->leftjoin('areas', 'areas.id', '=', 'materials.area_id')
            ->leftjoin('type__materials', 'type__materials.id', '=', 'materials.type_material_id')
            ->leftjoin('editorials', 'editorials.id', '=', 'materials.editorial_id')
            /* Como hacer subconsultas AUTORES (muchos a muchos) */
            ->leftjoin(DB::raw("(select materials.id as idmaterial,group_concat(authors.name separator ',') as autores
                    from authors
                    left join author__materials on authors.id=author__materials.author_id
                    left join materials on materials.id=author__materials.material_id
                    GROUP BY idmaterial
                        ) as a"), function ($join) {
                $join->on("a.idmaterial", "=", "materials.id");
            })
            /* Como hacer subconsultas NIVEL EDUCACIONAL (muchos a muchos) */
            ->leftjoin(DB::raw("(select materials.id as idmaterialt,group_concat(educational_levels.name separator ',') as nivel
            from educational_levels
                left join material__educational_levels on material__educational_levels.educational_level_id=educational_levels.id
                left join materials on materials.id=material__educational_levels.material_id
                GROUP BY idmaterialt)
                    as t"), function ($join1) {
                $join1->on("t.idmaterialt", "=", "materials.id");
            })
            /* Como hacer subconsultas usuarios (muchos a muchos) */
            ->leftjoin(DB::raw("(select materials.id AS idmaterialc, material__users.material_id, material__users.detalle_material
            from users
            left join material__users on users.id=material__users.users_id
            left join materials on materials.id=material__users.material_id)
            as c"), function($join){
                $join->on("c.idmaterialc","=","materials.id");
            })

            ->where('c.detalle_material', '=', 'descargado')
            ->groupBy('materials.id',
                'materials.name',
                'materials.priority',
                'editorials.name',
                'areas.name',
                'type__materials.name',
                'materials.img',
                'a.autores',
                't.nivel',)
            ->orderBy('conteo', 'desc')
            ->take(5)
            ->get();

        return $visualizacion1;
    }
    public function proceso ($id) {
        $proceso=DB::table('material__users')
        ->select('materials.name AS MATERIAL', 'editorials.name AS EDITORIAL','authors.name AS AUTOR',
        'material__users.detalle_material AS PROCESO','material__users.date_download AS FECHA')
        ->join('materials','materials.id','=','material__users.material_id')
        ->join('editorials','editorials.id','=','materials.editorial_id')
        ->join('author__materials', 'author__materials.material_id','=','materials.id')
        ->join('authors','authors.id','=','author__materials.author_id')
        ->where('material__users.users_id','=',$id)
        ->groupBy('MATERIAL', 'EDITORIAL','AUTOR',
        'PROCESO','FECHA')
        ->get();
        return $proceso;
    }
   
}
