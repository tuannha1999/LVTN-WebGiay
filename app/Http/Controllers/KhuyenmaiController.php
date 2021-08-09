<?php

namespace App\Http\Controllers;

use App\Khuyenmai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
                    return '<a href="' . URL('/admin/dskhuyenmai-detail/' . $khuyenmai->id) . '">
                     <i class="far fa-2x fa-edit"></i></a>
                        <a href="javascript:void(0);" id="delete-khuyenmai" data-id="' . $khuyenmai->id . ' " class="delete">
                        <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->addColumn('hethan', function ($khuyenmai) {
                    if ($khuyenmai->ngaykt >= Carbon::now()) {
                        return '<span class="text-success">Còn hạn</span>';
                    } else {
                        return '<span class="text-warning">Hết hạn</span>';
                    }
                })->editColumn('trangthai', function ($khuyenmai) {
                    if ($khuyenmai->trangthai == 1 && $khuyenmai->ngaykt >= Carbon::now()) {
                        return '<span class="text-success">Đang chạy</span>';
                    } else {
                        return '<span class="text-warning">Đã ngưng</span>';
                    }
                })->rawColumns(['action', 'trangthai', 'hethan'])->make(true);
        }
        return view('pages_admin.khuyenmai.list_khuyenmai');
    }

    public function getformMaGiamGia()
    {
        return view("pages_admin.khuyenmai.magiamgia");
    }

    public function addKhuyenmai(Request $req)
    {
        $req->old('tenkm', 'ngaybd', 'ngaykt', 'macode', 'dieukien', 'tiengiam');
        $this->validate(
            $req,
            [
                'tenkm' => 'required',
                'dieukien' => 'required',
                'macode' => 'required|unique:khuyenmai,macode|min:6',
                'tiengiam' => 'required',
                'ngaybd' => 'required',
                'ngaykt' => 'required|after:ngaybd',

            ],
            [

                'tenkm.required' => 'Tên khuyến mãi không được để trống',
                'dieukien.required' => 'Điều kiện không được để trống',
                'macode.required' => 'Mã giảm giá không được để trống',
                'macode.unique' => 'Mã giảm giá đã tồn tại',
                'macode.min' => 'Mã giảm giá phải lớn hơn 6 kí tự',
                'tiengiam.required' => 'Tiền giảm không được để trống',
                'ngaybd.required' => 'Ngày bắt đầu không được để trống',
                'ngaykt.required' => 'Ngày kết thúc không được để trống',
                'ngaykt.after' => 'Ngày kết thúc phải sau ngày bắt đầu',


            ]
        );
        $new_coupons = new Khuyenmai();
        $new_coupons->tenkm = $req->tenkm;
        $new_coupons->macode = $req->macode;
        $new_coupons->ngaybd = $req->ngaybd;
        $new_coupons->ngaykt = $req->ngaykt;
        $new_coupons->dieukien = $req->dieukien;
        $new_coupons->tiengiam = $req->tiengiam;
        $new_coupons->trangthai = $req->ngaybd > Carbon::now() ? 0 : 1;
        $new_coupons->id_user = Auth::user()->id;
        $new_coupons->save();
        return redirect("/admin/dskhuyenmai")->with('success', 'Đã tạo mã giảm giá!');
    }
    public function editkhuyenmai(Request $req)
    {
        $this->validate(
            $req,
            [
                'tenkm' => 'required',
                'dieukien' => 'required',
                'macode' => 'required|unique:khuyenmai,macode,' . $req->id . '|min:6',
                'tiengiam' => 'required',
                'ngaybd' => 'required',
                'ngaykt' => 'required|after:ngaybd',

            ],
            [

                'tenkm.required' => 'Tên khuyến mãi không được để trống',
                'dieukien.required' => 'Điều kiện không được để trống',
                'macode.required' => 'Mã giảm giá không được để trống',
                'macode.unique' => 'Mã giảm giá đã tồn tại',
                'macode.min' => 'Mã giảm giá phải lớn hơn 6 kí tự',
                'tiengiam.required' => 'Tiền giảm không được để trống',
                'ngaybd.required' => 'Ngày bắt đầu không được để trống',
                'ngaykt.required' => 'Ngày kết thúc không được để trống',
                'ngaykt.after' => 'Ngày kết thúc phải sau ngày bắt đầu',


            ]
        );
        $new_coupons = Khuyenmai::find($req->id);
        $new_coupons->tenkm = $req->tenkm;
        $new_coupons->macode = $req->macode;
        $new_coupons->ngaybd = $req->ngaybd;
        $new_coupons->ngaykt = $req->ngaykt;
        $new_coupons->dieukien = $req->dieukien;
        $new_coupons->tiengiam = $req->tiengiam;
        $new_coupons->trangthai = $req->ngaybd > Carbon::now() ? 0 : 1;
        $new_coupons->save();
        return back()->with('success', 'Đã chỉnh sửa!');
    }
    public function deleteKhuyenmai($id)
    {
        $khuyenmai = Khuyenmai::find($id)->delete();
        return response()->json($khuyenmai);
    }
    public function detailKhuyenmai($id)
    {
        $khuyenmai  = Khuyenmai::where('id', $id)->first();
        return view('pages_admin.khuyenmai.chitiet_khuyenmai', compact('khuyenmai'));
    }
    public function stopKhuyenmai($id)
    {
        $khuyenmai  = Khuyenmai::find($id);
        $khuyenmai->trangthai = 0;
        $khuyenmai->save();
        return back()->with('success', 'Đã Tạm Dừng Khuyến Mãi!');
    }
    public function runKhuyenmai($id)
    {
        $khuyenmai  = Khuyenmai::find($id);
        $khuyenmai->trangthai = 1;
        $khuyenmai->save();
        return back()->with('success', 'Đã Chạy Khuyến Mãi!');
    }
}
