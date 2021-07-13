<?php

namespace App\Http\Controllers;

use App\Loaisanpham;
use App\Dondathang;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Sanpham;
use App\Hinhanh;
use App\Size;
use App\Thuonghieu;
use App\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
        $loai_sp = Loaisanpham::all();
        $total_sp = Size::where('id_sp', $id)->sum('soluong');
        $chitiet_sp = Sanpham::with('size')->with('Hinhanh')->where('id', $id)->first();
        return view('pages.sanpham.chitiet_sanpham', compact('chitiet_sp', 'total_sp', 'loai_sp'));
    }
    public function getDSSanpham(Request $request)
    {
        if ($request->ajax()) {
            $sp = Sanpham::all();
            return  DataTables::of($sp)
                ->addColumn('action', function ($sp) {
                    return '<a href="javascript:void(0);" id="delete-product" data-toggle="tooltip"
                    data-original-title="Delete" data-id="' . $sp->id . ' " class="delete">
                    <i class="fas fa-trash-alt"></i></a>';
                })->editColumn('tensp', function ($sp) {
                    return '<a href="' . URL('/admin/danhsachsanpham-detail/' . $sp->id) . '" class="link text-primary">' . $sp->tensp . '</a>';
                })->editColumn('trangthai', function ($sp) {
                    if ($sp->trangthai == 1) {
                        return '<span class="text-success"> Đang bán <span/>';
                    } else {
                        return '<span class="text-warning"> Không đăng bán <span/>';
                    }
                })->rawColumns(['tensp', 'trangthai', 'action'])->make(true);
        }
        return view('pages_admin.sanpham.list_sanpham');
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
    public function getformAdd()
    {
        //
        $loai_sp = Loaisanpham::all();
        return view('pages_admin.sanpham.add_sanpham', compact('loai_sp'));
    }
    public function store(Request $request)
    {

        //DD($request->file('hinhanh'));
        $this->validate(
            $request,
            [
                'tensp' => 'required',
                'gianhap' => 'required',
                'giaban' => 'required|gt:gianhap',
                'hinhanh' => 'required',

            ],

            [
                'tensp.required' => 'Vui lòng nhập tên sản phẩm',
                'giaban.required' => 'Không được để trống',
                'giaban.gt' => 'Giá bán phải lớn hơn giá nhập',
                'gianhap.required' => 'Không được để trống',
                'hinhanh.required' => 'Không được để trống',

            ]
        );

        $new_product = new Sanpham();
        $new_product->tensp = $request->tensp;
        $new_product->gianhap =  $request->gianhap;
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

        return redirect('/admin/danhsachsanpham');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function chitietSanphamAdmin($id)
    {
        //
        $chitiet_sp = Sanpham::with('size')->with('hinhanh')->where('id', $id)->first();
        $total_sp = Size::with('sanpham')->where('id_sp', $id)->sum('soluong');
        $loai_sp = Loaisanpham::with('thuonghieu')->where('id', $chitiet_sp->id_lsp)->first();
        $all_loai = Loaisanpham::all()->whereNotIn('id', $chitiet_sp->id_lsp);
        $thuonghieu = Thuonghieu::where('id', $chitiet_sp->id_th)->first();
        return view(
            'pages_admin.sanpham.details_sanpham',
            compact('chitiet_sp', 'total_sp', 'loai_sp', 'all_loai', 'thuonghieu')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $this->validate(
            $request,
            [
                'tensp' => 'required',
                'gianhap' => 'required',
                'giaban' => 'required|gt:gianhap',
            ],

            [
                'tensp.required' => 'Vui lòng nhập tên sản phẩm',
                'giaban.required' => 'Không được để trống',
                'giaban.gt' => 'Giá bán phải lớn hơn giá nhập',
                'gianhap.required' => 'Không được để trống',

            ]
        );
        $edit_product = Sanpham::find($request->id);
        $edit_product->tensp = $request->tensp;
        $edit_product->gianhap =  $request->gianhap;
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
                })->rawColumns(['tensp', 'trangthai', 'giaodich', 'tonkho'])->make(true);
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
        //     $ncc = User::with('phieunhap')->where('id', 4)->first();
        //     foreach ($ncc->phieunhap as $i) {
        //         echo $i->id;
        //     }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sp = Sanpham::where('id', $id)->delete();
        return response()->json($sp);
    }
}
