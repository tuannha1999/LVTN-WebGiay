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
        $thongke = Thongke::whereBetween('ngaydat', [$ngaybd, $ngaykt])->get();
        return $thongke;
    }
    public function loc7ngay()
    {
        $range = Carbon::now()->subDays(7);
        $thongke = Thongke::where('ngaydat', '>=', $range)->get();
        return $thongke;
    }
}
