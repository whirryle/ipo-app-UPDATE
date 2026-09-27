<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'username', 'password_hash', 'full_name', 'no_whatsapp', 'role',
        'province_id', 'city_id', 'district_id',
        'totp_secret', 'totp_aktif', 'remember_token'
    ];

    protected $hidden = ['password_hash'];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdminCity(): bool
    {
        return $this->role === 'admin_city';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function isOperatorOrAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin_city', 'operator'], true);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id');
    }
}
