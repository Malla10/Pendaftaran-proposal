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
        // Dosen 1 - Sistem dan Teknologi Informasi
        $user1 = User::create([
            'username' => 'pak stanly',
            'name' => 'Stanly Hence Dolfi Loppies. S,Kom., M.Kom',
            'email' => 'Stanly@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456789',
        ]);

        Dosen::create([
            'user_id' => $user1->id,
            'nidn' => '0123456789',
            'nama' => 'Stanly Hence Dolfi Loppies. S,Kom., M.Kom',
            'bidang_penelitian' => 'Sistem dan Teknologi Informasi',
            'keywords' => 'Sistem Informasi, Teknologi Informasi, Information System, IT Infrastructure, Database Management, Software Development, Networking, Cybersecurity, Cloud Computing, Big Data, Data Analytics, IT Governance, Enterprise Architecture, Decision Support System, Information Management',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 2 - Sistem Informasi Geografis
        $user2 = User::create([
            'username' => 'pak fransiskus',
            'name' => 'Fransiskus Xavierus, S.Kom., M.Kom',
            'email' => 'Fransiskus@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456790',
        ]);

        Dosen::create([
            'user_id' => $user2->id,
            'nidn' => '0123456790',
            'nama' => 'Fransiskus Xavierus, S.Kom., M.Kom',
            'bidang_penelitian' => 'Geographic Information System, ',
            'keywords' => 'Geographic Information System (GIS), Spatial Data, Geolocation, Mapping, Raster Data, Vector Data, Digital Image Processing, Image Segmentation, Image Classification, Feature Extraction, Image Enhancement, Spatial Analysis, Data Visualization, Geospatial Technology, Computer Vision (dasar), Decision Support System (DSS)',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 3 - Sistem Pendukung Keputusan
        $user3 = User::create([
            'username' => 'ibu selfina',
            'name' => 'Ir. Selfina Pare, S.Kom., M.T',
            'email' => 'Selfina@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456791',
        ]);

        Dosen::create([
            'user_id' => $user3->id,
            'nidn' => '0123456791',
            'nama' => 'Ir. Selfina Pare, S.Kom., M.T',
            'bidang_penelitian' => 'Sistem Pendukung Keputusan',
            'keywords' => 'Konsep Support SPK, Komponen Utama SPK, Tipe Modul dalam SPK, Metode-Metode SPK, Elemen Keputusan, Proses Pengambilan Keputusan, Teknik Analisis Data dalam SPK, Teknologi Pendukung',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 4 - Rekayasa Perangkat Lunak
        $user4 = User::create([
            'username' => 'pak hasbi',
            'name' => 'Muhammad Hasbi, M.Kom',
            'email' => 'Hasbi@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456792',
        ]);

        Dosen::create([
            'user_id' => $user4->id,
            'nidn' => '0123456792',
            'nama' => 'Muhammad Hasbi, M.Kom',
            'bidang_penelitian' => 'Rekayasa Perangkat Lunak',
            'keywords' => 'Software Process & Methodology, Requirements Engineering, Software Design & Architecture, Software Testing & Quality Assurance, Software Project Management, Software Maintenance & Evolution, Human-Computer Interaction (HCI) / UI/UX, Software Metrics & Evaluation, Modeling & Simulation, Software Security',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 5 - Sistem Pakar
        $user5 = User::create([
            'username' => 'ibu tatik',
            'name' => 'Ir. Tatik Melinda Tallulembang, S.Kom,. M.T',
            'email' => 'Tatik@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456793',
        ]);

        Dosen::create([
            'user_id' => $user5->id,
            'nidn' => '0123456793',
            'nama' => 'Ir. Tatik Melinda Tallulembang, S.Kom,. M.T',
            'bidang_penelitian' => 'Sistem Pakar',
            'keywords' => 'Sistem Pakar, Kecerdasan Buatan, Basis Pengetahuan, Inferensi, Mesin Inferensi, Rule-Based System, Forward Chaining, Backward Chaining, Knowledge Acquisition, Knowledge Representation, Decision Support System, Diagnosa Otomatis, Expert System Shell',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 6 - Data Analitik dan Pembelajaran Mesin
        $user6 = User::create([
            'username' => 'pak jarot',
            'name' => 'Ir. Jarot Budiasto, S.T., M.T',
            'email' => 'jarot@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456794',
        ]);

        Dosen::create([
            'user_id' => $user6->id,
            'nidn' => '0123456794',
            'nama' => 'Ir. Jarot Budiasto, S.T., M.T',
            'bidang_penelitian' => 'Data Analitik dan Pembelajaran Mesin',
            'keywords' => 'Data Analytics, Machine Learning, Data Mining, Big Data, Classification, Regression, Clustering, Predictive Modeling, Feature Engineering, Data Preprocessing, Model Evaluation, Artificial Intelligence, Deep Learning, Neural Network, Data Visualization',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        // Dosen 7 - Pembelajaran Mendalam Pada Pengolahan Citra Di Bidang Pertanian
        $user7 = User::create([
            'username' => 'pak agustan',
            'name' => 'Ir. Agustan Latif S.Kom., M.Cs',
            'email' => 'agustan@unmus.ac.id',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'nidn' => '0123456795',
        ]);

        Dosen::create([
            'user_id' => $user7->id,
            'nidn' => '0123456795',
            'nama' => 'Ir. Agustan Latif S.Kom., M.Cs',
            'bidang_penelitian' => 'Pembelajaran Mendalam Pada Pengolahan Citra Di Bidang Pertanian',
            'keywords' => 'Deep Learning, Computer Vision, Digital Image Processing, Convolutional Neural Network (CNN), Image Classification, Image Segmentation, Feature Extraction, Agricultural Image Analysis, Plant Disease Detection, Crop Monitoring, Data Preprocessing, Model Training, Neural Networks',
            'kuota_bimbingan' => 10,
            'kuota_terpakai' => 0,
        ]);

        
    }
}