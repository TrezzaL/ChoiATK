<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category; // Pastikan Model Category di-import
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seeder untuk User (Admin & Pelanggan)
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'phone' => '082115377730',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelanggan@gmail.com'],
            [
                'name' => 'Pelanggan',
                'phone' => '082115377730',
                'password' => Hash::make('pelanggan123'),
                'role' => 'pelanggan',
            ]
        );

        // 2. Seeder Otomatis untuk Kategori Produk
        $categories = [
            [
                'nama' => 'Pengarsipan & Penyimpanan',
                'deskripsi' => 'Map plastik, map snelhechter, ordner tebal, map folder, dll.'
            ],
            [
                'nama' => 'Peralatan Kantor & Sekolah',
                'deskripsi' => 'Gunting, cutter, penggaris (plastik/besi), stapler, dll.'
            ],
            [
                'nama' => 'Kertas & Pembukuan',
                'deskripsi' => 'Kertas HVS (A4, F4/Folio), buku tulis sekolah, nota, dll.'
            ],
            [
                'nama' => 'Alat Tulis & Koreksi',
                'deskripsi' => 'Pensil, pulpen (gel/biasa), spidol papan tulis (whiteboard), tipe-x, dll.'
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['nama' => $category['nama']], // Acuan pencarian agar tidak dobel
                ['deskripsi' => $category['deskripsi']] // Data yang diupdate/dibuat
            );
        }
    }
}
