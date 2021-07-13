<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nhacungcap extends Model
{
    //
    protected $table = 'nhacungcap';
    protected $primaryKey = 'id';
    public function phieunhap()
    {
        return $this->hasMany(Phieunhap::class, 'id_ncc');
    }
}
