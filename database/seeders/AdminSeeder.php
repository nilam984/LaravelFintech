<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile' => '9876543210',
            'password' => Hash::make(123456),
            'role' => 'admin',
            'status' => 1,
            'email_otp' => NULL,
            'email_otp_expire_at' => NULL,
            'email_verified_at' => NULL,
            'updated_by' => -1,
        ]);
    }
}
