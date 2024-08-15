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
            'name' => 'zall',
            'is_admin' => true,
            'email' => 'zall@admin.com',
            'no_hp' => '012345678901',
            'password' => bcrypt('123456')
        ]);
        User::create([
            'name' => 'zall',
            'is_admin' => false,
            'email' => 'zall@user.com',
            'no_hp' => '012345678901',
            'password' => bcrypt('123456')
        ]);
    }
}
