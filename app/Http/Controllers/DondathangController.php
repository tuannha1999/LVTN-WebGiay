<?php

namespace App\Http\Controllers;

use App\Dondathang;
use App\Sanpham;
use App\Size;
use App\Loaisanpham;
use Illuminate\Http\Request;
use Cart;

class DondathangController extends Controller
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
    public function getformDatHang()
    {
        //
        $loai_sp = Loaisanpham::all();
        return view("pages.dathang.dathang", compact('loai_sp'));
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
        //
        $this->validate(
            $req,
            [
                'hoten' => 'required',
                'sdt' => 'numeric|digits:10',
                'diachi' => 'required',

            ],

            [
                'hoten.required' => 'Vui lòng nhập họ tên',
                'sdt.numeric' => 'Số điện thoại không hợp lệ',
                'sdt.digits' => 'Số điện thoại không hợp lệ',
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
        $new_dh = new Dondathang();
        $new_dh->hoten = $req->hoten;
        $new_dh->diachi = $req->diachi;
        $new_dh->sdt = $req->sdt;
        $new_dh->trangthai = 0;
        $new_dh->ptthanhtoan = $req->thanhtoan;
        $new_dh->ghichu = $req->ghichu;
        $new_dh->save();
        foreach (Cart::content() as $item) {
            $new_dh->sanpham()->attach($item->id, ['soluong' => $item->qty, 'giaban' => $item->price, 'size' => $item->options->size->size]);
            $sl = Size::where('size', $item->options->size->size)->where('id_sp', $item->id)->first();
            $sl->soluong = $sl->soluong - $item->qty;
            $sl->save();
            Cart::destroy($item->rowId);
        }
        return response()->json($req->sdt);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
