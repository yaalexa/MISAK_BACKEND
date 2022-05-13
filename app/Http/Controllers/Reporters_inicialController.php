<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material_User;


class Reporters_inicialController extends Controller
{
    public function index()
    {
        $material_user = Material_User::Select('detalle_material')->get();
        return $material_user;
    }
}
