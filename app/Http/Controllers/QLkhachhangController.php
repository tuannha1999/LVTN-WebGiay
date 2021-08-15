<?php

namespace App\Http\Controllers;

use App\User;
use App\Dondathang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class QLkhachhangController extends Controller
{
    public function getDanhSach(Request $req)
    {
        if ($req->ajax()) {
            $khachhang = User::where('is_admin', 0)->orderBy('active', 'asc')->get();
            return  DataTables::of($khachhang)
                ->addColumn('action', function ($khachhang) {
                    return '<a  id="edit-khachhang" data-toggle="tooltip"
                    href="' . URL('/admin/dskhachhang-detail/' . $khachhang->id) . '"><i class="fa fa-2x fa-eye"></i></a>
                    <a href="javascript:void(0);" id="edit-khachhang" data-toggle="modal" data-id=' . $khachhang->id . '>
                    <i class="far fa-2x fa-edit"></i></a>
                    <a href="javascript:void(0);" id="delete-khachhang" data-id="' . $khachhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->addColumn('tonggd', function ($khachhang) {
                    return number_format($khachhang->tonggd, 0, '.', '.');
                })->addColumn('active', function ($khachhang) {
                    if ($khachhang->active == 1) {
                        return '<span class="text-success">Đã xác thực</span>';
                    } else {
                        return '<span class="text-warning">Chưa xác thực</span>';
                    }
                })->rawColumns(['action', 'tonggd', 'active'])->make(true);
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
        $check = User::find($req->id);
        if ($check != null) {
            User::updateOrCreate(['id' => $req->id], [
                'name' => $req->tenkh,
                'email' => $req->email,
                'sdt' => $req->sdt,
                'yeuthich' => 0,
                'phantram' => 0,
                'password' => bcrypt(123456),
            ]);
        } else {
            $khachhang = User::updateOrCreate(['id' => $req->id], [
                'name' => $req->tenkh,
                'email' => $req->email,
                'sdt' => $req->sdt,
                'yeuthich' => 0,
                'phantram' => 0,
                'password' => bcrypt(123456),
            ]);
            $email = $khachhang->email;
            $code = bcrypt(md5(time() . $email));
            $url = route('user-verify-account', ['id' =>  $khachhang->id, 'code' => $code]);
            $khachhang->code_active = $code;
            $khachhang->email_verified_at = Carbon::now();
            $khachhang->save();
            $data = [
                'route' => $url
            ];
            Mail::send('email.verify_account', $data, function ($message) use ($email) {
                $message->to($email, 'Account Verification')->subject('Xác thực tài khoản - NT Store');
            });
        }

        return redirect('/admin/dskhachhang')->with('success', 'Đã tạo thành công. Cần xác thực tài khoản!');
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
