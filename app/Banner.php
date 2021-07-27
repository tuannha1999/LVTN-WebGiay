<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    protected $table = 'banner';
    protected $primaryKey = 'id';
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
