<?php

namespace App\Http\Controllers;

use App\Dondathang;
use App\Nhacungcap;
use App\Phieunhap;
use App\Sanpham;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class PhieunhapController extends Controller
{
    //
    public function dsPhieuNhap(Request $request)
    {
        if ($request->ajax()) {
            $pn = Phieunhap::all();
            return  DataTables::of($pn)
                ->addColumn('action', function ($pn) {
                    return '<a href="javascript:void(0);" id="delete" data-toggle="tooltip"
                    data-original-title="Delete" data-id="' . $pn->id . ' " class="delete">
                    <i class="fas fa-trash-alt"></i></a>';
                })->addColumn('tenncc', function ($pn) {
                    $ncc = Nhacungcap::find($pn->id_ncc);
                    return $ncc->tenncc;
                })->addColumn('tongtien', function ($pn) {
                    $total = 0;
                    foreach ($pn->sanpham as $item) {
                        $total += $item->pivot->soluong * $item->pivot->gianhap;
                    }
                    return number_format($total, 0, '.', '.');
                })->editColumn('id', function ($pn) {
                    return '<a href="' . URL('/admin/danhsachsanpham-detail/' . $pn->id) . '" class="link text-primary">' . $pn->id . '</a>';
                })->editColumn('tennv', function ($pn) {
                    $user = User::find($pn->id_user);
                    return $user->name;
                })->editColumn('thanhtoan', function ($pn) {
                    if ($pn->thanhtoan == 1) {
                        return '<span class="text-success"> Đã thanh toán <span/>';
                    } else {
                        return '<span class="text-warning"> Chưa thanh toán <span/>';
                    }
                })->editColumn('trangthai', function ($pn) {
                    if ($pn->trangthai == 1) {
                        return '<span class="text-success"> Hoàn thành <span/>';
                    } else {
                        return '<span class="text-warning"> Đang giao dịch <span/>';
                    }
                })->rawColumns(['id', 'trangthai', 'action', 'tenncc', 'tongtien', 'thanhtoan', 'tennv'])->make(true);
        }
        return view('pages_admin.nhaphang.list_phieunhap');
    }
    public function delete($id)
    {
        $delete_pn = Phieunhap::find($id)->delete();
        return response()->json($delete_pn);
    }
    public function formAdd()
    {
        $ncc = Nhacungcap::all();
        return view("pages_admin.nhaphang.add_phieunhap", compact("ncc"));
    }
    public function infoNhaCungCap($id)
    {
        $nhacungcap = Nhacungcap::find($id);
        return response()->json($nhacungcap);
    }
    public function searchSanPham($id)
    {
        $sanpham = Sanpham::with('size')->where('tensp', 'like', '%' . $id . '%')->get();
        return view("pages_admin.nhaphang.search", compact('sanpham'));
    }
}
