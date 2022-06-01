<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class Reportes_DescargasController extends Controller
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
                DB::raw("count('material__users.detalle_material' '=' 'visualizacion') as conteo")
            )
            ->join('areas', 'area_id', '=', 'areas.id')
            ->leftJoin('material__users', 'material__users.material_id', '=', 'materials.id')
            ->groupBy('materials.name', 'materials.img', 'materials.isbn', 'materials.year', 'materials.num_pages', 'areas.name')
            ->orderBy('conteo', 'DESC')
            ->get();
        return $material;
    }
    
}
