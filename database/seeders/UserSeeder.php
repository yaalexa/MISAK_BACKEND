<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   DB::table('users')->insert([
        'name' => 'Admin',
        'full_name' => 'Administrador',
        'document_type'=> 'Cedula',
        'email' => 'admin@admin',
        'document_number' => '123456789',
        'certificate_misak' => '123456789',
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
        'password' => bcrypt('123'), // password
        'rol_id'=> 1
    ]);

    }
}