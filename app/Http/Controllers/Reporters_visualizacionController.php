<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Material_User;
use App\Models\Material_Educational_level;
use Illuminate\Support\Facades\DB;

class Reporters_visualizacionController extends Controller
{
    public function index()
    {

        $material = DB::table('materials')
            ->select(
                'materials.name',
                'materials.img',
                'materials.isbn',
                'materials.year',
                'materials.num_pages',
                'areas.name as area',
                DB::raw("sum(case when 'material__users.detalle_material' '=' 'visualizacion' then 1 else 0 end) as conteo")
            )
            ->join('areas', 'area_id', '=', 'areas.id')
            ->leftJoin('material__users', 'material__users.material_id', '=', 'materials.id')
            ->groupBy('materials.name', 'materials.img', 'materials.isbn', 'materials.year', 'materials.num_pages', 'areas.name')
            ->orderBy('conteo', 'DESC')
            ->get();
        return $material;
    }
}
