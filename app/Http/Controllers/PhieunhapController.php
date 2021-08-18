<?php

namespace App\Http\Controllers;

use App\Dondathang;
use App\Nhacungcap;
use App\Phieunhap;
use App\Sanpham;
use App\User;
use App\Size;
use App\Hinhanh;
use App\Cart;
use App\Imports\Importproducts;
use App\Imports\Importsanpham;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;


class PhieunhapController extends Controller
{
    //
    public function dsPhieuNhap(Request $request)
    {
        if ($request->ajax()) {
            $pn = Phieunhap::all()->sortBy('trangthai');
            return  DataTables::of($pn)
                ->addColumn('action', function ($pn) {
                    return '<a href="' . URL('/admin/dsphieunhap-detail/' . $pn->id) . '" class="link">
                    <i class="far fa-2x fa-eye"></i></a>
                    <a href="javascript:void(0);" id="delete" data-toggle="tooltip"
                    data-original-title="Delete" data-id="' . $pn->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->addColumn('tenncc', function ($pn) {
                    $ncc = Nhacungcap::find($pn->id_ncc);
                    return $ncc->tenncc;
                })->addColumn('tongtien', function ($pn) {
                    return number_format($pn->tongtien, 0, '.', '.');
                })->editColumn('id', function ($pn) {
                    return '<a href="' . URL('/admin/dsphieunhap-detail/' . $pn->id) . '" class="link text-primary">' . $pn->id . '</a>';
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
                })->editColumn('nhaphang', function ($pn) {
                    if ($pn->nhapkho == 1) {
                        return '<span class="text-success"> Đã nhập kho<span/>';
                    } else {
                        return '<span class="text-warning"> Chưa nhập kho <span/>';
                    }
                })->rawColumns(['id', 'trangthai', 'action', 'tenncc', 'tongtien', 'thanhtoan', 'tennv', 'nhaphang'])->make(true);
        }
        return view('pages_admin.nhaphang.list_phieunhap');
    }
    public function detailPhieuNhap($id)
    {
        $phieunhap = Phieunhap::with('nhacungcap')->with('user')->where('id', $id)->first();
        return view('pages_admin.nhaphang.chitiet_phieunhap', compact('phieunhap'));
    }
    public function delete($id)
    {
        $delete_pn = Phieunhap::find($id)->delete();
        return response()->json($delete_pn);
    }

