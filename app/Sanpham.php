<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    //
    protected $table = 'sanpham';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    public function thuonghieu()
    {
        return $this->belongsTo(Thuonghieu::class, 'id_th');
    }
    public function phieunhap()
    {
        return $this->belongsToMany(Phieunhap::class, 'chitietphieunhap', 'id_pn', 'id_sp')->withPivot('soluong');
    }
    public function loaisanpham()
    {
        return $this->belongsTo(Loaisanpham::class, 'id_lsp');
    }
    public function dondathang()
    {
        return $this->belongsToMany(Dondathang::class, 'chitietdondathang', 'id_dh', 'id_sp')->withPivot('soluong');
    }
    public function size()
    {
        return $this->hasMany(Size::class, 'id_sp');
    }
    public function hinhanh()
    {
        return $this->hasMany(Hinhanh::class, 'id_sp');
    }
}
