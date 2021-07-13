<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaisanpham extends Model
{
    //
    protected $table = 'Loaisanpham';
    protected $primaryKey = 'id';
    public function sanpham()
    {
        return $this->hasMany(Sanpham::class, 'id_lsp');
    }
    public function thuonghieu()
    {
        return $this->hasMany(thuonghieu::class, 'id_lsp');
    }
}
