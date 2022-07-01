<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material_User;
use App\Models\User;
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
            'users.name',
            'a.visualizado',
            'b.descargado'
        )
        ->leftjoin(DB::raw("(select material__users.users_id as idu, count(material__users.id) as visualizado
        from material__users
        inner join users on users.id = material__users.users_id
        where material__users.detalle_material = 'visualizado'
        GROUP BY material__users.users_id) as a"), function ($join) {
            $join->on("a.idu", "=", "users.id");
        })
        ->leftjoin(DB::raw("(select material__users.users_id as idd, count(material__users.id) as descargado
        from material__users
        inner join users on users.id = material__users.users_id
        where material__users.detalle_material = 'descargado'
        GROUP BY material__users.users_id) as b"), function ($join) {
            $join->on("b.idd", "=", "users.id");
        })
        ->join ('rols', 'rols.id', '=', 'users.rol_id')
        ->get();
        return $docente;
    }

    public function DetalleDo($id){
        $detalle = DB::table('users')
        ->select(
            'users.name',
            'a.visualizado',
            'b.descargado'
        )
        ->leftjoin(DB::raw("(select material__users.users_id as idu, count(material__users.id) as visualizado
        from material__users
        inner join users on users.id = material__users.users_id
        where material__users.detalle_material = 'visualizado'
        GROUP BY material__users.users_id) as a"), function ($join) {
            $join->on("a.idu", "=", "users.id");
        })
        ->leftjoin(DB::raw("(select material__users.users_id as idd, count(material__users.id) as descargado
        from material__users
        inner join users on users.id = material__users.users_id
        where material__users.detalle_material = 'descargado'
        GROUP BY material__users.users_id) as b"), function ($join) {
            $join->on("b.idd", "=", "users.id");
        })
        ->join ('rols', 'rols.id', '=', 'users.rol_id')
        ->get();
        return $detalle;
    }
}