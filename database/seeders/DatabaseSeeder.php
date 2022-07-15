<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(CollegeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ApplicantDataSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DepartmentUserSeeder::class);
        $this->call(LicenseTypeSeeder::class);
        $this->call(RequirementSeeder::class);
        $this->call(CollegeUserSeeder::class);
        $this->call(SpecialtySeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(UnitUserSeeder::class);

        // ? create 50 new ramdom duties
        \App\Models\Duty::factory(50)->create();
    }
}
