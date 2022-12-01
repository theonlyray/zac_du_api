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
            "user_id" => 12,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 13,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 14,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 15,
            "college_id" => 1,
        ]);
        CollegeUser::create([
            "user_id" => 16,
            "college_id" => 2,
        ]);
        CollegeUser::create([
            "user_id" => 17,
            "college_id" => 1,
        ]);
    }
}
