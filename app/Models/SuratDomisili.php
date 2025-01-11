<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDomisili extends Model
{
    use HasFactory;

    protected $table = 'surat_domisili';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'keperluan',
        'no_whatsapp',
    ];
}
