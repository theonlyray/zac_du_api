<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "nombre" => "Super Admin",
            "correo" => "superadmin@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('super-admin');
        //Permisos y Licencias
        User::create([
            "nombre" => "Dir Dep. de Permisos y Licencias de Construcción",
            "correo" => "dirdepplc@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('directorDpt');
        User::create([
            "nombre" => "Subdir Dep. de Permisos y Licencias de Construcción",
            "correo" => "subdirdepplc@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('subDirectorDpt');
        User::create([
            "nombre" => "Jefe de Unidad Dep. de Permisos y Licencias de Construcción",
            "correo" => "ju_depplc@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('jefeUnidadDpt');
        User::create([
            "nombre" => "col 1 Dep. de Permisos y Licencias de Construcción",
            "correo" => "col_1_depplc@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorDpt');
        User::create([
            "nombre" => "col 2 Dep. de Permisos y Licencias de Construcción",
            "correo" => "col_2_depplc@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorDpt');
        //Planeación y D.U.
        User::create([
            "nombre" => "Dir Dep. de Planeación y D.U.",
            "correo" => "dirdeppdu@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('directorDpt');
        User::create([
            "nombre" => "Subdir Dep. de Planeación y D.U.",
            "correo" => "subdirdeppdu@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('subDirectorDpt');
        User::create([
            "nombre" => "Jefe de Unidad Dep. de Planeación y D.U.",
            "correo" => "ju_deppdu@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('jefeUnidadDpt');
        User::create([
            "nombre" => "col 1 Dep. de Planeación y D.U.",
            "correo" => "col_1_deppdu@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorDpt');
        User::create([
            "nombre" => "col 2 Dep. de Planeación y D.U.",
            "correo" => "col_2_deppdu@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorDpt');
        //SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE
        User::create([
            "nombre" => "Dir SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE",
            "correo" => "dirdepsduma@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('directorDpt');
        User::create([
            "nombre" => "Subdir SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE",
            "correo" => "subdirdepsduma@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('subDirectorDpt');
        User::create([
            "nombre" => "Jefe de Unidad SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE",
            "correo" => "ju_depsduma@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('jefeUnidadDpt');
        User::create([
            "nombre" => "col 1 SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE",
            "correo" => "col_1_depsduma@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorDpt');
        User::create([
            "nombre" => "col 2 SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE",
            "correo" => "col_2_depsduma@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorDpt');

        //colegio ing
        User::create([
            "nombre" => "Dir Colegio Ing",
            "correo" => "dir_col_ing@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('directorCol');
        User::create([
            "nombre" => "subdir Colegio Ing",
            "correo" => "subdir_col_ing@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('subDirectorCol');
        User::create([
            "nombre" => "col 1 Colegio Ing",
            "correo" => "col_1_col_ing@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorCol');
        User::create([
            "nombre" => "col 2 Colegio Ing",
            "correo" => "col_2_col_ing@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('colaboradorCol');
        //colegio ing
        User::create([
            "nombre" => "Dir Colegio Arq",
            "correo" => "dir_col_arq@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('directorCol');


        User::create([
            "nombre" => "DRO Francisco",
            "correo" => "fcarrilloaparicio@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('dro');
        User::create([
            "nombre" => "Particular",
            "correo" => "rchaireztorres@gmail.com",
            "contrasenia" => Hash::make("password"),
        ])->assignRole('particular');
    }
}
