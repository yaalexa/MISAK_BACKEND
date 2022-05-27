<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Type_Material;
use App\Models\Editorial;
use App\Models\areas;
use App\Models\Educational_level;
use App\Models\Author;
use App\Models\Material;
use App\Models\Author_Material;
use App\Models\Material_Educational_level;
use App\Models\Material_User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\User::factory(10)->create();
       $this->call(Roltable::class);
       User::factory(10)->create();
       Type_Material::factory(8)->create();
       Editorial::factory(15)->create();
       Areas::factory(6)->create();
       Educational_level::factory(6)->create();
       Author::factory(6)->create();
       Material::factory(16)->create();
       Author_Material::factory(16)->create();
       Material_Educational_level::factory(16)->create();
       Material_User::factory(26)->create();
       $this->call(UserSeeder::class);
    }
}
