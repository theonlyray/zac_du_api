<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlignLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('license_types')->insert([
            [
                "nombre"        => "ALINEAMIENTO",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
        ]);

        DB::table('requirements')->insert([
            //ALINEAMIENTO
            [
                "nombre" => "Documento que legalmente ampare la propiedad del predio",
                "descripcion" => null,
                "nota" => null,
                "activo" => true,
                "obligatorio" => true,
                "es_plano" => false,
                "license_type_id" => 29,
            ],
            [
                "nombre" => "Recibo de pago del predial del año fiscal correspondiente",
                "descripcion" => null,
                "nota" => null,
                "activo" => true,
                "obligatorio" => true,
                "es_plano" => false,
                "license_type_id" => 29,
            ],
            [
                "nombre" => "Fotografías de la propiedad",
                "descripcion" => "Del frente y de costado",
                "nota" => null,
                "activo" => true,
                "obligatorio" => true,
                "es_plano" => false,
                "license_type_id" => 29,
            ],
        ]);
    }
}
