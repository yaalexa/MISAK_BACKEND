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
            'name' => 'administrador',
        ]);
        DB::table('rols')->insert([
            'name' => 'comunero',
        ]);
        DB::table('rols')->insert([
            'name' => 'estudiante',
        ]);
        DB::table('rols')->insert([
            'name' => 'docente',
        ]);
    }
}
