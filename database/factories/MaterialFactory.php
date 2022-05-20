<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Type_Material;
use App\Models\Editorial;
use App\Models\Area;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    /* public function imageUrl(
        int $width = 640,
        int $height = 480,
        ?string $category = null, /* used as text on the image
        bool $randomize = true,
        ?string $word = null,
        bool $gray = false,
        string $format = 'png'
    ): string; */
    public function definition()
    {


        return [
            'name'=> $this->faker->unique()->word(),
            'isbn'=> $this->faker->isbn10(),
            'year'=> $this->faker->year(),
             'num_pages'=> $this->faker->numberBetween(0, 1000),
            'priority'=> $this->faker->numberBetween(1, 2),
            'pdf'   => $this->faker->url(),
            'img' => $this->faker->url(),
            'type_material_id' => Type_Material::all()->random()->id,
            'editorial_id'=> Editorial::all()->random()->id,
            'area_id'=> Area::all()->random()->id
        ];
    }
}