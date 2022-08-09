<?php

namespace Database\Seeders;

use App\Models\DepartmentUser;
use Illuminate\Database\Seeder;

class DepartmentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DepartmentUser::create([
            "user_id" => 2,
            "department_id" => 1,
        ]);
        DepartmentUser::create([
            "user_id" => 3,
            "department_id" => 1,
        ]);
        DepartmentUser::create([
            "user_id" => 4,
            "department_id" => 1,
        ]);
        DepartmentUser::create([
            "user_id" => 5,
            "department_id" => 1,
        ]);
        DepartmentUser::create([
            "user_id" => 6,
            "department_id" => 1,
        ]);
        DepartmentUser::create([
            "user_id" => 7,
            "department_id" => 2,
        ]);
        DepartmentUser::create([
            "user_id" => 8,
            "department_id" => 2,
        ]);
        DepartmentUser::create([
            "user_id" => 9,
            "department_id" => 2,
        ]);
        DepartmentUser::create([
            "user_id" => 10,
            "department_id" => 2,
        ]);
        DepartmentUser::create([
            "user_id" => 11,
            "department_id" => 2,
        ]);
    }
}
