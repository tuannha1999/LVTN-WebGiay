<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //
    protected $table = 'size';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'id_sp');
    }
}
