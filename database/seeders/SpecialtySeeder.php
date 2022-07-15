<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialty::create([
            "nombre" => "Seguridad Estructural",
            "college_id" => 1,
        ]);
        Specialty::create([
            "nombre" => "Diseño Urbano",
            "college_id" => 2,
        ]);
        Specialty::create([
            "nombre" => "Instalaciones",
            "college_id" => 3,
        ]);
        Specialty::create([
            "nombre" => "Restauración",
            "college_id" => 4,
        ]);
    }
}
