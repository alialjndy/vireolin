<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'alialjndy2@gmail.com',
            'password' => Hash::make('Password123!'),
            'phone_number' => '1234567890',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
    }
}
