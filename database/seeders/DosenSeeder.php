<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dosen 1 - IoT & Embedded System
        $user1 = User::create([
            'username' => 'dosen1',
            'name' => 'Dr. Ahmad Fauzi, M.Kom',
            'email' => 'ahmad.fauzi@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456789',
        ]);

        Dosen::create([
            'user_id' => $user1->id,
            'nidn' => '0123456789',
            'nama' => 'Dr. Ahmad Fauzi, M.Kom',
            'bidang_penelitian' => 'Internet of Things & Embedded System',
            'keywords' => 'IoT, Sensor, Embedded System, Arduino, ESP32, Smart Home, Wireless Sensor Network',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 2 - AI & Machine Learning
        $user2 = User::create([
            'username' => 'dosen2',
            'name' => 'Dr. Siti Nurhaliza, M.T',
            'email' => 'siti.nurhaliza@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456790',
        ]);

        Dosen::create([
            'user_id' => $user2->id,
            'nidn' => '0123456790',
            'nama' => 'Dr. Siti Nurhaliza, M.T',
            'bidang_penelitian' => 'Artificial Intelligence & Machine Learning',
            'keywords' => 'AI, Machine Learning, Deep Learning, Neural Network, Computer Vision, Natural Language Processing',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 3 - Web Development & Mobile
        $user3 = User::create([
            'username' => 'dosen3',
            'name' => 'Budi Santoso, S.Kom, M.Kom',
            'email' => 'budi.santoso@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456791',
        ]);

        Dosen::create([
            'user_id' => $user3->id,
            'nidn' => '0123456791',
            'nama' => 'Budi Santoso, S.Kom, M.Kom',
            'bidang_penelitian' => 'Web Development & Mobile Application',
            'keywords' => 'Web Development, Mobile App, Laravel, React, Flutter, Android, iOS, Progressive Web App',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 4 - Data Mining & Big Data
        $user4 = User::create([
            'username' => 'dosen4',
            'name' => 'Dr. Rina Wati, M.Sc',
            'email' => 'rina.wati@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456792',
        ]);

        Dosen::create([
            'user_id' => $user4->id,
            'nidn' => '0123456792',
            'nama' => 'Dr. Rina Wati, M.Sc',
            'bidang_penelitian' => 'Data Mining & Big Data Analytics',
            'keywords' => 'Data Mining, Big Data, Data Analytics, Business Intelligence, Data Warehouse, Python, R',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 5 - Network & Security
        $user5 = User::create([
            'username' => 'dosen5',
            'name' => 'Andi Wijaya, M.T',
            'email' => 'andi.wijaya@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456793',
        ]);

        Dosen::create([
            'user_id' => $user5->id,
            'nidn' => '0123456793',
            'nama' => 'Andi Wijaya, M.T',
            'bidang_penelitian' => 'Network Security & Cybersecurity',
            'keywords' => 'Network Security, Cybersecurity, Cryptography, Firewall, Penetration Testing, Ethical Hacking',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 6 - Sistem Informasi
        $user6 = User::create([
            'username' => 'dosen6',
            'name' => 'Dr. Dewi Lestari, M.M',
            'email' => 'dewi.lestari@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456794',
        ]);

        Dosen::create([
            'user_id' => $user6->id,
            'nidn' => '0123456794',
            'nama' => 'Dr. Dewi Lestari, M.M',
            'bidang_penelitian' => 'Sistem Informasi Manajemen',
            'keywords' => 'Sistem Informasi, Manajemen, ERP, CRM, Database Management, Sistem Pendukung Keputusan',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);
    }
}