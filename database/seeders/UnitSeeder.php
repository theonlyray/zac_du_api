<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'nombre' => 'Unidad No. 1.1',
            'department_id' => 1,
        ]);
        Unit::create([
            'nombre' => 'Unidad No. 2.1',
            'department_id' => 2,
        ]);
        Unit::create([
            'nombre' => 'Unidad No. 3.1',
            'department_id' => 3,
        ]);
    }
}
