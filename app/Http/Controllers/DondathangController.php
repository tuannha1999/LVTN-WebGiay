<?php

namespace App\Http\Controllers;

use App\Cart as AppCart;
use App\Districts;
use App\Dondathang;
use App\Hinhanh;
use App\Sanpham;
use App\Size;
use App\Loaisanpham;
use App\Provinces;
use App\Wards;
use Illuminate\Http\Request;
use Cart;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DondathangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getDanhsach(Request $req)
    {
        //
        if ($req->ajax()) {
            $donhang = Dondathang::all();
            return  DataTables::of($donhang)
                ->addColumn('action', function ($donhang) {
                    if ($donhang->trangthai == 0) {
                        return '<a href="#" class="btn btn-info">Duyệt</a>
                    <a href="javascript:void(0);" id="delete-lsp" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }
                    return '<a href="#" class="btn btn-success">Xem</a>
                    <a href="javascript:void(0);" id="delete-lsp" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->editColumn('trangthai', function ($donhang) {
                    if ($donhang->trangthai == 0) {
                        return '<span class="text-warning">Đơn hàng mới</span>';
                    } else if ($donhang->trangthai == 1) {
                        return '<span class="text-warning">Chờ giao hàng</span>';
                    } else if ($donhang->trangthai == 2) {
                        return '<span class="text-info">Đang giao hàng</span>';
                    } else if ($donhang->trangthai == 3) {
                        return '<span class="text-success">Hoàn thành</span>';
                    } else {
                        return '<span class="text-warning">Đã hủy</span>';
                    }
                })->editColumn('created_at', function ($donhang) {
                    return $donhang->created_at->toDateTimeString();
                })->rawColumns(['action', 'trangthai', 'created_at'])->make(true);
        }
        return view('pages_admin.donhang.list_donhang');
    }

    public function getformDatHang()
    {
        $total_cart = str_replace(array(','), '', Cart::subtotal());
        $total = $total_cart;
        if (Auth::check()) {
            if (Auth::user()->level == 1) {
                $total = $total_cart - 0.05 * $total_cart;
            } else if (Auth::user()->level == 2) {
                $total = $total_cart - 0.06 * $total_cart;
            } else if (Auth::user()->level == 3) {
                $total = $total_cart - 0.07 * $total_cart;
            } else if (Auth::user()->level == 4) {
                $total = $total_cart - 0.08 * $total_cart;
            } else if (Auth::user()->level == 5) {
                $total = $total_cart - 0.09 * $total_cart;
            } else if (Auth::user()->level == 6) {
                $total = $total_cart - 0.1 * $total_cart;
            }
        }
        $loai_sp = Loaisanpham::all();
        return view("pages.dathang.dathang", compact('loai_sp', 'total'));
    }
    // public function changeProvinces($id)
    // {
    //     //
    //     $dist = Districts::all()->where('province_id', $id);
    //     //dd($dist);
    //     return response()->json($dist);
    // }
    // public function changeDistrict($id)
    // {
    //     //
    //     $ward = Wards::all()->where('district_id', $id);
    //     //dd($dist);
    //     return response()->json($ward);
    // }
    public function formSuccess($sdt)
    {
        //
        $loai_sp = Loaisanpham::all();
        $sp = Dondathang::where('sdt', $sdt)->orderby('id', 'desc')->first();
        return view("pages.dathang.dathangthanhcong", compact('sp', 'loai_sp'));
    }
    public function getformHoanTat(Request $req)
    {
        $old = old('hoten', 'sdt', 'diachi', 'ghichu');
        //
        $this->validate(
            $req,
            [
                'hoten' => 'required',
                'sdt' => 'required|regex:/(0)[3-9][0-9]{8}/|max:10',
                'diachi' => 'required',

            ],

            [
                'hoten.required' => 'Vui lòng nhập họ tên',
                'sdt.required' => 'Số điện thoại không được để trống',
                'sdt.regex' => 'Số điện thoại không hợp lệ',
                'sdt.max' => 'Số điện thoại không hợp lệ',
                'diachi.required' => 'Địa chỉ không được để trống',
            ]
        );
        $req->session()->flash('hoten', $req->hoten);
        $req->session()->flash('sdt', $req->sdt);
        $req->session()->flash('diachi', $req->diachi);
        $req->session()->flash('ghichu', $req->ghichu);
        $req->session()->flash('thanhtoan', $req->thanhtoan);
        $req->session()->flash('tongtien', $req->tongtien);
        $loai_sp = Loaisanpham::all();
        return view("pages.dathang.hoantat_dathang", compact('loai_sp'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //
        if (Cart::count() != null) {
            $new_dh = new Dondathang();
            $new_dh->hoten = $req->hoten;
            $new_dh->diachi = $req->diachi;
            $new_dh->sdt = $req->sdt;
            $new_dh->trangthai = 0;
            $new_dh->ptthanhtoan = $req->thanhtoan;
            $new_dh->dathanhtoan = 0;
            $new_dh->tongtien = $req->tongtien;
            $new_dh->ghichu = $req->ghichu;
            $new_dh->save();
            foreach (Cart::content() as $item) {
                $hinhanh = Hinhanh::where('id_sp', $item->id)->get();
                $img = 0;
                foreach ($hinhanh as $anh) {
                    if ($anh->avt == 1) {
                        $img = $anh->name;
                    }
                }
                $new_dh->sanpham()->attach($item->id, [
                    'soluong' => $item->qty, 'giaban' => $item->price,
                    'size' => $item->options->size->size, 'img' => $img
                ]);
                $sl = Size::where('size', $item->options->size->size)->where('id_sp', $item->id)->first();
                $sl->soluong = $sl->soluong - $item->qty;
                $sl->save();
                Cart::destroy($item->rowId);
            }
            return redirect('dathang-thanhcong/' . $req->sdt);
        }
        return redirect('/');
    }
    public function huyDonHang(Request $req, $id)
    {
        $donhang = Dondathang::find($id);
        $donhang->trangthai = 4;
        $donhang->ghichu = $req->lydo;
        $donhang->save();
        return back();
    }
    public function chitietDonHang($id)
    {
        $loai_sp = Loaisanpham::all();
        $donhang = Dondathang::find($id);
        return view("pages.dathang.chitiet_donhang", compact('donhang', 'loai_sp'));
    }
}
