<?php

namespace App\Http\Controllers;

use App\Loaisanpham;
use App\Thuonghieu;
use Illuminate\Http\Request;
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
                    return '<a href="javascript:void(0);" id="delete-lsp" data-id="' . $loaisanpham->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>
                    <a href="javascript:void(0);" id="edit-lsp" data-toggle="modal" data-id=' . $loaisanpham->id . '>
                    <i class="far fa-2x fa-edit"></i></a>';
                })->rawColumns(['action'])->make(true);
        }
        return view('pages_admin.loaisanpham.list_loaisanpham');
    }
    public function add(Request $req)
    {
        Loaisanpham::updateOrCreate(['id' => $req->id_loai], [
            'tenloai' => $req->tenloai,
            'slug' => Str::slug($req->tenloai, '-')
        ]);
        // $new_loaisanpham = new Loaisanpham();
        // $new_loaisanpham->tenloai = $req->tenloai;
        // $new_loaisanpham->slug = Str::slug($req->tenloai, '-');
        // $new_loaisanpham->save();
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
