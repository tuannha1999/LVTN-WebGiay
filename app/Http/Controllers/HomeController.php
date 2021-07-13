<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sanpham;
use App\Loaisanpham;
use App\Dondathang;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    //
    public function index()
    {
        $loai_sp = Loaisanpham::all();
        $sp = Sanpham::with('Hinhanh')->with('size')->where('trangthai', 1)->where('id_lsp', 1)->orderby('id', 'desc')->paginate(8);
        $sp_banchay = Sanpham::with('Hinhanh')->with('size')->where('trangthai', 1)->orderby('daban', 'desc')->paginate(8);
        return view('pages.home', compact('sp', 'sp_banchay', 'loai_sp'));
    }
    public function search(Request $request)
    {
        $loai_sp = Loaisanpham::all();
        $search = Sanpham::with('Hinhanh')->with('size')->where('tensp', 'like', '%' . $request->search . '%')->get();
        return view('pages.search', compact('search', 'loai_sp'));
    }
}
