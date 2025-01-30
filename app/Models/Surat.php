<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, HasUlids;
    use SoftDeletes;

    protected $table = 'surat';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
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
}
