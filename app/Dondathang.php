<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dondathang extends Model
{
    //
    protected $table = 'dondathang';
    protected $primaryKey = 'madh';
    public function sanpham()
    {
        return $this->belongsToMany(Sanpham::class, 'chitietdondathang', 'madh', 'masp');
    }
}
