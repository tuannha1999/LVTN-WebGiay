<?php

namespace App\Http\Controllers;

use App\Danhmuc;
use Illuminate\Http\Request;
use App\Sanpham;
use App\Size;

class SanphamController extends Controller
{
    //
    public function all_sanpham()
    {
        $all_sp = Sanpham::all();
        $danhmuc = Danhmuc::all();
        $danhmuc_phu = Danhmuc::all()->whereNotIn('loaidm', 0);
        return view('pages.sanpham.all_sanpham', compact('all_sp', 'danhmuc', 'danhmuc_phu'));
    }
    public function chitiet_sp($id)
    {
        $sp = Sanpham::with('danhmuc')->orderby('masp', 'desc')->paginate(4);
        $chitiet_sp = Sanpham::with('size')->where('masp', $id)->first();
        $size = Size::where('masp', $id)->get();
        return view('pages.sanpham.chitiet_sanpham', compact('chitiet_sp', 'sp', 'size'));
    }
    public function loai_sp($id_loai)
    {
        $danhmuc = Danhmuc::all();
        $loai_sp = Sanpham::where('madm', $id_loai)->get();
        return view('pages.sanpham.loai_sp', compact('loai_sp', 'danhmuc'));
    }
}
