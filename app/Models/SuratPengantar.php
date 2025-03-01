<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'surat_pengantar';

    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'id',
        'nama',
        'nik',
        'no_whatsapp',
        'ttl',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'keperluan',
        'rt',
        'rw',
        'ketua_rw',
        'ketua_rt',
        'ktp',
        'kk'
    ];

    public function surat()
    {
        return $this->morphOne(Surat::class, 'suratable');
    }
}
