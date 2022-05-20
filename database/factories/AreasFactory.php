<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Areas>
 */
class AreasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $array = ['Ciencias sociales','Tecnología e informática','Artística','Ética y Religión',
        'Educación Física','Preescolar','Investigación Formativa'];
        return [
            'name'=> Arr::random($array)
        ];
    }
}