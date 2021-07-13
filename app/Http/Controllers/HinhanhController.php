<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hinhanh;

class HinhanhController extends Controller
{
    //
    public function delete($id)
    {
        //
        $anh = Hinhanh::where('id', $id)->delete();
        return back();
    }
    public function avatar($id, $id_sp)
    {
        //
        $anh = Hinhanh::find($id);
        $anh->avt = 1;
        $anh->save();
        $img_avt = Hinhanh::all()->where('id_sp', $id_sp)->whereNotIn('id', $id);
        foreach ($img_avt as $item) {
            $item->avt = 0;
            $item->save();
        }
        return back();
    }
}
