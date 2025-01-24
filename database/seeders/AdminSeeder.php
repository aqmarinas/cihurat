<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        Admin::truncate(); 
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 

        $admins = [
            [
                'nama' => "Admin ",
                'email' => "admin@test.com",
                'role' => "admin",
                'password' => Hash::make('123'),
            ],
            [
                'nama' => "Admin1 ",
                'email' => "admin1@test.com",
                'role' => "admin",
                'password' => Hash::make('123'),
            ],
            [
                'nama' => "Alif",
                'email' => "alif@gmail.com",
                "role" => "rt",
                'password' => Hash::make('123'),
            ],
            [
                'nama' => "ummar",
                'email' => "ummar@gmail.com",
                "role" => "pengguna",
                'password' => Hash::make('123'),
            ],
            [
                'nama' => "rina",
                'email' => "rina@gmail.com",
                "role" => "pengguna",
                'password' => Hash::make('123'),
            ],

        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
