<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sanpham;
use App\Chitietdondathang;
use App\Dondathang;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    //
    public function index()
    {
        $sp = Sanpham::where('madm', '1')->orderby('masp', 'desc')->paginate(4);
        $sp_banchay = Sanpham::orderby('daban', 'desc')->paginate(4);
        return view('pages.home', compact('sp', 'sp_banchay'));
    }
    public function search(Request $request)
    {
        $search = Sanpham::where('tensp', 'like', '%' . $request->search . '%')->get();
        return view('pages.search', compact('search'));
    }
}
