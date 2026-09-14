<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Owner', 'email' => 'owner@toko.com', 'password' => Hash::make('password123'), 'role' => 'owner']);
        User::create(['name' => 'Kasir', 'email' => 'kasir@toko.com', 'password' => Hash::make('password123'), 'role' => 'kasir']);
        User::create(['name' => 'Gudang', 'email' => 'gudang@toko.com', 'password' => Hash::make('password123'), 'role' => 'gudang']);
    }
}