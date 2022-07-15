<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        DB::table('departments')->insert([
            [
                "nombre"            => "DEPARTAMENTO DE PERMISOS Y LICENCIAS DE CONSTRUCCIÓN",
                "correo"            => $faker->unique()->safeEmail(),
                "telefono"          => $faker->phoneNumber(),
            ],
            [
                "nombre"            => "DEPARTAMENTO DE PLANEACIÓN Y DU",
                "correo"            => $faker->unique()->safeEmail(),
                "telefono"          => $faker->phoneNumber(),
            ],
            [
                "nombre"            => "SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE",
                "correo"            => $faker->unique()->safeEmail(),
                "telefono"          => $faker->phoneNumber(),
            ],
        ]);
    }
}
