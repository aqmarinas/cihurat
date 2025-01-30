<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDomisili extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'surat_domisili';

    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'id',
        'nama',
        'nik',
        'ttl',
        'status_kawin',
        'agama',
        'pekerjaan',
        'alamat',
        'keperluan',
        'no_whatsapp',
        'ktp',
        'kk',
    ];

    public function surat()
    {
        return $this->morphOne(Surat::class, 'suratable');
    }
}
