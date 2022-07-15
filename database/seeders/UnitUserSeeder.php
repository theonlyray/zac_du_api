<?php

namespace Database\Seeders;

use App\Models\UnitUser;
use Illuminate\Database\Seeder;

class UnitUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitUser::create([
            "user_id" => 4,
            "unit_id" => 1,
        ]);
        UnitUser::create([
            "user_id" => 5,
            "unit_id" => 1,
        ]);
        UnitUser::create([
            "user_id" => 9,
            "unit_id" => 2,
        ]);
        UnitUser::create([
            "user_id" => 10,
            "unit_id" => 2,
        ]);
        UnitUser::create([
            "user_id" => 14,
            "unit_id" => 3,
        ]);
        UnitUser::create([
            "user_id" => 15,
            "unit_id" => 3,
        ]);
    }
}
