<?php

namespace Database\Seeders;

use App\Models\Credential;
use Illuminate\Database\Seeder;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Credential::create([
            'user_id' => 2,
            'username' => 'QUCI390529P96',
            'password' => 'ckdLb8vi1p',
        ]);

        Credential::create([
            'user_id' => 7,
            'username' => 'QUCI390529P97',
            'password' => 'rMKEtnbVz8',
        ]);

        Credential::create([
            'user_id' => 19,
            'username' => 'QUCI390529P98',
            'password' => 'bFr3AuoPQ7',
        ]);
    }
}
