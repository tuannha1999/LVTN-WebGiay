<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dondathang extends Model
{
    //
    protected $table = 'dondathang';
    protected $primaryKey = 'id';

    public function sanpham()
    {
        return $this->belongsToMany(Sanpham::class, 'chitietdondathang', 'id_dh', 'id_sp')->withPivot('soluong', 'size', 'img', 'giaban');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_kh');
    }
    public function phieutra()
    {
        return $this->hasMany(phieutra::class, 'id_dh');
    }
    public function user1()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
