<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Danhmuc extends Model
{
    //
    protected $table = 'danhmuc';
    protected $primaryKey = 'madm';
    public function sanpham()
    {
        return $this->hasMany(Sanpham::class, 'madm');
    }
}
