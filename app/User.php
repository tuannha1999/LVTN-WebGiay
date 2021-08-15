<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'sdt', 'is_admin', 'yeuthich', 'phantram',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function phieunhap()
    {
        return $this->hasMany(Phieunhap::class, 'id_user');
    }
    public function phieutra()
    {
        return $this->hasMany(Phieutra::class, 'id_user');
    }
    public function dondathang()
    {
        return $this->hasMany(Dondathang::class, 'id_kh');
    }
    public function khuyenmai()
    {
        return $this->hasMany(khuyenmai::class, 'id_user');
    }
    public function sanpham()
    {
        return $this->belongsToMany(Sanpham::class, 'yeuthich', 'id_user', 'id_sp')->withPivot('img', 'size');
    }
}
