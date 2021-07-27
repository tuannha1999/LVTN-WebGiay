<?php

namespace App\Http\Controllers;

use App\User;
use App\Dondathang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class QLkhachhangController extends Controller
{
    public function getDanhSach(Request $req)
    {
        if ($req->ajax()) {
            $khachhang = User::all();
            return  DataTables::of($khachhang)
                ->addColumn('action', function ($khachhang) {
                    return '<a  id="edit-khachhang" data-toggle="tooltip"
                    href="' . URL('/admin/dskhachhang-detail/' . $khachhang->id) . '"><i class="fa fa-2x fa-eye"></i></a>
                    <a href="javascript:void(0);" id="edit-khachhang" data-toggle="modal" data-id=' . $khachhang->id . '>
                    <i class="far fa-2x fa-edit"></i></a>
                    <a href="javascript:void(0);" id="delete-khachhang" data-id="' . $khachhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->rawColumns(['action'])->make(true);
        }
        return view('pages_admin.khachhang.list_khachhang');
    }

    public function add(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                //kiem tra hop le
                'email' => 'unique:users,email,' . $req->id,
                'sdt' => 'unique:users,sdt,' . $req->id . '|regex:/(0)[3-9][0-9]{8}/|max:10',
            ],
            [
                'email.unique' => 'Email đã tồn tại',

                'sdt.unique' => 'Số điện thoại đã tồn tại',
                'sdt.regex' => 'Số điện thoại không hợp lệ',
                'sdt.max' => 'Số điện thoại không hợp lệ',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        User::updateOrCreate(['id' => $req->id], [
            'name' => $req->tenkh,
            'email' => $req->email,
            'sdt' => $req->sdt,
            'yeuthich' => 0,
            'level' => 0,
            'password' => bcrypt(123456),
        ]);
        return redirect('/admin/dskhachhang');
    }

    public function detail($id)
    {
        $khachhang = User::with('dondathang')->where('id', $id)->first();
        return view('pages_admin.khachhang.details_khachhang', compact('khachhang'));
    }

    public function delete($id)
    {
        $delete_kh = User::find($id)->delete();
    }
    public function edit($id)
    {
        $where = array('id' => $id);
        $khachhang  = User::where($where)->first();

        return response()->json($khachhang);
    }
}
