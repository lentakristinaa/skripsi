<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'sisa_ct',
        'tgl_lahir',
        'tgl_msk',
        'golongan',
        'jabatan',
        'alamat',
        'jns_kelamin'
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

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn($value) => ['pegawai', 'kadiv', 'pimpinan'][$value],
        );
    }

    public function ctAlpen()
    {
        return $this->hasMany(CtAlpen::class, 'id_user');
    }

    public function ctBsr()
    {
        return $this->hasMany(CtBsr::class, 'id_user');
    }

    public function ctDtn()
    {
        return $this->hasMany(CtDtn::class, 'id_user');
    }

    public function ctSkt()
    {
        return $this->hasMany(CtSkt::class, 'id_user');
    }

    public function ctThn()
    {
        return $this->hasMany(CtThn::class, 'id_user');
    }

    public function ctSln()
    {
        return $this->hasMany(CtSln::class, 'id_user');
    }
}
