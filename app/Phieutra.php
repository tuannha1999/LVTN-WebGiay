<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phieutra extends Model
{
    //
    protected $table = 'phieutrahang';
    protected $primaryKey = 'id';

    public function sanpham()
    {
        return $this->belongsToMany(Sanpham::class, 'chitietphieutra', 'id_pt', 'id_sp')->withPivot('soluong', 'size');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function dondathang()
    {
        return $this->belongsTo(Dondathang::class, 'id_dh');
    }

   
}