    public function thanhtoan($id)
    {
        $phieunhap = Phieunhap::find($id);
        $phieunhap->thanhtoan = 1;
        if ($phieunhap->nhapkho == 1) {
            $phieunhap->trangthai = 1;
        }
        $phieunhap->save();
        return back();
        //dd($pn->thanhtoan );
    }
    public function nhapkho($id)
    {
        $phieunhap = Phieunhap::find($id);
        foreach ($phieunhap->sanpham as $pn) {
            $sl = Size::where('size', $pn->pivot->size)->where('id_sp', $pn->pivot->id_sp)->first();
            $sl->soluong = $sl->soluong + $pn->pivot->soluong;
            $sl->save();
            $phieunhap->nhapkho = 1;
            if ($phieunhap->thanhtoan == 1) {
                $phieunhap->trangthai = 1;
            }
            $phieunhap->save();
        }
        return back();
    }
    public function formAdd()
    {
        $ncc = Nhacungcap::all();
        return view("pages_admin.nhaphang.add_phieunhap", compact("ncc"));
    }
    public function addPhieuNhap(Request $req)
    {

        $req->old('ngaynhap', 'thanhtoan', 'nhapkho', 'ghichu');
        $this->validate(
            $req,
            [
                'ngaynhap' => 'required|date|before_or_equal:' . Carbon::now('Asia/Ho_Chi_Minh'),
            ],

            [
                'ngaynhap.required' => 'Không được để trống',
                'ngaynhap.before_or_equal' => 'Ngày nhập không hợp lệ',

            ]
        );
        if (Session::has('Cart') != null) {
            if (!empty(Session::get('Cart')->supplier) && !empty(Session::get('Cart')->products)) {
                $new_phieunhap = new Phieunhap();
                $new_phieunhap->ngaynhap = $req->ngaynhap;
                $new_phieunhap->ghichu = $req->ghichu != null ? $req->ghichu : '';
                $new_phieunhap->thanhtoan = $req->thanhtoan != null ? 1 : 0;
                $new_phieunhap->id_user = Auth::user()->id;
                $new_phieunhap->nhapkho = $req->nhapkho != null ? 1 : 0;
                $new_phieunhap->trangthai = $req->thanhtoan == 1 && $req->nhapkho == 1 ? 1 : 0;
                $new_phieunhap->tongtien = Session::get("Cart")->totalPrice;
                foreach (Session::get('Cart')->supplier as $ncc) {
                    $new_phieunhap->id_ncc = $ncc['supplierinfo']->id;
                }
                $new_phieunhap->save();
                $tongtien = 0;
                foreach (Session::get('Cart')->products as $sp) {
                    $new_phieunhap->sanpham()->attach($sp['productinfo']->id, [
                        'soluong' => $sp['quanty'],
                        'size' => $sp['size'], 'gianhap' => $sp['entryprice']
                    ]);
                    $soluong = Size::with('sanpham')->where('id_sp', $sp['productinfo']->id)->sum('soluong');
                    $save_gianhap = Sanpham::find($sp['productinfo']->id);
                    $save_gianhap->gianhap_new = $sp['entryprice'];
                    $save_gianhap->gianhap = $save_gianhap->gianhap == 0 ? $sp['entryprice'] : (($save_gianhap->gianhap * $soluong) + ($sp['entryprice'] * $sp['quanty'])) / ($sp['quanty'] + $soluong);
                    $save_gianhap->save();
                    if ($req->nhapkho == 1) {
                        $sl = Size::find($sp['id_size']);
                        $sl->soluong = $sl->soluong + $sp['quanty'];
                        $sl->save();
                    }
                }

                $req->session()->forget('Cart');
                return redirect('/admin/dsphieunhap')->with('success', 'Tạo phiếu nhập thành công!. Mã phiếu nhập: ' . $new_phieunhap->id);
            }

            return back()->with('error', 'Chưa Chọn nhà cung cấp hoặc sản phẩm!');
        }
        // $req->session()->flash
        return back()->with('error', 'Tạo không thành công!');
    }
    public function dsSanpham(Request $request)
    {
        if ($request->ajax()) {
            $size = Size::with('Sanpham')->orderBy('id', 'desc')->get();
            return  DataTables::of($size)
                ->editColumn('tensp', function ($size) {
                    $sp = Sanpham::where('id', $size->id_sp)->first();
                    return $sp->tensp . ' - ' . $size->size;
                })->addColumn('img', function ($size) {
                    $img = Hinhanh::where('id_sp', $size->id_sp)->where('avt', 1)->first();
                    return '<img style="heigth:50px;width:50px;" src="' . asset('storage/' . $img->name) . '" alt="Card image">';
                })->addColumn('soluong', function ($size) {
                    return '<input type="number"id="qty-' . $size->id_sp . $size->id   . '" min="1"
                    style="width: 60px;height: 30px;" value="1">';
                })->addColumn('gianhap', function ($size) {
                    $sp = Sanpham::where('id', $size->id_sp)->first();
                    return '<input type="number" id="price-' . $size->id_sp . $size->id  . '" required
                     style="width: 100px;height: 30px;" value="' . $sp->gianhap_new . '">';
                })->addColumn('action', function ($size) {
                    // if (Session::has("Cart") != null) {
                    //     if (array_key_exists($size->id_sp  . $size->id, Session::get("Cart")->products)) {
                    //         return '<button class="btn btn-outline-info" disabled/> Chọn</button>';
                    //     }
                    // }
                    //return '<i onclick="addCart(' . $size->id_sp  . ',' . $size->id . ')" class="fas fa-2x fa-plus"></i>';
                    return '<a href="#" onclick="addCart(' . $size->id_sp  . ',' . $size->id . ')" class="btn btn-outline-info">Chọn</a>';
                })->rawColumns(['tensp', 'img', 'soluong', 'action', 'gianhap'])->make(true);
        }
        return view('pages_admin.nhaphang.add_phieunhap');
    }


    public function dsNhaCungCap(Request $request)
    {
        if ($request->ajax()) {
            $ncc = Nhacungcap::all();
            return  DataTables::of($ncc)
                ->addColumn('action', function ($ncc) {
                    if (Session::has("Cart") != null) {
                        if (count(Session::get("Cart")->supplier) === 1) {
                            return '<button class="btn btn-outline-info" disabled/> Chọn</button>';
                        }
                    }
                    return '<a href="' . URL('admin/dsphieunhap-addncc/' . $ncc->id) . '" class="btn btn-outline-info">Chọn</a>';
                })->rawColumns(['action'])->make(true);
        }
        return view('pages_admin.nhaphang.add_phieunhap');
    }

    public function addNCC(Request $request, $id)
    {
        $ncc = Nhacungcap::find($id);
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->addNCC($ncc, $id);
        $request->session()->put('Cart', $newCart);
        return back();
    }

    public function addSanPham(Request $request, $id, $size, $qty, $price)
    {
        $product = Sanpham::find($id);
        $size = Size::find($size);
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->AddCart($product, $id, $size, $qty, $price);
        $request->session()->put('Cart', $newCart);
        return back();
    }
    public function RemoveItemCart(Request $request, $id)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->DeleteItemCart($id);
        if (count($newCart->products) > 0) {
            $request->session()->put('Cart', $newCart);
        } else {
            $request->session()->forget('Cart');
        }
        return back();
    }
    public function RemoveNCC(Request $request, $id)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->DeleteNCC($id);
        if (count($newCart->supplier) > 0) {
            $request->session()->put('Cart', $newCart);
        } else {
            $request->session()->forget('Cart');
        }
        return back();
    }
    public function updateCart(Request $request, $id, $qty, $price)
    {
        //dd($qty);
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->updateCart($id, $qty, $price);
        $request->Session()->put('Cart', $newCart);
        return back();
    }
}
