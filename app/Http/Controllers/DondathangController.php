<?php

namespace App\Http\Controllers;

use App\Cart as AppCart;
use App\Dondathang;
use App\Chitietdondathang;
use App\Hinhanh;
use App\Khuyenmai;
use App\Sanpham;
use App\Size;
use App\Loaisanpham;
use Illuminate\Http\Request;
use Cart;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
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
                        return '<a href="' . URL('admin/dsdonhang-edit/'.$donhang->id) . '" class="btn btn-success">Duyệt</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }elseif ($donhang->trangthai == 1) {
                        return '<a href="' . URL('admin/dsdonhang-edit/'.$donhang->id) . '" class="btn btn-success">Duyệt</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }elseif ($donhang->trangthai == 2) {
                        return '<a href="' . URL('admin/dsdonhang-edit/'.$donhang->id) . '" class="btn btn-success">Duyệt</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }elseif($donhang->trangthai == 3){
                        return '<a href="' . URL('admin/dsdonhang-detail/'.$donhang->id) . '" class="btn btn-info">Xem</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }else{
                        return '<a href="' . URL('admin/dsdonhang-detail/'.$donhang->id) . '" class="btn btn-info">Xem</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }

                })->editColumn('trangthai', function ($donhang) {
                    if ($donhang->trangthai == 0) {
                        return '<span class="text-warning">Chờ xử lý</span>';
                    } else if ($donhang->trangthai == 1) {
                        return '<span class="text-info">Đã thanh toán</span>';
                    } else if ($donhang->trangthai == 2) {
                        return '<span class="text-primary">Đang giao hàng</span>';
                    } else if ($donhang->trangthai == 3) {
                        return '<span class="text-success">Hoàn thành</span>';
                    } else{
                        return '<span class="text-danger">Đã hủy</span>';
                    }
                })->editColumn('ptthanhtoan', function ($donhang) {
                    if ($donhang->ptthanhtoan == 0) {
                        return '<span class="text-secondary"><b>Thanh toán khi nhận hàng</b></span>';
                    } else{
                        return '<span><b>Chuyển khoản ngân hàng</b></span>';
                    }
                                   
                })->editColumn('created_at', function ($donhang) {
                    $date = date("d-m-Y", strtotime($donhang->created_at));
                    return $date;
                /* })->addColumn('name', function ($dh) {
                    $kh = User::find($dh->id_kh);
                    return $kh->hoten; */
                })->rawColumns(['action', 'trangthai', 'created_at','ptthanhtoan'])->make(true);

        }
        return view('pages_admin.donhang.list_donhang');
    }

    public function chuyenformDatHang()
    {
        session()->forget(['tongtien', 'tiengiamma', 'daapdung', 'tiengiamtv', 'dagiamtv', 'macode']);
        return redirect('/form-dathang');
    }

    public function getformDatHang(Request $req)
    {

        //dd(session()->get('tongtien'));
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
            $new_dh->ngaydat = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $new_dh->save();
            foreach (Cart::content() as $item) {
                $hinhanh = Hinhanh::where('id_sp', $item->id)->get();
                $img = 0;
                foreach ($hinhanh as $anh) {
                    if ($anh->avt == 1) {
                        $img = $anh->name;
                    }
                }
                $price = $item->price - (($total_cart - session()->get('tongtien')) / $total_cart) * $item->price;
                $new_dh->sanpham()->attach($item->id, [
                    'soluong' => $item->qty, 'giaban' => $price,
                    'size' => $item->options->size->size, 'img' => $img
                ]);
                $sl = Size::where('size', $item->options->size->size)->where('id_sp', $item->id)->first();
                $sl->soluong = $sl->soluong - $item->qty;
                $sl->save();
                Cart::destroy($item->rowId);
            }
            session()->forget(['tongtien', 'tiengiamma', 'daapdung', 'tiengiamtv', 'dagiamtv', 'macode']);
            return redirect('dathang-thanhcong/' . $req->sdt);
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
    public function getChitietdonhangAdmin($id)
    {
        $loai_sp = Loaisanpham::all();
        $donhang = Dondathang::find($id);
        return view("pages_admin.donhang.details_donhang", compact('donhang', 'loai_sp'));
    }

    public function getDuyetdonhang($id)
    {
        $loai_sp = Loaisanpham::all();
        $donhang = Dondathang::find($id);
        return view("pages_admin.donhang.edit_donhang", compact('donhang', 'loai_sp'));
    }

    public function actionDonhang($id)
    {
        $donhang = Dondathang::find($id);
        $donhang_details= Chitietdondathang::with('sanpham')->with('dondathang')->where('id_dh',$id)->get();
        if($donhang->ptthanhtoan==0)
        {
            if($donhang->trangthai==0){
                if($donhang_details)
                {
                    //tang sp da ban
                    foreach($donhang_details as $donhang_detail)
                    {
                        $sp=Sanpham::find($donhang_detail->id_sp);
                        $sp->daban ++;
                        $sp->save();
                    }
                }
                $donhang->trangthai=Dondathang::dang_giao_hang;/////////
            }elseif($donhang->trangthai==2){
                if($donhang_details)
                {
                    //da thanh toan
                    foreach($donhang_details as $donhang_detail)
                    {
                        $thanhtoan= Dondathang::find($donhang_detail->id_dh);
                        $thanhtoan->dathanhtoan ++;
                        $thanhtoan->save();                       
                    }
                }
                $donhang->trangthai=Dondathang::hoan_thanh;
            }elseif($donhang->trangthai==3){
                if($donhang_details)
                {
                    //bo thanh toan, tru sp da ban
                    foreach($donhang_details as $donhang_detail)
                    {
                        $sanpham=Sanpham::find($donhang_detail->id_sp);
                        $thanhtoan= Dondathang::find($donhang_detail->id_dh);
                        $sanpham->daban --;
                        $thanhtoan->dathanhtoan --;
                        $thanhtoan->save();                       
                    }
                }
                $donhang->trangthai=Dondathang::da_huy;
            }
        }else{
            if($donhang->trangthai==0){
                if($donhang_details)
                {
                    //da thanh toan,tang sp da ban
                    foreach($donhang_details as $donhang_detail)
                    {
                        $sanpham=Sanpham::find($donhang_detail->id_sp);
                        $thanhtoan= Dondathang::find($donhang_detail->id_dh);
                        $sanpham->daban ++;
                        $thanhtoan->dathanhtoan ++;
                        $thanhtoan->save();                       
                    }
                }
                $donhang->trangthai=Dondathang::da_thanh_toan;
            }elseif($donhang->trangthai==1){
                $donhang->trangthai=Dondathang::dang_giao_hang;
            }elseif($donhang->trangthai==2){
                $donhang->trangthai=Dondathang::hoan_thanh;
            }elseif($donhang->trangthai==3){
                if($donhang_details)
                {
                    //bo thanh toan, tru sp da ban
                    foreach($donhang_details as $donhang_detail)
                    {
                        $sanpham=Sanpham::find($donhang_detail->id_sp);
                        $thanhtoan= Dondathang::find($donhang_detail->id_dh);
                        $sanpham->daban --;
                        $thanhtoan->dathanhtoan --;
                        $thanhtoan->save();                       
                    }
                }
                $donhang->trangthai=Dondathang::da_huy;
            }
        }

        $donhang->save();
        return redirect()->back()->with('success','Đã xử lý đơn hàng');
    }
    public function destroy($id)
    {
        //
        $donhang = Dondathang::where('id', $id)->delete();
        return response()->json($donhang);
    }
}
