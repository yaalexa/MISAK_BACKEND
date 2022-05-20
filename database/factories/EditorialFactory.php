<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Editorial>
 */
class EditorialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $array = [
            'Errara Natura', 'Pre-textos', 'Sexto Piso',
            'Nórdica','Acantilado', 'De Conatus',
            'Cabaret Voltaire', 'La Huerta Grande',
            'Impedimenta',  'La Umbría y la Solana',
            'Blackie Books', 'Caro Raggio',
            'Libros del Asteroide', 'Renacimiento',
            'Pálido Fuego', 'Páginas de Espuma',
            'Menoscuarto',  'Periférica', 'Visor',
            'La Línea del Horizonte', 'Ático de los libros',
            'Hiperión',  'Minúscula', 'Baile del Sol',
            'La Isla de Siltolá', 'Hoja de Lata', 'Tabla resumen'];
        return [
            'name'=> Arr::random($array)
        ];
    }
}