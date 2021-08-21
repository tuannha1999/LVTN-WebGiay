<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dondathang;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function homeAdmin(Request $req)
    {
        //
        if ($req->ajax()) {
            $donhang = Dondathang::where('trangthai', 0)->get();
            return  DataTables::of($donhang)
                ->addColumn('action', function ($donhang) {
                    return '<a href="' . URL('admin/dsdonhang-donhang/' . $donhang->id) . '" class="btn btn-success">Duyệt</a>
                        <a href="javascript:void(0);" id="huy-dh" data-id="' . $donhang->id . ' " class="btn btn-warning">Hủy</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->editColumn('trangthai', function ($donhang) {
                    if ($donhang->trangthai == 0) {
                        return '<span class="text-warning">Chờ xử lý</span>';
                    } else if ($donhang->trangthai == 1) {
                        return '<span class="text-info">Chờ giao hàng</span>';
                    } else if ($donhang->trangthai == 2) {
                        return '<span class="text-primary">Đang giao hàng</span>';
                    } else if ($donhang->trangthai == 3) {
                        return '<span class="text-success">Hoàn thành</span>';
                    } else {
                        return '<span class="text-danger">Đã hủy</span>';
                    }
                })->editColumn('dathanhtoan', function ($donhang) {
                    if ($donhang->dathanhtoan == 1) {
                        return '<span class="text-success">Đã thanh toán</span>';
                    } else {
                        return '<span class="text-warning">Chưa thanh toán</span>';
                    }
                })->editColumn('tongtien', function ($donhang) {
                    return number_format($donhang->tongtien, 0, '.', '.');
                })->rawColumns(['action', 'trangthai', 'dathanhtoan', 'tongtien'])->make(true);
        }
        return view('admin.home_admin');
    }


    public function getLogin()
    {
        //
        return view('admin.dangnhap');
    }

    public function postLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required',
                'password' => 'required|min:6|max:20'
            ],
            [
                'email.required' => 'Vui lòng nhập Email',

                'password.required' => 'Vui lòng nhập Password',
                'password.min' => 'Password ít nhất 6 kí tự',
                'password.max' => 'Password không quá 20 kí tự'
            ]
        );

        $credential = ['email' => $request->email, 'password' => $request->password];


        if (Auth::attempt($credential)) {
            if (auth()->user()->is_admin == 1)
                return redirect()->route('getDHcanxuly');
        }

        return redirect()->back()->with('thongbao', 'Email hoặc Password không chính xác.');
    }
    public function getLogout()
    {
        //
        Auth::logout();
        return redirect()->route('getDHcanxuly');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function formChangePassword()
    {
        //
        return view("admin.thaydoi_password");
    }
    public function ChangePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Mật khẩu hiện tại không hợp lệ");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "Mật khẩu mới không được trùng với mật khẩu hiện tại");
        }
        $this->validate(
            $request,
            [
                'current-password' => 'required',
                'new-password' => 'required|min:6|max:20|confirmed',
            ],
            [
                'current-password.required' => 'Mật khẩu hiện tại không được để trống',
                'new-password.min' => 'Mật khẩu phải ít nhất 6 kí tự',
                'new-password.max' => 'Mật khẩu không quá 20 kí tự',
                'new-password.confirmed' => 'Mật khẩu nhập lại không khớp'

            ]
        );

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success", "Đã thay đổi password thành công!");
    }

    public function store(Request $request)
    {
        //
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
