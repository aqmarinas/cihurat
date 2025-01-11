<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Authenticatable
{
    use HasFactory, Notifiable; // Tambahkan Notifiable jika kamu menggunakan fitur notifikasi

    protected $table = 'siswa'; // Pastikan ini sesuai dengan nama tabel di database

    protected $fillable = [
        'nama', // Sesuaikan dengan nama kolom di database (pastikan 'name' diubah menjadi 'nama')
        'kelas',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime', // Jika kamu menambahkan kolom ini di database
    ];

    // Jika ada relasi yang ingin ditambahkan, contohnya:
    // public function kegiatan()
    // {
    //     return $this->hasMany(Kegiatan::class);
    // }
}
