<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKematian extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'surat_kematian';

    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'id',
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

    public function surat()
    {
        return $this->morphOne(Surat::class, 'suratable');
    }
}
