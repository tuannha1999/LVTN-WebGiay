<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chitietdondathang extends Model
{
    //
    protected $table = 'chitietdondathang';
    protected $primaryKey = 'id_dh';

    public function dondathang()
    {
        return $this->belongsTo(Dondathang::class, 'id_dh');
    }
    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'id_sp');
    }
}
