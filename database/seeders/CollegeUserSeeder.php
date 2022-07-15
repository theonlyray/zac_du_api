<?php

namespace Database\Seeders;

use App\Models\CollegeUser;
use Illuminate\Database\Seeder;

class CollegeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CollegeUser::create([
            "user_id" => 17,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 18,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 19,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 20,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 22,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 21,
            "college_id" => 2,
        ]);
    }
}
