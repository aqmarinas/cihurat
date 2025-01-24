<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'user_id',
        'rt_rw',
        'suratable_type',
        'suratable_id',
        'jenis_surat',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suratable()
    {
        return $this->morphTo();
    }

    // public function rt()
    // {
    //     return $this->belongsTo(User::class, 'rt_id');
    // }
}
