<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'pegawai',
            'nip' => 72190344,
            'email' => 'pegawai@gmail.com',
            'password' => bcrypt('pg12345678'),
            'role' => 0
        ],
            ['name' => 'kadiv',
            'nip' => 72190334,
            'email' => 'kadiv@gmail.com',
            'password' => bcrypt('kd12345678'),
            'role' => 1
        ],
            ['name' => 'pimpinan',
            'nip' => 72190333,
            'email' => 'pimpinan@gmail.com',
            'password' => bcrypt('pp12345678'),
            'role' => 2
        ],
     ];
     foreach ($users as $user) {
        User::create($user);
     }
    }
}
