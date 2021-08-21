<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use App\Sanpham;
use App\Loaisanpham;
use App\Dondathang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    //
    public function index()
    {
        $banner = Banner::where('trangthai', 1)->orderBy('id', 'desc')->get();
        $loai_sp = Loaisanpham::all();
        $sp = Sanpham::with('Hinhanh')->with('size')->with('loaisanpham')->where('trangthai', 1)->orderby('id', 'desc')->paginate(8);
        //dd($sp);
        $sp_banchay = Sanpham::with('Hinhanh')->with('loaisanpham')->with('size')
            ->where('trangthai', 1)->orderby('daban', 'desc')->paginate(8);
        return view('pages.home', compact('sp', 'sp_banchay', 'loai_sp', 'banner'));
    }

    public function search(Request $request)
    {
        $loai_sp = Loaisanpham::all();
        $search = Sanpham::with('Hinhanh')->with('size')->where('tensp', 'like', '%' . $request->search . '%')->where('trangthai', 1)->get();
        return view('pages.search', compact('search', 'loai_sp'));
    }
    
    public function formsearchDonHang()
    {
        $loai_sp = Loaisanpham::all();
        return view('pages.dathang.form_search', compact('loai_sp'));
    }

    public function searchDonHang(Request $req)
    {
        $loai_sp = Loaisanpham::all();
        $search = Dondathang::where('id', $req->search)->orwhere('sdt', $req->search)->orderby('id', 'desc')->get();
        //dd($search);
        return view('pages.dathang.kq_search', compact('loai_sp', 'search'));
    }
    public function gioiThieu()
    {
        $loai_sp = Loaisanpham::all();
        return view('gioithieu', compact('loai_sp'));
    }
    public function hinhThucThanhToan()
    {
        $loai_sp = Loaisanpham::all();
        return view('hinhthucthanhtoan', compact('loai_sp'));
    }
}
