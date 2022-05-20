<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Material;
use Illuminate\Foundation\Auth\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material_User>
 */
class Material_UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $array1 = ['prueba 1','prueba 2','prueba 3',];
        $array2 = ['descargado','visualizado'];
        return [
            'manejo_users'=> Arr::random($array1),
            'detalle_material'=> Arr::random($array2),
            'date_download'=>$this->faker->dateTime(),
            'material_id'=>Material::all()->random()->id,
            'users_id'=>User::all()->random()->id
        ];
    }
}