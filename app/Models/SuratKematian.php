<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKematian extends Model
{
    use HasFactory;

    protected $table = 'surat_kematian';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'alamat',
        'no_whatsapp',
        'hari_meninggal',
        'tanggal_meninggal',
        'tempat_meninggal',
        'sebab_meninggal',
        'ktp',
        'kk',
    ];
}
