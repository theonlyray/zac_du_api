<?php

namespace Database\Seeders;

use App\Models\ApplicantData;
use Illuminate\Database\Seeder;

class ApplicantDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        ApplicantData::create([
            'celular'       => $faker->phoneNumber(),
            'rfc'           => $faker->numerify('rfc-####'),
            'no_registro'   => $faker->bothify('?????-#####'),
            'calle'         => $faker->streetName(),
            'no'            => $faker->buildingNumber(),
            'colonia'       => $faker->cityPrefix(),
            'cp'            => $faker->postcode(),
            'ocupacion'     => $faker->jobTitle(),
            'user_id' => 22
        ]);
        ApplicantData::create([
            'celular'       => $faker->phoneNumber(),
            'rfc'           => $faker->numerify('rfc-####'),
            'no_registro'   => $faker->bothify('?????-#####'),
            'calle'         => $faker->streetName(),
            'no'            => $faker->buildingNumber(),
            'colonia'       => $faker->cityPrefix(),
            'cp'            => $faker->postcode(),
            'ocupacion'     => $faker->jobTitle(),
            'user_id' => 23
        ]);
    }
}
