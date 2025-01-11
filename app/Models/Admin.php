<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';


    public function courses()
    {
        return $this->hasMany(Course::class, 'admin_id');
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'admin_id');
    }
    public function logo()
    {
        return $this->hasMany(Logo::class, 'admin_id');
    }


    protected $fillable = [
        'name',
        'foto_profil',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
