<?php

namespace App\Http\Controllers;

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
    public function loc7ngay()
    {
        $total = 0;
        $range = Carbon::now()->subDays(7);
        $thongke = Thongke::where('ngaydat', '>=', $range)->get();
        foreach ($thongke as $value) {
            $total += $value->doanhthu;
        }
        return response()->json(['thongke' => $thongke, 'total' => $total]);
    }
}
