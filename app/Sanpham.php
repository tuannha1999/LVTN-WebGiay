<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    //
    protected $table = 'sanpham';
    protected $primaryKey = 'masp';
    public function danhmuc()
    {
        return $this->belongsTo(Danhmuc::class, 'madm');
    }
    public function loaisanpham()
    {
        return $this->belongsTo(Loaisanpham::class, 'maloai');
    }
    public function dondathang()
    {
        return $this->belongsToMany(Dondathang::class, 'chitietdondathang', 'madh', 'masp');
    }
    public function size()
    {
        return $this->hasMany(Size::class, 'masp');
    }
}
