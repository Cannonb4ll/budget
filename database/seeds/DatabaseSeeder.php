<?php

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
        \App\Models\User::create([
            'name' => 'Fleur',
            'email' => 'fleurvanrijn1991@gmail.com',
            'password' => 'test',
        ]);
    }
}
