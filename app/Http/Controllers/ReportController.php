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


   
  
  public function Report_VIPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportvisualizado.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportvisualizado.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportvisualizado.pdf');
    return response()->file($pathTofile);
}

public function Report_DEPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportdescargado.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportdescargado.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportdescargado.pdf');
    return response()->file($pathTofile);

}
public function Report_DOVISPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportdocente.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportdocente.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportdocente.pdf');
    return response()->file($pathTofile);

}
public function Report_DODEPDF($id_docente){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportdocentedetalle.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportdocentedetalle.jasper',
        false,
        ['pdf'],
        ["Id_Rol"=> $id_docente],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportdocentedetalle.pdf');
    return response()->file($pathTofile);

}

      
}