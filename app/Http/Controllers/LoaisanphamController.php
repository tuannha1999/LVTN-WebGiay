<?php

namespace App\Http\Controllers;

use App\Loaisanpham;
use App\Thuonghieu;
use Illuminate\Http\Request;

class LoaisanphamController extends Controller
{
    //
    public function index($loai)
    {
        $loai_sp = Loaisanpham::all();
        $thuonghieu = Thuonghieu::all();
        $loai = Loaisanpham::with('sanpham')->where('slug', $loai)->first();
        return view('pages.sanpham.loai_sp', compact('loai_sp', 'loai', 'thuonghieu'));
    }
    public function changelist($id)
    {
        $loai = Thuonghieu::all()->where('id_lsp', $id);
        //dd($loai);
        return response()->json($loai);
    }
}
