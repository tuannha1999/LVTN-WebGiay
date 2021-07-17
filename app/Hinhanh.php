<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hinhanh extends Model
{
    protected $table = 'hinhanh';
    protected $primaryKey = 'id';
    protected $casts = ['name' => 'array'];
    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'id_sp');
    }
}
