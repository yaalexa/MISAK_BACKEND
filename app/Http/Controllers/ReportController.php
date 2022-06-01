<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JasperPHP\JasperPHP;


class ReportController extends Controller
{
    public function getDatabaseConfig(){
        $jdbc_dir = 'C:\xampp\htdocs\MISAK_BACKEND\MISAK_BACKEND\vendor\cossou\jasperphp\src\JasperStarter\jdbc';
        return [
            'driver' => 'mysql',
            'host'  => env('DB_HOST'),
            'port'  => env('DB_PORT'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWPRD'),
            'database'  => env('DB_DATABASE'),
            'jdbc_driver'  => 'com.msqyl.jdbc.Driver',
            'jdbc_url'  => 'jdbc:sqlserver://localhost;databaseName=' .env('DB_DATABASE').'',
            'jdbc_dir'  => $jdbc_dir
        ];
    }

    public function Report_VIPDF(){
        $db = new ReportController();
        $jasper = new JasperPHP;
        $jasper->compile(__DIR__ . '/../public/storage/report/reportvisua.jrmxl')->execute();
        $jasper->process(
            __DIR__ . '/../public/storage/report/reportvisua.jasper',
            false,
            ['pdf'],
            [],
            $db->getDatabaseconfig(),
        )->execute();
        $array = $jasper->list_parameters(
            __DIR__ . '/../public/storage/report/reportvisua.jasper'
        )->execute();
        $pathTofile = storage_path('/../public/storage/report/reportvisua.pdf');
        return response()->file($pathTofile);
    
    }
    public function Report_DEPDF(){
        $db = new ReportController();
        $jasper = new JasperPHP;
        $jasper->compile(__DIR__ . '/../public/storage/report/reportdescar.jrmxl')->execute();
        $jasper->process(
            __DIR__ . '/../public/storage/report/reportdescar.jasper',
            false,
            ['pdf'],
            [],
            $db->getDatabaseconfig(),
        )->execute();
        $array = $jasper->list_parameters(
            __DIR__ . '/../public/storage/report/reportdescar.jasper'
        )->execute();
        $pathTofile = storage_path('/../public/storage/report/reportdescar.pdf');
        return response()->file($pathTofile);
    
    }
    public function Report_DOPDF(){
        $db = new ReportController();
        $jasper = new JasperPHP;
        $jasper->compile(__DIR__ . '/../public/storage/report/report1.jrmxl')->execute();
        $jasper->process(
            __DIR__ . '/../public/storage/report/report1.jasper',
            false,
            ['pdf'],
            [],
            $db->getDatabaseconfig(),
        )->execute();
        $array = $jasper->list_parameters(
            __DIR__ . '/../public/storage/report/report1.jasper'
        )->execute();
        $pathTofile = storage_path('/../public/storage/report/report1.pdf');
        return response()->file($pathTofile);
    
    }
}