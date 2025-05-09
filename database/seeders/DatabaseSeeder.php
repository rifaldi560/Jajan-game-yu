<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Seeder dengan penggunaan 'role' alih-alih 'type'
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin', // Menggunakan role sebagai string
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'role' => 'user', // User biasa
                'password' => bcrypt('123456'),
            ],
        ];

        // Menambahkan setiap pengguna ke dalam tabel 'users'
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
