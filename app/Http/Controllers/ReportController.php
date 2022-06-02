<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JasperPHP\JasperPHP ;

class ReportController extends Controller
{
    public function getDatabaseConfig()
    {
      $jdbc_dir ='C:\xampp3.3\htdocs\GitHub\MISAK\MISAK_BACKEND\MISAK_BACKEND\vendor\cossou\jasperphp\src\JasperStarter\jdbc';
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
  
   public function getParametros()
	{
	  $output = 
        JasperPHP::list_parameters(storage_path('app/public'). '/relatorios/reportJasper.jrxml')->execute();
   
        foreach($output as $parameter_description)
        {
            $parameter_description = trim($parameter_description);
            //echo $parameter_description . '<br>' ;
            $dados = explode(" ", trim($parameter_description), 4 );
            echo '<strong>Parametro:</strong>  ' .  $dados[1] . 
                ' <strong>Tipo de Dados:</strong>  ' . $dados[2] .   
                ' <strong>Descricao do Campo:</strong>   ' . $dados[3] . '<br>';
        }
	}
  public function Report_VIPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(__DIR__ . '../public/storage/report/reportvisua.jrmxl')->execute();
    $jasper->process(__DIR__ . '../public/storage/report/reportvisua.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $array = $jasper->list_parameters(
        __DIR__ . '../public/storage/report/reportvisua.jasper'
    )->execute();
    $pathTofile = storage_path('../public/storage/report/reportvisua.pdf');
    return response()->file($pathTofile);

}
public function Report_DEPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(_DIR_ . '/../public/storage/report/reportdescar.jrmxl')->execute();
    $jasper->process(
        _DIR_ . '/../public/storage/report/reportdescar.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $array = $jasper->list_parameters(
        _DIR_ . '/../public/storage/report/reportdescar.jasper'
    )->execute();
    $pathTofile = storage_path('/../public/storage/report/reportdescar.pdf');
    return response()->file($pathTofile);

}
public function Report_DOPDF(){
    $db = new ReportController();
    $jasper = new JasperPHP;
    $jasper->compile(_DIR_ . '/../public/storage/report/report1.jrmxl')->execute();
    $jasper->process(
        _DIR_ . '/../public/storage/report/report1.jasper',
        false,
        ['pdf'],
        [],
        $db->getDatabaseconfig(),
    )->execute();
    $array = $jasper->list_parameters(
        _DIR_ . '/../public/storage/report/report1.jasper'
    )->execute();
    $pathTofile = storage_path('/../public/storage/report/report1.pdf');
    return response()->file($pathTofile);

}

      
}