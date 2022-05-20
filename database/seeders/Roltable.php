<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\support\Facades\DB;


class Roltable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert([
            'name' => 'Administrador',
        ]);
        DB::table('rols')->insert([
            'name' => 'Comunero',
        ]);
        DB::table('rols')->insert([
            'name' => 'Estudiante',
        ]);
        DB::table('rols')->insert([
            'name' => 'Docente',
        ]);
    }
}