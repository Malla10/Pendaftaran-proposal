<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@google.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Mahasiswa 1
        User::create([
            'username' => 'mala',
            'name' => 'Beatrix Nirmala Malindir',
            'email' => 'mala@google.com',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
            'nim' => '202357201044',
            'prodi' => 'Sistem Informasi',
            'semester' => 7,
        ]);
    }
}