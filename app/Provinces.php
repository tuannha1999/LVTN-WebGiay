<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    //
    protected $table = 'provinces';
    protected $primaryKey = 'id';
    public function sanpham()
    {
        return $this->belongsToMany(Sanpham::class, 'chitietdondathang', 'madh', 'masp');
    }
}