<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phieunhap extends Model
{
    //
    protected $table = 'phieunhaphang';
    protected $primaryKey = 'id';

    public function sanpham()
    {
        return $this->belongsToMany(Sanpham::class, 'chitietphieunhap', 'id_pn', 'id_sp')->withPivot('soluong', 'gianhap', 'size');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function nhacungcap()
    {
        return $this->belongsTo(Nhacungcap::class, 'id_ncc');
    }
}
