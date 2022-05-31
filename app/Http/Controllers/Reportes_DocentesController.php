<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Reportes_DocentesController extends Controller
{
    public function index()
    {
        $docente = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                DB::raw('sum(case when "material__users.material_id" "=" "visualizacion" then 1 else 0 end) as visualizado'),
                DB::raw('sum(case when "material__users.material_id" "=" "descargas" then 1 else 0 end) as descargado')
            )
            ->join('rols', 'users.rol_id', '=', 'rols.id')
            ->join('material__users', 'material__users.users_id', '=', 'users.id')
            ->groupBy('users.id','users.name')
            ->orderBy('users.id', 'asc')
            ->get();
            return $docente;
    }
}
