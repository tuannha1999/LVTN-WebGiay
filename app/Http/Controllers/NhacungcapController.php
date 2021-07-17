<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Nhacungcap;
use App\Phieunhap;
use App\Sanpham;

class NhacungcapController extends Controller
{
    //
    public function getDanhSach(Request $req)
    {
        if ($req->ajax()) {
            $nhacungcap = Nhacungcap::all();
            return  DataTables::of($nhacungcap)
                ->addColumn('action', function ($nhacungcap) {
                    return '<a href="javascript:void(0);" id="delete-nhacungcap" data-id="' . $nhacungcap->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>
                    <a href="javascript:void(0);" id="edit-nhacungcap" data-toggle="modal" data-id=' . $nhacungcap->id . '>
                    <i class="far fa-2x fa-edit"></i></a>';
                })->addColumn('tonggd', function ($nhacungcap) {
                    $total = 0;
                    $pn = Phieunhap::where('id_ncc', $nhacungcap->id)->get();
                    foreach ($pn as $pn) {
                        foreach ($pn->sanpham as $sp) {
                            $total += $sp->pivot->gianhap * $sp->pivot->soluong;
                        }
                    }
                    return number_format($total, 0, '.', '.');
                })->editColumn('id', function ($nhacungcap) {
                    return '<a href="' . URL('admin/dsnhacungcap-detail/' . $nhacungcap->id) . '" class="link text-primary">' . $nhacungcap->id . '</a>';
                })->rawColumns(['action', 'id', 'tonggd'])->make(true);
        }
        return view('pages_admin.nhacungcap.list_nhacungcap');
    }
    public function chitietNhaCungCap($id)
    {
        $nhacungcap = Nhacungcap::with('phieunhap')->where('id', $id)->first();
        $total = 0;
        // $phieunhap = Phieunhap::where('id_ncc', $id)->get();
        return view("pages_admin.nhacungcap.chitiet_nhacungcap", compact('nhacungcap'));
    }
    public function add(Request $req)
    {
        Nhacungcap::updateOrCreate(['id' => $req->id_ncc], [
            'tenncc' => $req->tenncc,
            'email' => $req->email,
            'diachi' => $req->diachi,
            'sdt' => $req->sdt,
        ]);
        return redirect('/admin/dsnhacungcap');
    }
    public function delete($id)
    {
        $delete_ncc = Nhacungcap::find($id)->delete();
        return response()->json($delete_ncc);
    }
    public function edit($id)
    {
        $where = array('id' => $id);
        $nhacungcap  = Nhacungcap::where($where)->first();

        return response()->json($nhacungcap);
    }
}
