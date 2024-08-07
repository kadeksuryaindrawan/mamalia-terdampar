<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'password' => bcrypt('admin123'),
            'email' => 'admin@gmail.com',
            'no_telp' => '08761732343',
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Pelapor',
            'password' => bcrypt('pelapor123'),
            'email' => 'pelapor@gmail.com',
            'no_telp' => '08761762836',
            'role' => 'pelapor'
        ]);

        User::create([
            'nama' => 'Yayasan',
            'password' => bcrypt('yayasan123'),
            'email' => 'yayasan@gmail.com',
            'no_telp' => '08761732334',
            'role' => 'yayasan'
        ]);
    }
}
