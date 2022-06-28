<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JasperPHP\JasperPHP ;


class ReportController extends Controller
{
    public function getDatabaseConfig()
    {
      $jdbc_dir =base_path('vendor/cossou/jasperphp/src/JasperStarter/jdbc');
       return [
         'driver'   => 'mysql',
         'host'     => env('DB_HOST'),
         'port'     => env('DB_PORT'),
         'username' => env('DB_USERNAME'),
         'password' => env('DB_PASSWORD'),
         'database' => env('DB_DATABASE'),
         'jdbc_driver' => 'com.mysql.jdbc.Driver',
         'jdbc_url' => 'jdbc:sqlserver://localhost;databaseName='.env('DB_DATABASE').'',
         'jdbc_dir' =>  $jdbc_dir
      ];
   }


   
  
  public function Report_VIPDF($fecha_inicio,$fecha_final){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(storage_path('app/public'). '/report/reportvisualizado.jrxml')->execute();
    $jasper->process(storage_path('app/public'). '/report/reportvisualizado.jasper',
        false,
        ['pdf'],
        ["FechaInicio"=>$fecha_inicio,
        "FechaFinal"=>$fecha_final],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('app/public'). '/report/reportvisualizado.pdf';
    return response()->file($pathTofile);
}

public function Report_DEPDF($fecha_inicio,$fecha_final){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(storage_path('app/public'). '/report/reportdescargado.jrxml')->execute();
    $jasper->process(storage_path('app/public'). '/report/reportdescargado.jasper',
        false,
        ['pdf'],
        ["FechaInicio"=>$fecha_inicio,
        "FechaFinal"=>$fecha_final],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('app/public'). '/report/reportdescargado.pdf';
    return response()->file($pathTofile);

}
public function Report_DOVISPDF($fecha_inicio,$fecha_final){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(storage_path('app/public'). '/report/reportdocente.jrxml')->execute();
    $jasper->process(storage_path('app/public'). '/report/reportdocente.jasper',
        false,
        ['pdf'],
        ["FechaInicio"=>$fecha_inicio,
        "FechaFinal"=>$fecha_final],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('app/public'). '/report/reportdocente.pdf';
    return response()->file($pathTofile);
}
public function Report_DODEPDF($id_docente){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(storage_path('app/public'). '/report/reportdocentedetalle.jrxml')->execute();
    $jasper->process(storage_path('app/public'). '/report/reportdocentedetalle.jasper',
        false,
        ['pdf'],
        ["Id_Rol"=> $id_docente],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('app/public'). '/report/reportdocentedetalle.pdf';
    return response()->file($pathTofile);
}

      
}