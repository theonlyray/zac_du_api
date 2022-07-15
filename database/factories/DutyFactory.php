<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DutyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descripcion' => $this->faker->sentence(),
            'clave' => $this->faker->word(),
            'unidad' => $this->faker->word(),
            'precio' => $this->faker->randomFloat(2),
            'department_id' => rand(1,2),
        ];
    }
}
