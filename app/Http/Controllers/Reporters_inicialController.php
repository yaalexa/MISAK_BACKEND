<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material_User;
use Illuminate\Support\Facades\DB;


class Reporters_inicialController extends Controller
{
    public function index()
    {
        $material_user = Material_User::Select('detalle_material')->get();
        return $material_user;
    }

    public function ReportVi()
    {
        $material = DB::table('materials')
            ->select(
                'materials.name',
                'materials.img',
                'materials.isbn',
                'materials.year',
                'materials.num_pages',
                'areas.name as area',
                DB::raw("count('material__users.detalle_material' '=' 'visualizado') as conteo")
            )
            ->join('areas', 'area_id', '=', 'areas.id')
            ->Join('material__users', 'material__users.material_id', '=', 'materials.id')
            ->groupBy('materials.name', 'materials.img', 'materials.isbn', 'materials.year', 'materials.num_pages', 'areas.name')
            ->orderBy('conteo', 'DESC')
            ->get();
        return $material;
    }

    public function ReportDe()
    {
        $material = DB::table('materials')
            ->select(
                'materials.name',
                'materials.img',
                'materials.isbn',
                'materials.year',
                'materials.num_pages',
                'areas.name as area',
                DB::raw("count('material__users.detalle_material' '=' 'descargado') as conteo")
            )
            ->join('areas', 'area_id', '=', 'areas.id')
            ->leftJoin('material__users', 'material__users.material_id', '=', 'materials.id')
            ->groupBy('materials.name', 'materials.img', 'materials.isbn', 'materials.year', 'materials.num_pages', 'areas.name')
            ->orderBy('conteo', 'DESC')
            ->get();
        return $material;
    }
    public function ReportDoc()
    {
        $docente = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                DB::raw('sum(case when "material__users.material_id" "=" "visualizado" then 1 else 0 end) as visualizado'),
                DB::raw('sum(case when "material__users.material_id" "=" "descargado" then 1 else 0 end) as descargado')
            )
            ->join('rols', 'users.rol_id', '=', 'rols.id')
            ->join('material__users', 'material__users.users_id', '=', 'users.id')
            ->groupBy('users.id','users.name')
            ->orderBy('users.id', 'asc')
            ->get();
            return $docente;
    }

    public function DetalleDo($id){
        $detalle = DB::table('users')
        ->select(
            'users.name',
            'materials.name as material',
            'materials.img',
            'materials.isbn',
            'material__users.detalle_material'
            )
        ->join('material_users', 'material__users.users_id', '=', 'users.id')
        ->join('materials', 'material__users.material_id', '=', 'materials.id')
        ->where('users.id', '=', $id)
        ->get();

        return $detalle;
    }
}