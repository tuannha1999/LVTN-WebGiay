<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartPhieuTra;
use App\Dondathang;
use App\Phieutra;
use App\Sanpham;
use App\Size;
use App\Thongke;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PhieutraController extends Controller
{
    //
    public function getPhieuTra(Request $request)
    {
        if ($request->ajax()) {
            $phieutra = Phieutra::all()->sortBy('trangthai');
            return  DataTables::of($phieutra)
                ->addColumn('action', function ($phieutra) {
                    return '<a href="' . URL('/admin/dsphieutra-detail/' . $phieutra->id) . '" class="link">
                    <i class="far fa-2x fa-eye"></i></a>
                    <a href="javascript:void(0);" id="delete-phieutra" data-toggle="tooltip"
                    data-original-title="Delete" data-id="' . $phieutra->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->addColumn('tongtien', function ($phieutra) {
                    return number_format($phieutra->tongtien, 0, '.', '.');
                })->editColumn('tenkh', function ($phieutra) {
                    return $phieutra->dondathang->hoten;
                })->editColumn('hoantien', function ($phieutra) {
                    if ($phieutra->hoantien == 1) {
                        return '<span class="text-success"> Đã hoàn tiền <span/>';
                    } else {
                        return '<span class="text-warning"> Chưa hoàn tiền <span/>';
                    }
                })->editColumn('trangthai', function ($phieutra) {
                    if ($phieutra->trangthai == 1) {
                        return '<span class="text-success"> Hoàn thành <span/>';
                    } else {
                        return '<span class="text-warning"> Đang giao dịch <span/>';
                    }
                })->editColumn('nhanhang', function ($phieutra) {
                    if ($phieutra->nhanhang == 1) {
                        return '<span class="text-success"> Đã nhận<span/>';
                    } else {
                        return '<span class="text-warning"> Chưa nhận<span/>';
                    }
                })->rawColumns(['id', 'trangthai', 'action', 'tenkh', 'tongtien', 'hoantien', 'nhanhang'])->make(true);
        }
        return view('pages_admin.trahang.list_phieutra');
    }
    public function deletePhieuTra($id)
    {
        $delete_pt = Phieutra::find($id)->delete();
        return response()->json($delete_pt);
    }

    public function getDonhang(Request $request)
    {
        if ($request->ajax()) {
            $range = Carbon::now()->subDays(7);
            $donhang = Dondathang::all()->where('trangthai', 3)->where('ngaydat', '>=', $range);
            return  DataTables::of($donhang)
                ->addColumn('action', function ($donhang) {
                    return '<a href="' . URL('/admin/dsphieutra-addsanphamtra/' . $donhang->id) . '" class="link btn btn-success">Trả hàng</a>';
                })->editColumn('trangthai', function ($donhang) {
                    return '<span class="text-success"> Hoàn thành <span/>';
                })->addColumn('tongtien', function ($donhang) {
                    return number_format($donhang->tongtien, 0, '.', '.');
                })->rawColumns(['id', 'trangthai', 'action', 'tongtien'])->make(true);
        }
        return view('pages_admin.trahang.list_phieutra');
    }

    public function formAddPhieuTra($id)
    {
        $donhang = Dondathang::find($id);
        return view("pages_admin.trahang.add_phieutra", compact('donhang'));
    }
    public function AddPhieuTra(Request $req)
    {
        if (session()->has('Phieutra')) {

            $req->old('nhanhang', 'hoantien', 'ghichu', 'lydo');
            $this->validate(
                $req,
                [
                    'lydo' => 'required',
                ],

                [
                    'lydo.required' => 'Bạn chưa chọn lý do trả hàng',

                ]
            );
            $new_phieutra = new Phieutra();
            $new_phieutra->ghichu = $req->ghichu;
            $new_phieutra->hoantien = $req->hoantien == 1 ? 1 : 0;
            $new_phieutra->nhanhang = $req->nhanhang == 1 ? 1 : 0;
            $new_phieutra->trangthai = $req->nhanhang == 1 && $req->hoantien == 1 ? 1 : 0;
            $new_phieutra->id_dh = $req->id_dh;
            $new_phieutra->lydo = $req->lydo;
            $new_phieutra->id_user = Auth::user()->id;
            $new_phieutra->tongtien = session()->get('Phieutra')->totalPhieutra;
            $new_phieutra->save();
            //cập nhật đơn hàng
            $donhang = Dondathang::find($req->id_dh);
            $donhang->tongtien = $donhang->tongtien - session()->get('Phieutra')->totalPhieutra;
            $donhang->save();
            $tong_nhap = 0;
            foreach (session()->get('Phieutra')->products as $item) {
                $new_phieutra->sanpham()->attach($item['productinfo']->id, ['size' => $item['size'], 'soluong' => $item['quanty']]);
                $tong_sl = 0;
                foreach ($donhang->sanpham as $dh) {
                    $tong_sl += $dh->pivot->soluong;
                }
                foreach ($donhang->sanpham as $dh) {
                    if ($dh->pivot->id_sp == $item['productinfo']->id && $dh->pivot->size == $item['size']) {
                        if ($dh->pivot->soluong == $item['quanty']) {
                            $donhang->sanpham()->detach([$item['productinfo']->id]);
                            if ($tong_sl == session()->get('Phieutra')->QuantyPhieutra) {
                                $donhang->trangthai = 4;
                                $donhang->ghichu = 'Đã trả hàng';
                            }
                            $donhang->save();
                        } else {
                            $donhang->sanpham()->wherePivot('size', '=', $item['size'])->detach([$item['productinfo']->id]);
                            $donhang->sanpham()->attach(
                                $item['productinfo']->id,
                                [
                                    'soluong' => $dh->pivot->soluong - $item['quanty'],
                                    'giaban' => $item['giaban'], 'size' => $item['size'], 'img' => $dh->pivot->img
                                ]
                            );
                        }
                        if ($req->nhanhang == 1 && $req->hoantien == 1) {
                            //Cộng sản phẩm lại kho
                            if ($req->lydo == 1) {
                                $sl = Size::where('size', $item['size'])->where('id_sp', $item['productinfo']->id)->first();
                                $sl->soluong += $item['quanty'];
                                $sl->save();
                            }
                            //trừ sản phẩm đã bán
                            $sp_daban = Sanpham::find($item['productinfo']->id);
                            $sp_daban->daban = $sp_daban->daban - $item['quanty'];
                            $sp_daban->save();
                            //Tổng giá nhập
                            $sanpham = Sanpham::find($item['productinfo']->id);
                            $tong_nhap += $sanpham->gianhap * $item['quanty'];
                        }
                    }
                }
            }
            if ($req->nhanhang == 1 && $req->hoantien == 1) {
                //thống kê
                $thongke = Thongke::where('ngaydat', $donhang->ngaydat)->first();
                $thongke->doanhthu -= session()->get('Phieutra')->totalPhieutra;
                $thongke->loinhuan -= session()->get('Phieutra')->totalPhieutra - $tong_nhap;
                $thongke->save();
                //Cập nhật tổng giao dịch khách hàng
                if ($donhang->id_kh != null) {
                    $khachhang = User::find($donhang->id_kh);
                    $khachhang->tonggd = $khachhang->tonggd - session()->get('Phieutra')->totalPhieutra;
                    $khachhang->save();
                    if (2000000 <= $khachhang->tonggd && $khachhang->tonggd < 3999000) {
                        $khachhang->phantram =  0.05;
                    } else if (4000000 <= $khachhang->tonggd && $khachhang->tonggd < 5999000) {
                        $khachhang->phantram =  0.06;
                    } else if (6000000 <= $khachhang->tonggd && $khachhang->tonggd < 7999000) {
                        $khachhang->phantram =  0.07;
                    } else if (8000000 <= $khachhang->tonggd && $khachhang->tonggd < 9999000) {
                        $khachhang->phantram =  0.08;
                    } else if (10000000 <= $khachhang->tonggd && $khachhang->tonggd < 11999000) {
                        $khachhang->phantram =  0.09;
                    } else {
                        $khachhang->phantram =  0.1;
                    }
                    $khachhang->save();
                }
            }
            session()->forget('Phieutra');
            return redirect('/admin/dsphieutra')->with('success', 'Đã tạo phiếu trả. Mã phiếu trả:' . $new_phieutra->id);
        } else {
            return redirect('/admin/dsphieutra');
        }
    }

    public function detailPhieuTra($id)
    {
        $phieutra = Phieutra::with('user')->with('dondathang')->where('id', $id)->first();
        return view('pages_admin.trahang.chitiet_phieutra', compact('phieutra'));
    }

    public function nhanhang($id)
    {
        $phieutra = Phieutra::with('dondathang')->with('sanpham')->find($id);
        $phieutra->nhanhang = 1;
        $phieutra->save();
        $tong_nhap = 0;
        if ($phieutra->hoantien == 1) {
            $phieutra->trangthai = 1;
            $phieutra->save();
            if ($phieutra->lydo == 1) {
                //Cộng sản phẩm lại kho
                foreach ($phieutra->sanpham as $sp) {
                    $sl = Size::where('size', $sp->pivot->size)->where('id_sp', $sp->id)->first();
                    $sl->soluong += $sp->pivot->soluong;
                    $sl->save();
                    //trừ sản phẩm đã bán
                    $sp_daban = Sanpham::find($sp->id);
                    $sp_daban->daban = $sp_daban->daban - $sp->pivot->soluong;
                    $sp_daban->save();
                }
            }
            //trừ sản phẩm đã bán
            foreach ($phieutra->sanpham as $sp) {
                $sp_daban = Sanpham::find($sp->id);
                $sp_daban->daban = $sp_daban->daban - $sp->pivot->soluong;
            }
            //thống kê
            foreach ($phieutra->sanpham as $sp) {
                //Tổng giá nhập
                $sanpham = Sanpham::find($sp->id);
                $tong_nhap += $sanpham->gianhap * $sp->pivot->soluong;
            }
            $thongke = Thongke::where('ngaydat', $phieutra->dondathang->ngaydat)->first();
            $thongke->doanhthu -= $phieutra->tongtien;
            $thongke->loinhuan -= $phieutra->tongtien - $tong_nhap;
            $thongke->save();
            //Cập nhật tổng giao dịch khách hàng
            $donhang = Dondathang::find($phieutra->id_dh);
            if ($donhang->id_kh != null) {
                $khachhang = User::find($donhang->id_kh);
                $khachhang->tonggd = $khachhang->tonggd - $phieutra->tongtien;
                $khachhang->save();
                if (2000000 <= $khachhang->tonggd && $khachhang->tonggd < 3999000) {
                    $khachhang->phantram =  0.05;
                } else if (4000000 <= $khachhang->tonggd && $khachhang->tonggd < 5999000) {
                    $khachhang->phantram =  0.06;
                } else if (6000000 <= $khachhang->tonggd && $khachhang->tonggd < 7999000) {
                    $khachhang->phantram =  0.07;
                } else if (8000000 <= $khachhang->tonggd && $khachhang->tonggd < 9999000) {
                    $khachhang->phantram =  0.08;
                } else if (10000000 <= $khachhang->tonggd && $khachhang->tonggd < 11999000) {
                    $khachhang->phantram =  0.09;
                } else {
                    $khachhang->phantram =  0.1;
                }
                $khachhang->save();
            }
        }
        return back();
    }
    public function hoantien($id)
    {
        $phieutra = Phieutra::find($id);
        $phieutra->hoantien = 1;
        $phieutra->save();
        $tong_nhap = 0;
        if ($phieutra->nhanhang == 1) {
            $phieutra->trangthai = 1;
            $phieutra->save();
            if ($phieutra->lydo == 1) {
                //Cộng sản phẩm lại kho
                foreach ($phieutra->sanpham as $sp) {
                    $sl = Size::where('size', $sp->pivot->size)->where('id_sp', $sp->id)->first();
                    $sl->soluong += $sp->pivot->soluong;
                    $sl->save();
                }
            }
            //trừ sản phẩm đã bán
            foreach ($phieutra->sanpham as $sp) {
                $sp_daban = Sanpham::find($sp->id);
                $sp_daban->daban = $sp_daban->daban - $sp->pivot->soluong;
                $sp_daban->save();
            }
            //thống kê
            foreach ($phieutra->sanpham as $sp) {
                //Tổng giá nhập
                $sanpham = Sanpham::find($sp->id);
                $tong_nhap += $sanpham->gianhap * $sp->pivot->soluong;
            }
            $thongke = Thongke::where('ngaydat', $phieutra->dondathang->ngaydat)->first();
            $thongke->doanhthu -= $phieutra->tongtien;
            $thongke->loinhuan -= $phieutra->tongtien - $tong_nhap;
            $thongke->save();
            //Cập nhật tổng giao dịch khách hàng
            $donhang = Dondathang::find($phieutra->id_dh);
            if ($donhang->id_kh != null) {
                $khachhang = User::find($donhang->id_kh);
                $khachhang->tonggd = $khachhang->tonggd - $phieutra->tongtien;
                $khachhang->save();
                if (2000000 <= $khachhang->tonggd && $khachhang->tonggd < 3999000) {
                    $khachhang->phantram =  0.05;
                } else if (4000000 <= $khachhang->tonggd && $khachhang->tonggd < 5999000) {
                    $khachhang->phantram =  0.06;
                } else if (6000000 <= $khachhang->tonggd && $khachhang->tonggd < 7999000) {
                    $khachhang->phantram =  0.07;
                } else if (8000000 <= $khachhang->tonggd && $khachhang->tonggd < 9999000) {
                    $khachhang->phantram =  0.08;
                } else if (10000000 <= $khachhang->tonggd && $khachhang->tonggd < 11999000) {
                    $khachhang->phantram =  0.09;
                } else {
                    $khachhang->phantram =  0.1;
                }
                $khachhang->save();
            }
        }
        return back();
    }
    public function addSanPhamTra($id)
    {
        session()->forget('Phieutra');
        $donhang = Dondathang::find($id);
        foreach ($donhang->sanpham as $sp) {
            $sanpham = Sanpham::find($sp->pivot->id_sp);
            $size = Size::where('size', $sp->pivot->size)->where('id_sp', $sp->pivot->id_sp)->first();
            $oldCart = Session('Phieutra') ? Session('Phieutra') : null;
            $newCart = new CartPhieuTra($oldCart);
            $newCart->addSanpham($sanpham, $sp->pivot->id_sp, $size,  $sp->pivot->soluong,  $sp->pivot->giaban, $sp->pivot->img);
            session()->put('Phieutra', $newCart);
        }
        return redirect("/admin/dsphieutra-addphieutra/" . $id);
    }
    public function deleteSanPhamTra($id)
    {
        //dd($id);
        $oldCart = Session('Phieutra') ? Session('Phieutra') : null;
        if (count(session()->get('Phieutra')->products) > 1) {
            $newCart = new CartPhieuTra($oldCart);
            $newCart->deleteSanPham($id);
            if (count($newCart->products) > 0) {
                session()->put('Phieutra', $newCart);
            }
            return back();
        } else {
            return back()->with('error', "Phiếu trả phải tồn tại ít nhất 1 sản phẩm!");
        }
    }
    public function minusSanPhamTra($id)
    {
        //dd($qty);
        if (session()->get('Phieutra')->products[$id]['quanty'] > 1) {
            $oldCart = Session('Phieutra') ? Session('Phieutra') : null;
            $newCart = new CartPhieuTra($oldCart);
            $newCart->minusSanPham($id);
            Session()->put('Phieutra', $newCart);
            return response()->json('success');
        } else {
            return response()->json(['error' => 'Số lượng sản phẩm phải lớn hơn 0']);
        }
    }
}
