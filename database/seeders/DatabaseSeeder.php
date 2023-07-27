<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mary', 
            'email' => 'mmebit@icloud.com',
            'password' => bcrypt('football'),
        ]);

        User::create([
            'name' => 'John', 
            'email' => 'johndoe@google.com',
            'password' => bcrypt('footballisgreat'),
        ]);
    }
}
