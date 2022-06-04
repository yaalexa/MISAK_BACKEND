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


   public function generateReport()
   {   
    $extensao = 'pdf' ;
    $nome = 'testeJasper';
    $filename =  $nome  . time();
    $output = base_path('/public/report/' . $filename);
    $jasper = new JasperPHP;
    $jasper->compile( __DIR__ . '/.../public/storage/app/report/report2.jrxml')->execute();
   
    $jasper->process(
      storage_path(__DIR__ . '/.../public/storage/app/report/report2.jasper') ,

      $output,
      array($extensao),
      array('user_name' => ''),
      $this->getDatabaseConfigMysql(),
      "pt_BR"
    )->execute();
   $file = $output .'.'.$extensao ;
   
   }
  
  public function Report_VIPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportvisua.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportvisua.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $array = $jasper->list_parameters(__DIR__ . '/../../../public/storage/report/reportvisua.jasper'
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportvisua.pdf');
    return response()->file($pathTofile);
}

public function Report_DEPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportd.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportd.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportd.pdf');
    return response()->file($pathTofile);

}
public function Report_DOVISPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportdocenteI.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportdocenteI.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportdocenteI.pdf');
    return response()->file($pathTofile);

}
public function Report_DODEPDF($id_docente){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '/../../../public/storage/report/reportdoce.jrxml')->execute();
    $jasper->process(__DIR__ . '/../../../public/storage/report/reportdoce.jasper',
        false,
        ['pdf'],
        ["Id_Rol"=> $id_docente],
        $db->getDatabaseconfig(),
    )->execute();
    $pathTofile = storage_path('/app/public/report/reportdoce.pdf');
    return response()->file($pathTofile);

}

      
}