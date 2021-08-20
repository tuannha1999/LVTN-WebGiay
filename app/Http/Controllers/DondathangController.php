<?php

namespace App\Http\Controllers;

use App\Dondathang;
use App\Chitietdondathang;
use App\Hinhanh;
use App\Khuyenmai;
use App\Sanpham;
use App\Size;
use App\Loaisanpham;
use App\Thongke;
use App\User;
use Illuminate\Http\Request;
use Cart;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class DondathangController extends Controller
{

    public function chuyenformDatHang()
    {
        session()->forget(['tongtien', 'tiengiamma', 'daapdung', 'tiengiamtv', 'dagiamtv', 'macode']);
        return redirect('/form-dathang');
    }

    public function getformDatHang(Request $req)
    {

        $total_cart = str_replace(array(','), '', Cart::subtotal());
        $total = $total_cart;
        if (Auth::check()) {
            $total = $total_cart - Auth::user()->phantram * $total_cart;
            if (session()->has('dagiamtv') == null) {
                session()->put(['tongtien' => $total, 'tiengiamtv' => $total_cart - $total, 'dagiamtv' => 1]);
            }
        }
        if (session()->has('daapdung') == null) {
            session()->put(['tongtien' => $total]);
        }
        $loai_sp = Loaisanpham::all();
        return view("pages.dathang.dathang", compact('loai_sp', 'total'));
    }
    public function formSuccess($id)
    {
        //
        $loai_sp = Loaisanpham::all();
        $donhang = Dondathang::find($id);
        return view("pages.dathang.dathangthanhcong", compact('donhang', 'loai_sp'));
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
        $loai_sp = Loaisanpham::all();
        return view("pages.dathang.hoantat_dathang", compact('loai_sp'));
    }

    public function dathang(Request $req)
    {
        //
        if (Cart::count() != null) {
            $total_cart = str_replace(array(','), '', Cart::subtotal());
            $new_dh = new Dondathang();
            $new_dh->hoten = $req->hoten;
            $new_dh->diachi = $req->diachi;
            $new_dh->sdt = $req->sdt;
            $new_dh->trangthai = 0;
            $new_dh->ptthanhtoan = $req->thanhtoan;
            $new_dh->dathanhtoan = 0;
            $new_dh->tongtien = $req->Session()->get('tongtien');
            $new_dh->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $new_dh->ghichu = $req->ghichu;
            $new_dh->id_kh = Auth::check() == true ? Auth::user()->id : null;
            $new_dh->ngaydat = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $new_dh->save();
            foreach (Cart::content() as $item) {

                $price = $item->price - (($total_cart - session()->get('tongtien')) / $total_cart) * $item->price;
                $new_dh->sanpham()->attach($item->id, [
                    'soluong' => $item->qty, 'giaban' => $price,
                    'size' => $item->options->size->size, 'img' => $item->options->images
                ]);
                $sl = Size::where('size', $item->options->size->size)->where('id_sp', $item->id)->first();
                $sl->soluong = $sl->soluong - $item->qty;
                $sl->save();
                Cart::destroy($item->rowId);
            }
            session()->forget(['tongtien', 'tiengiamma', 'daapdung', 'tiengiamtv', 'dagiamtv', 'macode']);
            return redirect('dathang-thanhcong/' . $new_dh->id);
        }
        return redirect('/');
    }
    public function checkCoupons(Request $req)
    {

        //dd($req->macode);
        $total_cart = str_replace(array(','), '', Cart::subtotal());
        $khuyenmai = Khuyenmai::where('macode', $req->macode)->first();
        $tongtien = session()->get('tongtien');
        if (!empty($khuyenmai) && session()->get('daapdung') == 0) {
            if ($khuyenmai->ngaykt < Carbon::now() || $khuyenmai->trangthai == 0) {
                return back()->with('error', 'Mã giảm giá không tồn tại');
            } else if ($khuyenmai->dieukien > $total_cart) {
                return back()->with('error', 'Đơn hàng chưa đủ điều kiện');
            } else {
                session()->put([
                    'tongtien' => $tongtien - $khuyenmai->tiengiam,
                    'daapdung' => 1, 'tiengiamma' => $khuyenmai->tiengiam,
                    'macode' => $req->macode,
                ]);
            }
        } else if (empty($khuyenmai)) {
            return back()->with('error', 'Mã giảm giá không tồn tại');
        }
        return back()->with('success', 'Đã áp dụng mã giảm giá!');
    }
    public function deleteCoupons()
    {

        session()->forget('daapdung');
        $tongtien = session()->get('tongtien');
        session()->put([
            'tongtien' => $tongtien + session()->get('tiengiamma'),
        ]);
        session()->forget(['tiengiamma', 'macode']);
        return back();
    }
    public function huyDonHang(Request $req, $id)
    {
        $donhang = Dondathang::with('sanpham')->find($id);
        foreach ($donhang->sanpham as $sp) {
            $sl = Size::where('size', $sp->pivot->size)->where('id_sp', $sp->pivot->id_sp)->first();
            $sl->soluong += $sp->pivot->soluong;
            $sl->save();
        }
        $donhang->trangthai = 4;
        $donhang->ghichu = $req->lydo != null ? $req->lydo : '';
        $donhang->save();

        return back();
    }
    public function chitietDonHang($id)
    {
        $loai_sp = Loaisanpham::all();
        $donhang = Dondathang::find($id);
        return view("pages.dathang.chitiet_donhang", compact('donhang', 'loai_sp'));
    }

    //Code - ADMIN

    public function getDanhsach(Request $req)
    {
        //
        if ($req->ajax()) {
            $donhang = Dondathang::orderby('trangthai')->get();
            return  DataTables::of($donhang)
                ->addColumn('action', function ($donhang) {
                    if ($donhang->trangthai == 3) {
                        return '<a href="' . URL('admin/dsdonhang-donhang/' . $donhang->id) . '" class="btn btn-info">Xem</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    } elseif ($donhang->trangthai == 4) {
                        return '<a href="' . URL('admin/dsdonhang-donhang/' . $donhang->id) . '" class="btn btn-info">Xem</a>
                        <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                        <i class="fas fa-2x fa-trash-alt"></i></a>';
                    } else {
                        return '<a href="' . URL('admin/dsdonhang-donhang/' . $donhang->id) . '" class="btn btn-success">Duyệt</a>
                        <a href="javascript:void(0);" id="huy-dh" data-id="' . $donhang->id . ' " class="btn btn-warning">Hủy</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }
                })->editColumn('trangthai', function ($donhang) {
                    if ($donhang->trangthai == 0) {
                        return '<span class="text-warning">Chờ xử lý</span>';
                    } else if ($donhang->trangthai == 1) {
                        return '<span class="text-info">Chờ giao hàng</span>';
                    } else if ($donhang->trangthai == 2) {
                        return '<span class="text-primary">Đang giao hàng</span>';
                    } else if ($donhang->trangthai == 3) {
                        return '<span class="text-success">Hoàn thành</span>';
                    } else {
                        return '<span class="text-danger">Đã hủy</span>';
                    }
                })->editColumn('dathanhtoan', function ($donhang) {
                    if ($donhang->dathanhtoan == 1) {
                        return '<span class="text-success">Đã thanh toán</span>';
                    } else {
                        return '<span class="text-warning">Chưa thanh toán</span>';
                    }
                })->editColumn('tongtien', function ($donhang) {
                    return number_format($donhang->tongtien, 0, '.', '.');
                })->rawColumns(['action', 'trangthai', 'dathanhtoan', 'tongtien'])->make(true);
        }
        return view('pages_admin.donhang.list_donhang');
    }

    public function getChitietdonhangAdmin($id)
    {
        $loai_sp = Loaisanpham::all();
        $donhang = Dondathang::find($id);
        return view("pages_admin.donhang.details_donhang", compact('donhang', 'loai_sp'));
    }

    public function duyetDonHang($id)
    {
        $donhang = Dondathang::find($id);
        $donhang->trangthai = 1;
        $donhang->save();
        return back();
    }
    public function thanhtoan($id)
    {
        $donhang = Dondathang::find($id);
        $donhang->dathanhtoan = 1;
        $donhang->save();
        return back();
    }
    public function giaohang($id)
    {
        $donhang = Dondathang::find($id);
        if ($donhang->ptthanhtoan == 1) {
            if ($donhang->dathanhtoan == 1) {
                $donhang->trangthai = 2;
                $donhang->save();
            } else {
                return back()->with('error', 'Đơn hàng chưa thanh toán!');
            }
        } else {
            $donhang->trangthai = 2;
            $donhang->save();
        }
        return back();
    }
    public function hoanthanh($id)
    {
        $donhang = Dondathang::find($id);
        $donhang->trangthai = 3;
        $donhang->dathanhtoan = 1;
        $donhang->save();
        $tong_ban = 0;
        $tong_nhap = 0;
        //Cộng sản phẩm đã bán
        foreach ($donhang->sanpham as $sp) {
            $sanpham = Sanpham::find($sp->pivot->id_sp);
            $sanpham->daban += $sp->pivot->soluong;
            $sanpham->save();
            //Tổng giá bán và Giá Nhập
            $tong_ban += $sp->pivot->giaban * $sp->pivot->soluong;
            $tong_nhap += $sanpham->gianhap * $sp->pivot->soluong;
        }
        //tích lũy thành viên
        if ($donhang->id_kh != null) {
            $khachhang = User::find($donhang->id_kh);
            if ($khachhang->is_admin != 1) {
                $khachhang->tonggd += $donhang->tongtien;
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
                } else if (12000000 < $khachhang->tonggd) {
                    $khachhang->phantram =  0.1;
                }
                $khachhang->save();
            }
        }
        //thống kê
        $thongke = Thongke::where('ngaydat', $donhang->ngaydat)->first();
        if ($thongke != null) {
            $thongke->doanhthu += $donhang->tongtien;
            $thongke->loinhuan += $tong_ban - $tong_nhap;
            $thongke->donhang++;
            $thongke->save();
        } else {
            $thongke_new = new Thongke();
            $thongke_new->ngaydat = $donhang->ngaydat;
            $thongke_new->doanhthu = $donhang->tongtien;
            $thongke_new->loinhuan = $tong_ban - $tong_nhap;
            $thongke_new->donhang = 1;
            $thongke_new->save();
        }
        return back();
    }
    public function huyTrangThai($id)
    {
        $donhang = Dondathang::find($id);
        if ($donhang->trangthai == 2) {
            $donhang->dathanhtoan = 0;
        }
        $donhang->trangthai--;
        $donhang->save();
        return back();
    }
    public function chuyenformTaoDon()
    {
        Cart::destroy();
        session()->forget(['khachhang', 'tongtien']);
        return redirect('/admin/dsdonhang-formadd');
    }
    public function formTaoDon()
    {

        return view("pages_admin.donhang.add_donhang");
    }
    public function updateDonHang(Request $req)
    {
        $edit_dh = Dondathang::find($req->id);
        $edit_dh->hoten = $req->hoten;
        $edit_dh->sdt = $req->sdt;
        $edit_dh->diachi = $req->diachi;
        $edit_dh->ghichu = $req->ghichu;
        $edit_dh->ptthanhtoan = $req->ptthanhtoan;
        $edit_dh->save();
        return back()->with('success', 'Đã cập nhật thông tin đơn hàng');
    }
    public function updateSanPham($id, $sp, $size, $qty)
    {
        $donhang = Dondathang::find($id);
        $sanpham = Sanpham::find($sp);
        $tong_tien = 0;
        foreach ($donhang->sanpham as $sp) {
            $tong_tien += $sp->pivot->giaban * $sp->pivot->soluong;
        }
        foreach ($donhang->sanpham as $sp) {
            if ($sp->id == $sanpham->id && $sp->pivot->size == $size) {
                $giaban = $sp->pivot->giaban;
                $img = $sp->pivot->img;
                $tong_tien -= $sp->pivot->soluong * $giaban;
                $donhang->sanpham()->wherePivot('size', '=', $sp->pivot->size)->detach($sanpham->id);
                $donhang->sanpham()->attach($sanpham->id, [
                    'soluong' => $qty, 'giaban' => $giaban,
                    'size' => $size, 'img' => $img
                ]);
                $tong_tien += $qty * $giaban;
            }
        }

        $donhang->tongtien = $tong_tien;
        $donhang->save();
        return back()->with('success', 'Đã cập nhật thông tin đơn hàng');
    }
    public function deleteSanPhamDH($id, $sp, $size)
    {
        $donhang = Dondathang::find($id);
        $sanpham = Sanpham::find($sp);
        $tong_sl = 0;
        foreach ($donhang->sanpham as $sp) {
            $tong_sl += $sp->pivot->soluong;
        }
        foreach ($donhang->sanpham as $sp) {
            if ($sp->id == $sanpham->id && $sp->pivot->size == $size) {
                if ($tong_sl != $sp->pivot->soluong) {
                    $gia = $sp->pivot->giaban * $sp->pivot->soluong;
                    $donhang->tongtien = $donhang->tongtien - $gia;
                    $donhang->save();
                    $donhang->sanpham()->wherePivot('size', '=', $sp->pivot->size)->detach([$sanpham->id]);
                    return back();
                } else {
                    return back()->with('error', 'Đơn hàng phải có ít nhất 1 sản phẩm');
                }
            }
        }
    }
    public function addDonHang(Request $req)
    {
        $old = old('hoten', 'sdt', 'diachi', 'ghichu');
        //
        $this->validate(
            $req,
            [
                'hoten' => 'required',
                'sdt' => 'required|regex:/(0)[3-9][0-9]{8}/|max:10',
            ],

            [
                'hoten.required' => 'Vui lòng nhập họ tên',
                'sdt.required' => 'Số điện thoại không được để trống',
                'sdt.regex' => 'Số điện thoại không hợp lệ',
                'sdt.max' => 'Số điện thoại không hợp lệ',
            ]
        );
        if (Cart::count() > 0) {
            $total_cart = str_replace(array(','), '', Cart::subtotal());
            $new_donhang = new Dondathang();
            $new_donhang->hoten = $req->hoten != null ? $req->hoten : null;
            $new_donhang->sdt = $req->sdt != null ? $req->sdt : null;
            $new_donhang->diachi = $req->diachi != null ? $req->diachi : null;
            if ($req->thanhtoan == 1 && $req->nhanhang == 1) {
                $new_donhang->trangthai = 3;
            } else {
                $new_donhang->trangthai = 1;
            }
            $new_donhang->dathanhtoan =  $req->thanhtoan != null ? 1 : 0;
            $new_donhang->ptthanhtoan = $req->ptthanhtoan;
            $new_donhang->id_kh = Session::has('khachhang') ? Session::get('khachhang')->id : null;
            $new_donhang->tongtien = Session::get('tongtien');
            $new_donhang->ngaydat = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $new_donhang->save();
            $tong_ban = 0;
            $tong_nhap = 0;
            foreach (Cart::content() as $item) {
                $price = $item->price - (($total_cart - session()->get('tongtien')) / $total_cart) * $item->price;
                //Cộng sản phẩm đã bán
                $sanpham = Sanpham::find($item->id);
                $sanpham->daban += $item->qty;
                $sanpham->save();

                $tong_ban +=  $price * $item->qty;
                $tong_nhap += $sanpham->gianhap * $item->qty;

                $new_donhang->sanpham()->attach($item->id, [
                    'soluong' => $item->qty, 'giaban' => $price,
                    'size' => $item->options->size->size, 'img' => $item->options->images
                ]);
                $sl = Size::where('size', $item->options->size->size)->where('id_sp', $item->id)->first();
                $sl->soluong = $sl->soluong - $item->qty;
                $sl->save();
                Cart::destroy($item->rowId);
            }
            //tích lũy thành viên
            if (Session::has('khachhang')) {
                $khachhang = User::find(Session::get('khachhang')->id);
                if ($khachhang->is_admin != 1) {
                    $khachhang->tonggd += Session::get('tongtien');
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
                    } else if (12000000 < $khachhang->tonggd) {
                        $khachhang->phantram =  0.1;
                    }
                    $khachhang->save();
                }
            }
            //thống kê
            $thongke = Thongke::where('ngaydat', Carbon::now('Asia/Ho_Chi_Minh')->toDateString())->first();
            if ($thongke != null) {
                $thongke->doanhthu += Session::get('tongtien');
                $thongke->loinhuan += $tong_ban - $tong_nhap;
                $thongke->donhang++;
                $thongke->save();
            } else {
                $thongke_new = new Thongke();
                $thongke_new->ngaydat = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                $thongke_new->doanhthu = Session::get('tongtien');
                $thongke_new->loinhuan = $tong_ban - $tong_nhap;
                $thongke_new->donhang = 1;
                $thongke_new->save();
            }
            Session::forget(['tongtien', 'khachhang']);
            return redirect('/admin/dsdonhang')->with('success', 'Đã tạo đơn hàng thành công. Mã đơn hàng: ' . $new_donhang->id);
        }
        return back()->with('error', 'Giỏ hàng không được trống!');
    }
    public function dsSanpham(Request $request)
    {
        if ($request->ajax()) {
            $size = Size::with('Sanpham')->get();
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
                })->addColumn('giaban', function ($size) {
                    $sp = Sanpham::where('id', $size->id_sp)->first();
                    return number_format($sp->giaban, 0, '.', '.');
                })->addColumn('action', function ($size) {
                    if ($size->soluong == 0) {
                        return '<button class="btn btn-outline-danger" disabled >Hết</button>';
                    }
                    return '<a href="#" onclick="addCart(' . $size->id_sp  . ',' . $size->id . ')" class="btn btn-outline-info">Chọn</a>';
                })->rawColumns(['tensp', 'img', 'soluong', 'action', 'giaban'])->make(true);
        }
        return view('pages_admin.donhang.add_donhang');
    }
    public function addCart($id, $size_sp, $qty)
    {
        $product = Sanpham::where('id', $id)->first();
        $img = Hinhanh::where('id_sp', $id)->where('avt', 1)->first();
        $size = Size::where('id', $size_sp)->first();
        $sl = $qty;
        foreach (Cart::content() as $item) {
            if ($item->id == $id && $item->options->size->id == $size_sp) {
                $sl = $item->qty + $qty;
            }
        }

        if ($size->soluong >= $sl) {
            Cart::add(
                [
                    'id' => $product->id,
                    'name' => $product->tensp,
                    'qty' => $qty,
                    'price' => $product->giakm == 0 ? $product->giaban : $product->giakm,
                    'options' => ['size' => $size, 'images' => $img->name]
                ]
            );
            $total_cart = str_replace(array(','), '', Cart::subtotal());
            if (Session::has('khachhang')) {
                Session::put([
                    'tongtien' => $total_cart - $total_cart * Session::get('khachhang')->phantram,
                ]);
            } else {
                Session::put(['tongtien' => $total_cart]);
            }
            return response()->json(['success' => 'Đã thêm vào giỏ hàng', 'data' => Cart::count()]);
        }
        return response()->json(['error' => 'Số lượng trong kho còn ' . $size->soluong . ' sản phẩm' .
            '<br>' . 'Chúng tôi xin lỗi vì sự bất tiện này!']);
    }

    public function deleteCart($id)
    {
        $thanhtien = Cart::get($id)->price * Cart::get($id)->qty;
        if (Session::has('khachhang')) {
            Session::put([
                'tongtien' => Session::get('tongtien') - ($thanhtien - ($thanhtien * Session::get('khachhang')->phantram)),
            ]);
        } else {
            Session::put(['tongtien' => Session::get('tongtien') - $thanhtien]);
        }
        Cart::remove($id);
        return back()->with('success', 'Đã xóa!');
    }
    public function updateCart($id, $quanty)
    {
        $qty = $quanty;
        $thanhtien = Cart::get($id)->price * Cart::get($id)->qty;
        if (Session::has('khachhang')) {
            Session::put([
                'tongtien' => Session::get('tongtien') - ($thanhtien - ($thanhtien * Session::get('khachhang')->phantram)),
            ]);
            Cart::update($id, $qty);

            Session::put([
                'tongtien' => str_replace(array(','), '', Cart::subtotal()) - str_replace(array(','), '', Cart::subtotal()) * Session::get('khachhang')->phantram,
            ]);
        } else {
            Cart::update($id, $qty);
            Session::put([
                'tongtien' => str_replace(array(','), '', Cart::subtotal()),
            ]);
        }
        return back()->with('success', 'Đã cập nhật!');
    }

    public function dsKhachhang(Request $req)
    {
        if ($req->ajax()) {
            $khachhang = User::where('is_admin', 0)->where('active', 1)->get();
            return  DataTables::of($khachhang)
                ->addColumn('action', function ($khachhang) {
                    if (Session::has("khachhang")) {
                        return '<button class="btn btn-outline-info" disabled/> Chọn</button>';
                    }
                    return '<a href="' . URL('admin/dsdonhang-chon-khachhang/' . $khachhang->id) . '" class="btn btn-outline-info">Chọn</a>';
                })->rawColumns(['action'])->make(true);
        }
        return view('pages_admin.donhang.add_donhang');
    }
    public function chonKhachhang($id)
    {
        session()->forget(['khachhang']);
        $khachhang = User::find($id);
        session()->put(['khachhang' => $khachhang]);
        session()->put(['tongtien' => session()->get('tongtien') - (session()->get('tongtien') * $khachhang->phantram)]);
        return back();
    }
    public function deleteKhachhang()
    {
        $total_cart = str_replace(array(','), '', Cart::subtotal());
        session()->forget(['khachhang']);
        Session::put(['tongtien' => $total_cart]);
        return back();
    }
    public function destroy($id)
    {
        //
        $donhang = Dondathang::where('id', $id)->delete();
        return response()->json($donhang);
    }
}
