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
            'email' => 'admin@unmus.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Mahasiswa 1
        User::create([
            'username' => 'mahasiswa1',
            'name' => 'Budi Santoso',
            'email' => 'budi@student.unmus.ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
            'nim' => '2021001',
            'prodi' => 'Sistem Informasi',
            'semester' => 7,
        ]);

        // Mahasiswa 2
        User::create([
            'username' => 'mahasiswa2',
            'name' => 'Siti Rahma',
            'email' => 'siti@student.unmus.ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
            'nim' => '2021002',
            'prodi' => 'Sistem Informasi',
            'semester' => 7,
        ]);

        // Mahasiswa 3
        User::create([
            'username' => 'mahasiswa3',
            'name' => 'Andi Wijaya',
            'email' => 'andi@student.unmus.ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
            'nim' => '2021003',
            'prodi' => 'Sistem Informasi',
            'semester' => 7,
        ]);

        // Mahasiswa 4
        User::create([
            'username' => 'mahasiswa4',
            'name' => 'Dewi Lestari',
            'email' => 'dewi@student.unmus.ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
            'nim' => '2021004',
            'prodi' => 'Sistem Informasi',
            'semester' => 7,
        ]);

        // Mahasiswa 5
        User::create([
            'username' => 'mahasiswa5',
            'name' => 'Rudi Hermawan',
            'email' => 'rudi@student.unmus.ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
            'nim' => '2021005',
            'prodi' => 'Sistem Informasi',
            'semester' => 7,
        ]);
    }
}