<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = [
            [
                'nama' => 'User 1',
                'nik' => '3173317331733173',
                'email' => 'user@gmail.com',
                'nomor_whatsapp' => '08123456789',
                'rt_rw' => '01/01',
                'role' => 'pengguna',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Admin',
                'nik' => '31739',
                'email' => 'admin@gmail.com',
                'nomor_whatsapp' => '081234567890',
                'rt_rw' => '01/01',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'RT',
                'email' => 'rt@gmail.com',
                'nomor_whatsapp' => '0812345678911',
                'rt_rw' => '01/01',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Ijan Supriadi',
                'email' => 'ijan@gmail.com',
                'nomor_whatsapp' => '0812345678912',
                'rt_rw' => '01/01',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Olih Solihin',
                'email' => 'olih@gmail.com',
                'nomor_whatsapp' => '0812345678913',
                'rt_rw' => '02/01',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Hasim Asari',
                'email' => 'hasim@gmail.com',
                'nomor_whatsapp' => '0812345678914',
                'rt_rw' => '03/02',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Reno',
                'email' => 'reno@gmail.com',
                'nomor_whatsapp' => '0812345678915',
                'rt_rw' => '04/02',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Nasruddin',
                'email' => 'nasrudiin@gmail.com',
                'nomor_whatsapp' => '0812345678916',
                'rt_rw' => '05/03',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Totong',
                'email' => 'totong@gmail.com',
                'nomor_whatsapp' => '0812345678917',
                'rt_rw' => '06/03',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Rudi Hartono',
                'email' => 'rudi@gmail.com',
                'nomor_whatsapp' => '0812345678918',
                'rt_rw' => '07/04',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
            [
                'nama' => 'Sholeh',
                'email' => 'sholeh@gmail.com',
                'nomor_whatsapp' => '0812345678919',
                'rt_rw' => '08/04',
                'role' => 'rt',
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
