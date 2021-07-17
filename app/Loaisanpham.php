<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaisanpham extends Model
{
    //
    protected $table = 'loaisanpham';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenloai', 'slug'
    ];

    public function sanpham()
    {
        return $this->hasMany(Sanpham::class, 'id_lsp');
    }
    public function thuonghieu()
    {
        return $this->hasMany(thuonghieu::class, 'id_lsp');
    }
}
