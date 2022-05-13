<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Material_User;
use App\Models\Material_Educational_level;
use Illuminate\Support\Facades\DB;

class Reporters_visualizacionController extends Controller
{
    public function index(){

        // $material = DB::table('material__educational_levels')
        // ->join('educational_levels', 'educational_level_id', '=', 'educational_levels.id')
        // ->join('materials', 'material_id', '=', 'materials.id')
        // ->join('areas','area_id','=','areas.id')
        // ->join('material__users','material_id','=','material__users.id')
        // ->select('materials.name','materials.img','materials.isbn','materials.year','materials.num_pages',
        // 'areas.name as area','educational_levels.name as nivel')
        // ->where('material__users.detalle_material','=','visualizacion')
        // ->groupBy('materials.name','material__users.users_id')
        // ->orderBy('')
        // ->get();
        // return $material;
    }

    public function llamado(){
        $material_user = Material_User::Select('detalle_material')->get();
        return $material_user;
    }
}
