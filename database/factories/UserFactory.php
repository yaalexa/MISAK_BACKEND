<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rol;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $array = ['Cedula', 'Cedula de extrajeria','pasaporte', 'PEP','Tarjeta de identidad','Otro'];
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        return [
            'name' => $firstName,
            'full_name' => $firstName . ' ' . $lastName,
            'document_type'=> Arr::random($array),
            'email' => $this->faker->unique()->safeEmail(),
            'document_number' => $this->faker->randomNumber(8, true),
            'certificate_misak' => $this->faker->randomNumber(5, true),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi', // password
            'rol_id'=> Rol::all()->random()->id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}