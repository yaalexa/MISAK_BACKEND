<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type_Material>
 */
class Type_MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $array = ['Enciclopedias','Diccionarios','Atlas',
        'Manuales','Compendios','Anuarios','Memorias anuales',
        'Guías', 'libro'];
        return [
            'name'=> Arr::random($array)
        ];
    }
}