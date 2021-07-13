<?php

namespace App\Http\Controllers;

use App\Thuonghieu;
use App\Loaisanpham;
use Illuminate\Http\Request;

class ThuonghieuController extends Controller
{
    //
    public function index($loai)
    {
        $loai_sp = Loaisanpham::all();
        $thuonghieu = Thuonghieu::all();
        $loai = Thuonghieu::with('sanpham')->where('ten', $loai)->first();
        return view('pages.sanpham.loai_sp', compact('loai_sp', 'loai', 'thuonghieu'));
    }
}
