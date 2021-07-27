<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Nhacungcap;
use App\Phieunhap;
use App\Sanpham;
use Illuminate\Support\Facades\Validator;

class NhacungcapController extends Controller
{
    //
    public function getDanhSach(Request $req)
    {
        if ($req->ajax()) {
            $nhacungcap = Nhacungcap::all();
            return  DataTables::of($nhacungcap)
                ->addColumn('action', function ($nhacungcap) {
                    return '<a  id="edit-khachhang" data-toggle="tooltip"
                    href="' . URL('/admin/dsnhacungcap-detail/' . $nhacungcap->id) . '"><i class="fa fa-2x fa-eye"></i></a>
                    <a href="javascript:void(0);" id="edit-nhacungcap" data-toggle="modal" data-id=' . $nhacungcap->id . '>
                    <i class="far fa-2x fa-edit"></i></a>
                    <a href="javascript:void(0);" id="delete-nhacungcap" data-id="' . $nhacungcap->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->addColumn('tonggd', function ($nhacungcap) {
                    $total = 0;
                    $pn = Phieunhap::where('id_ncc', $nhacungcap->id)->get();
                    foreach ($pn as $pn) {
                        $total += $pn->tongtien;
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
        $phieunhap = Phieunhap::where('id_ncc', $id)->where('thanhtoan', 0)->get();
        foreach ($phieunhap as $item) {
            $total += $item->tongtien;
        }
        return view("pages_admin.nhacungcap.chitiet_nhacungcap", compact('nhacungcap', 'total'));
    }
    public function add(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                //kiem tra hop le
                'diachi' => 'required',
                'tenncc' => 'required|unique:nhacungcap,tenncc,' . $req->id,
                'email' => 'required|unique:nhacungcap,email,' . $req->id,
                'sdt' => 'required|unique:nhacungcap,sdt,' . $req->id,

            ],
            [
                'tenncc.required' => 'Tên nhà cung cấp không được để trống',
                'diachi.required' => 'Địa chỉ không được để trống',
                'email.required' => 'Email không được để trống',
                'sdt.required' => 'Số điện thoại không được để trống',


                'tenncc.unique' => 'Tên nhà cung cấp đã tồn tại',
                'email.unique' => 'Email nhà cung cấp đã tồn tại',
                'sdt.unique' => 'Số điện thoại nhà cung cấp đã tồn tại',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Nhacungcap::updateOrCreate(['id' => $req->id], [
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
