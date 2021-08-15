<?php

namespace App\Http\Controllers;

use App\Thuonghieu;
use App\Loaisanpham;
use App\Sanpham;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ThuonghieuController extends Controller
{
    //
    public function getDanhSach(Request $req)
    {
        if ($req->ajax()) {
            $thuonghieu = Thuonghieu::all();
            return  DataTables::of($thuonghieu)
                ->addColumn('action', function ($thuonghieu) {
                    return '<a href="javascript:void(0);" id="edit-thuonghieu" data-toggle="modal" data-id=' . $thuonghieu->id . '>
                    <i class="far fa-2x fa-edit"></i></a>
                    <a href="javascript:void(0);" id="delete-thuonghieu" data-id="' . $thuonghieu->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->rawColumns(['action'])->make(true);
        }
        return view('pages_admin.thuonghieu.list_thuonghieu');
    }
    public function add(Request $req)
    {

        $validator = Validator::make(
            $req->all(),
            [
                //kiem tra hop le
                'ten' => 'unique:thuonghieu,ten,' . $req->id,
            ],
            [
                'ten.unique' => 'Thương hiệu đã tồn tại',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Thuonghieu::updateOrCreate(['id' => $req->id], [
            'ten' => $req->ten,
            'slug' => Str::slug($req->ten, '-')
        ]);
        return redirect('/admin/dsthuonghieu');
    }
    public function delete($id)
    {
        $kt = Sanpham::where('id_th', $id)->get();
        if (!empty($kt)) {
            $delete_th = Thuonghieu::find($id)->delete();
            return response()->json(['success' => 'Đã xóa!', 'data' => $delete_th]);
        }
        return response()->json(['error' => 'Không Thể Xóa!']);
    }
    public function edit($id)
    {
        $where = array('id' => $id);
        $thuonghieu  = Thuonghieu::where($where)->first();

        return response()->json($thuonghieu);
    }
}
