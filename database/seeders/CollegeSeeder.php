<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        College::create([
            "nombre"            => "Colegio Ing. Zacatecas",
            "correo"            => "col_ing@gmail.com",
            "telefono"          => $faker->phoneNumber(),
            "ubicacion"         => $faker->paragraph(),
            "porcentaje"        => 10,
        ]);
        College::create([
            "nombre"            => "Colegio Arq. Zacatecas",
            "correo"            => "col_aqr@gmail.com",
            "telefono"          => $faker->unique()->safeEmail(),
            "ubicacion"         => $faker->paragraph(),
            "porcentaje"        => 10,
        ]);
        College::create([
            "nombre"            => "Colegio Mec Elec. Zacatecas",
            "correo"            => "col_mec@gmail.com",
            "telefono"          => $faker->unique()->safeEmail(),
            "ubicacion"         => $faker->paragraph(),
            "porcentaje"        => 10,
        ]);
        College::create([
            "nombre"            => "Colegio Restauradores Zacatecas",
            "correo"            => "col_res@gmail.com",
            "telefono"          => $faker->unique()->safeEmail(),
            "ubicacion"         => $faker->paragraph(),
            "porcentaje"        => 10,
        ]);
    }
}
