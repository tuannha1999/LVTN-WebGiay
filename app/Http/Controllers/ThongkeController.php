<?php

namespace App\Http\Controllers;

use App\Sanpham;
use App\Thongke;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThongkeController extends Controller
{
    //
    public function thongke()
    {
        return view("pages_admin.thongke.thongke");
    }
    public function locngay($ngaybd, $ngaykt)
    {
        $total = 0;
        $thongke = Thongke::whereBetween('ngaydat', [$ngaybd, $ngaykt])->get();
        foreach ($thongke as $value) {
            $total += $value->doanhthu;
        }
        return response()->json(['thongke' => $thongke, 'total' => $total]);
    }
    public function loc30ngay()
    {
        $total = 0;
        $range = Carbon::now()->subDays(30);
        $thongke = Thongke::where('ngaydat', '>=', $range)->get();
        $banchay = Sanpham::orderBy('daban', 'desc')->limit(5)->get(['tensp', 'daban']);
        foreach ($thongke as $value) {
            $total += $value->doanhthu;
        }
        return response()->json(['thongke' => $thongke, 'total' => $total, 'banchay' => $banchay]);
    }
}
