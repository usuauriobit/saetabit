<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
class AvionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_motor_id'     => rand(1, 2),
            'estado_avion_id'   => rand(1, 2),
            'fabricante_id'     => rand(1, 7),
            'descripcion'       => $this->faker->sentence(5) ,
            'modelo'            => $this->faker->secondaryAddress,
            'matricula'         => $this->faker->secondaryAddress,
            'nro_asientos'      => rand(10, 20),
            'nro_pilotos'       => rand(1, 2),
            'peso_max_pasajeros'=> rand(500, 1200),
            'peso_max_carga'    => rand(50, 120),
            'fecha_fabricacion' => $this->faker->dateTime,
        ];
    }
}
