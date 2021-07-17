<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thuonghieu extends Model
{
    //
    protected $table = 'thuonghieu';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'ten', 'slug'
    ];
    public function sanpham()
    {
        return $this->hasMany(Sanpham::class, 'id_th');
    }
    public function danhmuc()
    {
        return $this->belongsTo(Danhmuc::class, 'id_lsp');
    }
}
