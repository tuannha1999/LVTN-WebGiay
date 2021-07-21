<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Khuyenmai extends Model
{
    //
    protected $table = 'khuyenmai';
    protected $primaryKey = 'id';
    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }
}
