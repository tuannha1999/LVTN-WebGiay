<?php

namespace App\Http\Controllers;

use App\Khuyenmai;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KhuyenmaiController extends Controller
{
    //
    public function getdsKhuyenMai(Request $req)
    {
        if ($req->ajax()) {
            $khuyenmai = Khuyenmai::all();
            return  DataTables::of($khuyenmai)
                ->addColumn('action', function ($khuyenmai) {
                    return '<a href="javascript:void(0);" id="delete-khuyenmai" data-id="' . $khuyenmai->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>
                    <a href="javascript:void(0);" id="edit-khuyenmai" data-toggle="modal" data-id=' . $khuyenmai->id . '>
                    <i class="far fa-2x fa-edit"></i></a>';
                })->editColumn('trangthai', function ($khuyenmai) {
                    if ($khuyenmai->trangthai == 1) {
                        return '<span class="text-success">Đang chạy</span>';
                    } else {
                        return '<span class="text-warning">Tạm ngưng</span>';
                    }
                })->rawColumns(['action', 'trangthai'])->make(true);
        }
        return view('pages_admin.khuyenmai.list_khuyenmai');
    }
}
