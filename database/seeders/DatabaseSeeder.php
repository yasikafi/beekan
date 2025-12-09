<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bikin Akun BUYER (Buat kamu login nanti)
        User::create([
            'name' => 'binusian',
            'email' => 'binusian@binus.ac.id',
            'password' => Hash::make('password'), // Passwordnya 'password'
            'role' => 'buyer'
        ]);

        // 2. Bikin Akun SELLER 1: Bakmie Nikmat
        $seller1 = User::create([
            'name' => 'Bakmie Nikmat',
            'email' => 'bakmie@binus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'shop_name' => 'Bakmie Nikmat'
        ]);

        // Isi Menu Bakmie Nikmat
        Product::create([
            'user_id' => $seller1->id,
            'name' => 'Bakmie Ayam',
            'price' => 25000,
            'description' => 'Bakmie kenyal dengan topping ayam cincang gurih.',
            'stock' => 50,
            'image_color' => 'linear-gradient(135deg, #ffeaa7, #fab1a0)'
        ]);
        Product::create([
            'user_id' => $seller1->id,
            'name' => 'Bakmie Spesial',
            'price' => 30000,
            'description' => 'Komplit pakai ayam, jamur, bakso, dan pangsit.',
            'stock' => 40,
            'image_color' => 'linear-gradient(135deg, #81ecec, #74b9ff)'
        ]);

        // 3. Bikin Akun SELLER 2: Cerita Kopi
        $seller2 = User::create([
            'name' => 'Barista Kopi',
            'email' => 'kopi@binus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'shop_name' => 'Cerita Kopi'
        ]);

        // Isi Menu Cerita Kopi
        Product::create([
            'user_id' => $seller2->id,
            'name' => 'Es Kopi Susu Gula Aren',
            'price' => 18000,
            'description' => 'Seger banget buat nemenin nugas.',
            'stock' => 100,
            'image_color' => 'linear-gradient(135deg, #fdcb6e, #e17055)'
        ]);

        // 4. Bikin Akun SELLER 3: Good Waffle
        $seller3 = User::create([
            'name' => 'Waffle Chef',
            'email' => 'waffle@binus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'shop_name' => 'Good Waffle'
        ]);

        Product::create([
            'user_id' => $seller3->id,
            'name' => 'Waffle Cokelat',
            'price' => 32000,
            'description' => 'Waffle renyah saus cokelat belgian.',
            'stock' => 20,
            'image_color' => 'linear-gradient(135deg, #dfe6e9, #b2bec3)'
        ]);
    }
}