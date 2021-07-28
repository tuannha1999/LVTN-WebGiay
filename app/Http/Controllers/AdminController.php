<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dondathang;
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
            $donhang = Dondathang::where('trangthai',0)->orwhere('trangthai',1)->get();
            return  DataTables::of($donhang)
                ->addColumn('action', function ($donhang) {
                    return '<a href="' . URL('admin/dsdonhang-edit/'.$donhang->id) . '" class="btn btn-success">Duyệt</a>
                    <a class="btn" href="javascript:void(0);" id="delete-dh" data-id="' . $donhang->id . ' " class="delete">
                    <i class="fas fa-2x fa-trash-alt"></i></a>';
                })->editColumn('trangthai', function ($donhang) {

                    if ($donhang->trangthai == 0) {
                        return '<span class="text-warning">Chờ xử lý</span>';
                    } else if ($donhang->trangthai == 1) {
                        return '<span class="text-info">Đã thanh toán</span>';
                    } 
                    

                })->editColumn('ptthanhtoan', function ($donhang) {
                    if ($donhang->ptthanhtoan == 0) {
                        return '<span class="text-secondary"><b>Thanh toán khi nhận hàng</b></span>';
                    }else{
                        return '<span><b>Chuyển khoản ngân hàng</b></span>';
                    }
                })->editColumn('created_at', function ($donhang) {
                    $date = date("d-m-Y", strtotime($donhang->created_at));
                    return $date;
                })->rawColumns(['action', 'trangthai', 'created_at','ptthanhtoan'])->make(true);
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
