<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        Admin::truncate(); 
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 

        $users = [
            [
                'name' => "Admin ",
                'email' => "admin@test.com",
                'role' => "admin",
                'password' => Hash::make('123'),
            ],
            [
                'name' => "Admin1 ",
                'email' => "admin1@test.com",
                'role' => "admin",
                'password' => Hash::make('123'),
            ],
            [
                'name' => "Alif",
                'email' => "alif@gmail.com",
                "role" => "rt",
                'password' => Hash::make('123'),
            ],
            [
                'name' => "ummar",
                'email' => "ummar@gmail.com",
                "role" => "pengguna",
                'password' => Hash::make('123'),
            ],

        ];

        foreach ($users as $user) {
            Admin::create($user);
        }
    }
}
