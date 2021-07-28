<?php

namespace App\Http\Controllers;

use App\Coupons;
use App\Loaisanpham;
use App\Dondathang;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Sanpham;
use App\Hinhanh;
use App\Nhacungcap;
use App\Size;
use App\Phieunhap;
use App\Thongke;
use App\Thuonghieu;
use App\User;
use Carbon\Carbon;
use Cart;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;


class SanphamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function all_sanpham()
    {
        $all_sp = Sanpham::with('Hinhanh')->with('Size')->where('trangthai', 1)->get();
        $loai_sp = Loaisanpham::all();
        $thuonghieu = Thuonghieu::all();
        return view('pages.sanpham.all_sanpham', compact('all_sp', 'loai_sp', 'thuonghieu'));
    }
    public function chitiet_sp($id)
    {
        $sp_yeuthich = false;
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            foreach ($user->sanpham as $item) {
                if ($item->pivot->id_sp == $id) {
                    $sp_yeuthich = true;
                }
            }
        }

        $loai_sp = Loaisanpham::all();
        $total_sp = Size::where('id_sp', $id)->sum('soluong');
        $chitiet_sp = Sanpham::with('size')->with('Hinhanh')->where('id', $id)->first();
        $sp_lienquan = Sanpham::with('Hinhanh')->with('size')->where('id_th', $chitiet_sp->id_th)->whereNotIn('id', [$chitiet_sp->id])->paginate(8);
        return view('pages.sanpham.chitiet_sanpham', compact('chitiet_sp', 'total_sp', 'loai_sp', 'sp_lienquan', 'sp_yeuthich'));
    }
    public function getDSSanpham(Request $request)
    {
        if ($request->ajax()) {
            $sp = Sanpham::all()->sortByDesc('id');
            return  DataTables::of($sp)
                ->addColumn('action', function ($sp) {
                    return '<a href="javascript:void(0);" id="delete-product" data-toggle="tooltip"
                    data-original-title="Delete" data-id="' . $sp->id . ' " class="delete">
                    <i class="fas fa-trash-alt"></i></a>';
                })->addColumn('img', function ($sp) {
                    $img = Hinhanh::where('id_sp', $sp->id)->where('avt', 1)->first();
                    return '<img style="heigth:50px;width:50px;" src="' . asset('storage/' . $img->name) . '" alt="Card image">';
                })->editColumn('tensp', function ($sp) {
                    return '<a href="' . URL('/admin/danhsachsanpham-detail/' . $sp->id) . '" class="link text-primary">' . $sp->tensp . '</a>';
                })->editColumn('trangthai', function ($sp) {
                    if ($sp->trangthai == 1) {
                        return '<span class="text-success"> Đang bán <span/>';
                    } else {
                        return '<span class="text-warning"> Không đăng bán <span/>';
                    }
                })->rawColumns(['tensp', 'trangthai', 'action', 'img'])->make(true);
        }
        return view('pages_admin.sanpham.list_sanpham');
    }

    public function getformAdd()
    {
        //
        $loai_sp = Loaisanpham::all();
        $thuonghieu = Thuonghieu::all();
        return view('pages_admin.sanpham.add_sanpham', compact('loai_sp', 'thuonghieu'));
    }
    public function store(Request $request)
    {

        //dd($request->nosize);
        $request->old('tensp', 'giaban', 'lsp', 'trangthai', 'th', 'tags', 'nosize');
        $this->validate(
            $request,
            [
                'tensp' => 'required',
                'giaban' => 'required|gt:giakm|min:1000|max:100000000',
                'giakm' => 'required',
                'hinhanh' => 'required',
                'hinhanh.*' => 'mimes:jpeg,jpg,png',
                'lsp' => 'required',

                'tags' => 'required_if:nosize,""'

            ],
            [
                'tensp.required' => 'Tên sản phẩm không được để trống',
                'giaban.required' => 'Giá bán không được để trống',
                'hinhanh.required' => 'Hình ảnh không được để trống',
                'lsp.required' => 'Loại sản phẩm Không được để trống',
                'giakm.required' => 'Giá khuyến mãi Không được để trống',

                'hinhanh.*.mimes' => 'Hình ảnh không Đúng định dạng:jpeg,jpg,png',
                'giaban.gt' => 'Giá bán phải lớn hơn giá khuyến mãi',
                'giaban.min' => 'Giá bán phải lớn hơn 1000',
                'giaban.max' => 'Giá bán phải nhỏ hơn 100000000',
                'tags.required_if' => 'Nhập size hoặc chọn sản phẩm không có size',

            ]
        );

        $new_product = new Sanpham();
        $new_product->tensp = $request->tensp;
        $new_product->gianhap =  0;
        $new_product->giaban = $request->giaban;
        $new_product->giakm = $request->giakm == null ? 0 : $request->giakm;
        $new_product->id_lsp = $request->lsp;
        $new_product->id_th = $request->th;
        $new_product->trangthai = $request->trangthai == null ? 0 : 1;
        $new_product->daban = 0;
        $new_product->save();
        if ($request->tags !== null) {
            $str = str_replace(array('[', ']', '{', '}', 'value', ':', '"'), '', $request->tags);
            $arr_size = explode(',', $str);
            foreach ($arr_size as $size) {
                $new_size = new Size();
                $new_size->size = $size;
                $new_size->soluong = 0;
                $new_product->size()->save($new_size);
            }
        } else {
            $new_size = new Size();
            $new_size->size = 'default';
            $new_size->soluong = 0;
            $new_product->size()->save($new_size);
        }

        if ($request->hasFile('hinhanh')) {
            foreach ($request->file('hinhanh') as $key => $img) {
                $imageName = uniqid() . '.' . $img->extension();
                $img->move(('storage'), $imageName);
                $newImage = new Hinhanh();
                $newImage->url = 'http://' . request()->getHost() . '8000/img/sanpham/' . $imageName;
                $newImage->name = $imageName;
                $newImage->avt = $key == 0  ? 1 : 0;
                $new_product->Hinhanh()->save($newImage);
            }
        }
        $request->session()->flash('success', 'Thêm sản phẩm thành công!');
        return redirect('/admin/danhsachsanpham');
    }

    public function chitietSanphamAdmin($id)
    {
        //
        $chitiet_sp = Sanpham::with('size')->with('thuonghieu')->with('loaisanpham')->with('hinhanh')->where('id', $id)->first();
        $total_sp = Size::with('sanpham')->where('id_sp', $id)->sum('soluong');
        $all_loai = Loaisanpham::all()->whereNotIn('id', $chitiet_sp->id_lsp);
        $thuonghieu = Thuonghieu::all()->whereNotIn('id', $chitiet_sp->id_th);
        return view(
            'pages_admin.sanpham.details_sanpham',
            compact('chitiet_sp', 'total_sp', 'all_loai', 'thuonghieu')
        );
    }


    public function edit(Request $request)
    {
        $this->validate(
            $request,
            [
                'tensp' => 'required',
                'giaban' => 'required|gt:giakm|min:1000|max:100000000',
                'giakm' => 'required',
                'hinhanh.*' => 'mimes:jpeg,jpg,png',

            ],
            [
                'tensp.required' => 'Tên sản phẩm không được để trống',
                'giaban.required' => 'Giá bán không được để trống',
                'giakm.required' => 'Giá khuyến mãi Không được để trống',

                'hinhanh.*.mimes' => 'Hình ảnh không Đúng định dạng:jpeg,jpg,png',
                'giaban.gt' => 'Giá bán phải lớn hơn giá khuyến mãi',
                'giaban.min' => 'Giá bán phải lớn hơn 1000',
                'giaban.max' => 'Giá bán phải nhỏ hơn 100000000',

            ]
        );
        $edit_product = Sanpham::find($request->id);
        $edit_product->tensp = $request->tensp;
        //$edit_product->gianhap =  0;
        $edit_product->giaban = $request->giaban;
        $edit_product->giakm = $request->giakm == null ? 0 : $request->giakm;
        $edit_product->id_lsp = $request->lsp;
        $edit_product->id_th = $request->th;
        $edit_product->trangthai = $request->trangthai == null ? 0 : 1;
        $edit_product->daban = 0;
        $edit_product->save();
        if ($request->hasFile('hinhanh')) {
            foreach ($request->file('hinhanh') as $img) {
                $imageName = uniqid() . '.' . $img->extension();
                $img->move(('storage'), $imageName);
                $newImage = new Hinhanh();
                $newImage->url = 'http://' . request()->getHost() . '8000/img/sanpham/' . $imageName;
                $newImage->name = $imageName;
                $newImage->avt = 0;
                $edit_product->hinhanh()->save($newImage);
            }
        }
        $request->session()->flash('success', 'Cập nhật thành công');
        return redirect()->back();
    }

    public function khohang(Request $request)
    {
        if ($request->ajax()) {
            $size = Size::with('Sanpham')->get();
            return  DataTables::of($size)
                ->editColumn('tensp', function ($size) {
                    $sp = Sanpham::where('id', $size->id_sp)->first();
                    return $sp->tensp . ' - ' . $size->size;
                })->addColumn('trangthai', function ($size) {
                    $sp = Sanpham::where('id', $size->id_sp)->first();
                    if ($sp->trangthai == 0) {
                        return '<span class="text-warning">Không đăng bán</span>';
                    } else {
                        return '<span class="text-success">Đang bán</span>';
                    }
                })->addColumn('img', function ($size) {
                    $img = Hinhanh::where('id_sp', $size->id_sp)->where('avt', 1)->first();
                    return '<img style="heigth:50px;width:50px;" src="' . asset('storage/' . $img->name) . '" alt="Card image">';
                })->addColumn('giaodich', function ($size) {
                    $sp = Sanpham::where('id', $size->id_sp)->first();
                    $dh = Dondathang::all();
                    $total_gd = 0;
                    foreach ($dh as $dh) {
                        foreach ($dh->sanpham as $item) {
                            if ($size->size == $item->pivot->size && $size->id_sp == $item->pivot->id_sp && $dh->trangthai == 0) {
                                $total_gd += $item->pivot->soluong;
                            }
                        }
                    }
                    return $total_gd;
                })->addColumn('tonkho', function ($size) {
                    $sp = Sanpham::where('id', $size->id_sp)->first();
                    $dh = Dondathang::all();
                    $total_gd = 0;
                    foreach ($dh as $dh) {
                        foreach ($dh->sanpham as $item) {
                            if ($size->size == $item->pivot->size && $size->id_sp == $item->pivot->id_sp && $dh->trangthai == 0) {
                                $total_gd += $item->pivot->soluong;
                            }
                        }
                    }
                    return $size->soluong + $total_gd;
                })->rawColumns(['tensp', 'trangthai', 'giaodich', 'tonkho', 'img'])->make(true);
        }
        return view('pages_admin.sanpham.khohang');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        // dd(Cart::content());
        // $donhang = Dondathang::find(100177);
        // $tong_sl = 0;
        // foreach ($donhang->sanpham as $dh) {
        //     $tong_sl += $dh->pivot->soluong;
        // }
        // echo $tong_sl;
        //dd(Auth::check());
        // $range = Carbon::now()->subDays(7);
        // $thongke = Thongke::where('ngaydat', '>=', $range)->get();
        // return $thongke;
        //session()->forget(['tongtien', 'tiengiamma', 'daapdung', 'tiengiamma', 'dagiamtv']);
        // $de = Nhacungcap::where('id', 1000006)->delete();
        //session()->forget('Phieutra');
        //dd(session()->get('Phieutra'));
        //dd(session()->get('tongtien'));
        // foreach (Session::get('Phieutra')->products as $k => $item) {
        //     echo $k;
        // }
    }

    public function locLoaisp($loai)
    {
        $loai_sp = Loaisanpham::all();
        $thuonghieu = Thuonghieu::all();
        $loai = Loaisanpham::with('sanpham')->where('slug', $loai)->first();
        return view('pages.sanpham.loai_sp', compact('loai_sp', 'loai', 'thuonghieu'));
    }
    public function locthuonghieu($loai)
    {
        $loai_sp = Loaisanpham::all();
        $thuonghieu = Thuonghieu::all();
        $loai = Thuonghieu::with('sanpham')->where('ten', $loai)->first();
        return view('pages.sanpham.loai_sp', compact('loai_sp', 'loai', 'thuonghieu'));
    }

    public function locgia($value)
    {
        session()->flash('locgia', $value);
        $loai_sp = Loaisanpham::all();
        $thuonghieu = Thuonghieu::all();
        if ($value == 1) {
            $loc_gia = Sanpham::all()->whereBetween('giaban', [0, 1000000]);
        } else if ($value == 2) {
            $loc_gia = Sanpham::all()->whereBetween('giaban', [1000000, 2000000]);
        } else if ($value == 3) {
            $loc_gia = Sanpham::all()->whereBetween('giaban', [2000000, 3000000]);
        } else if ($value == 4) {
            $loc_gia = Sanpham::all()->whereBetween('giaban', [3000000, 4000000]);
        } else if ($value == 5) {
            $loc_gia = Sanpham::all()->whereBetween('giaban', [4000000, 5000000]);
        } else if ($value == 6) {
            $loc_gia = Sanpham::all()->where('giaban', '>', 5000000);
        } else {
            $loc_gia = Sanpham::all();
        }
        //dd($loc_gia);
        return view("pages.sanpham.loc_gia", compact('loai_sp', 'loc_gia', 'thuonghieu'));
    }

    public function destroy($id)
    {
        $sp = Sanpham::where('id', $id)->delete();
        return response()->json($sp);
    }
}
