<?php

namespace App\Http\Controllers;

use App\Loaisanpham;
use App\Thuonghieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class LoaisanphamController extends Controller
{
    //

    public function getDanhSach(Request $req)
    {
        if ($req->ajax()) {
            $loaisanpham = Loaisanpham::all();
            return  DataTables::of($loaisanpham)
                ->addColumn('action', function ($loaisanpham) {
                    return '<a href="javascript:void(0);" id="edit-lsp" data-toggle="modal" data-id=' . $loaisanpham->id . '>
                    <i class="far fa-2x fa-edit"></i></a>
                    <a href="javascript:void(0);" id="delete-lsp" data-id="' . $loaisanpham->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->rawColumns(['action'])->make(true);
        }
        return view('pages_admin.loaisanpham.list_loaisanpham');
    }
    public function add(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                //kiem tra hop le
                'tenloai' => 'unique:loaisanpham,tenloai,' . $req->id,
            ],
            [
                'tenloai.unique' => 'Loại sản phẩm đã tồn tại',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Loaisanpham::updateOrCreate(['id' => $req->id], [
            'tenloai' => $req->tenloai,
            'slug' => Str::slug($req->tenloai)
        ]);
        return redirect('/admin/dsloaisanpham');
    }
    public function delete($id)
    {
        $delete_th = Loaisanpham::find($id)->delete();
        return response()->json($delete_th);
    }
    public function edit($id)
    {
        $loaisanpham  = Loaisanpham::where('id', $id)->first();

        return response()->json($loaisanpham);
    }
}
