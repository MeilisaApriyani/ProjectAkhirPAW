<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::create([
            'email' => 'sumberelektronik@gmail.com',
            'password' => bcrypt('elektronik'),
            'level' => 'admin',
        ]);
    }
}

