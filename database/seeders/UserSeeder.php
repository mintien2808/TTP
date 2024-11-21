<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Minh Tiến',
            'email' => 'minhtien@gmail.com',
            'password' => bcrypt('min12345'),
            'email_verified_at' => now(),
            'is_admin' => false
        ]);
    }
}
