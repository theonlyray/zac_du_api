<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LicenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('license_types')->insert([
            [
                "nombre"        => "LICENCIA DE CONSTRUCCIÓN",
                "descripcion"   => null,
                "nota"          => "MENOR A 45M2",
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "LICENCIA DE CONSTRUCCIÓN",
                "descripcion"   => null,
                "nota"          => "MAYOR A 45M2",
                "activo"        => true,
                "department_id" => 1,
                "particular"     => false,
            ],
            [
                "nombre"        => "LICENCIA PROYECTOS ESPECIALES",
                "descripcion"   => 'Oficinas, comercio, salud, recreación, deporte, alojamiento, seguridad, educación, servicios, industrial e infraestructura etc.',
                "nota"          => 'MÁS DE 1000M2',
                "activo"        => true,
                "department_id" => 1,
                "particular"     => false,
            ],
            [
                "nombre"        => "PERMISO PARA BARDEO",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "PERMISO DE ENJARRES, APLANADOS, FIRMES, COLOCACIÓN DE PISO, YESO, PETATILLO, TABLARROCA, CANCELERIA, ENMALLADO",
                "descripcion"   => null,
                "nota"          => "MAYOR A 50M2",
                "activo"        => true,
                "department_id" => 1,
                "particular"     => false,
            ],
            [
                "nombre"        => "PRÓRROGA O EXTENSIÓN DEL TIEMPO DE CONSTRUCCIÓN",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "NÚMERO OFICIAL Y ALINEAMIENTO",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "PERMISO PARA INSTALACIÓN DE TORRE EÓLICA",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => false,
            ],
            [
                "nombre"        => "PERMISO PARA INSTALACIÓN DE ANTENA DE TELECOMUNICACIÓN",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => false,
            ],
            [
                "nombre"        => "PERMISO PARA ESTACIÓN DE SERVICIO GAS L.P. PARA CARBURACIÓN",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => false,
            ],
            [
                "nombre"        => "PERMISO PARA ESTACIÓN DE SERVICIO (GASOLINERA)",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => false,
            ],
            [
                "nombre"        => "CONSTANCIA DE SERVICIOS URBANOS",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "CONSTANCIA DE AUTOCONSTRUCCIÓN Y VARIAS",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "CONSTANCIA DE SEGURIDAD ESTRUCTURAL",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "REGULARIZACIÓN",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 1,
                "particular"     => true,
            ],
            [
                "nombre"        => "CONSTANCIA COMPATIBILIDAD URBANÍSTICA",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 2,
                "particular"     => true,
            ],
            [
                "nombre"        => "ANUNCIOS ADOSADOS A FACHADA",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 2,
                "particular"     => true,
            ],
            [
                "nombre"        => "ANUNCIOS TIPO ESTRUCTURALES",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 2,
                "particular"     => false,
            ],
            [
                "nombre"        => "ANUNCIOS TEMPORALES ADOSADOS",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 2,
                "particular"     => true,
            ],
            [
                "nombre"        => "ANUNCIOS EN VEHÍCULOS",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 2,
                "particular"     => true,
            ],
            [
                "nombre"        => "SEGURIDAD DE ESTRUCTURA ANTENAS",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 2,
                "particular"     => false,
            ],
            [
                "nombre"        => "AUTORIZACIÓN DE SUBDIVISIÓN, DESMEMBRACIÓN O FUSIÓN DE TERRENOS URBANOS",
                "descripcion"   => null,
                "nota"          => null,
                "activo"        => true,
                "department_id" => 2,
                "particular"     => true,
            ],
        ]);
    }
}
