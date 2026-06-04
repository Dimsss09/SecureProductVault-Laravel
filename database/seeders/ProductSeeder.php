<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed sample product data for demos and documentation screenshots.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Secure USB Drive 64GB',
                'description' => 'Encrypted USB drive untuk penyimpanan data penting.',
                'price' => 250000,
            ],
            [
                'name' => 'Password Manager License',
                'description' => 'Lisensi aplikasi password manager untuk pengguna personal.',
                'price' => 150000,
            ],
            [
                'name' => 'Hardware Security Key',
                'description' => 'Security key untuk autentikasi multi-factor berbasis hardware.',
                'price' => 450000,
            ],
            [
                'name' => 'Web Security Audit',
                'description' => 'Paket audit keamanan dasar untuk aplikasi web.',
                'price' => 1500000,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}