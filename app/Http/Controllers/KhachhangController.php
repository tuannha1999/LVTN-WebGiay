<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KhachhangController extends Controller
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
    public function getLogin()
    {
        //
        return view('khachhang.dangnhap');
    }

    
    public function postLogin(Request $request)
    {
        $this->validate($request,
        [
            'email'=>'required|email',
            'password'=>'required|min:6|max:20'
        ],
        [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Email không hợp lệ',

            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 kí tự',
            'password.max'=>'Mật khẩu không quá 20 kí tự'
        ]
        );
        
        $credential=['email'=>$request->email,'password'=>$request->password];
        
        
        if(Auth::attempt($credential))
        {
            return redirect()->route('show-profile');
        }
       
            return redirect()->back()->with('thongbao','Email hoặc mật khẩu không chính xác.');
        
    }

    public function getLogout()
    {
        //
        Auth::logout();
        return redirect()->route('trangchu');
    }


    

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        //
        return view('khachhang.dangki');

    }

    public function postRegister(Request $request)
    {
        
        $this->validate($request,
            [
                //kiem tra hop le
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'sdt'=>'required|unique:users,sdt|regex:/(0)[3-9][0-9]{8}/|max:10',
                'password'=>'required|min:6|max:20'
            ],
            [
                'name.required'=>'Vui lòng nhập tên khách hàng',

                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email không hợp lệ',
                'email.unique'=>'Email đã tồn tại',

                'sdt.required'=>'Vui lòng nhập số điện thoại',
                'sdt.unique'=>'Số điện thoại đã tồn tại',
                'sdt.regex'=>'Số điện thoại không hợp lệ',
                'sdt.max'=>'Số điện thoại không hợp lệ',


                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự',
                'password.max'=>'Mật khẩu không quá 20 kí tự'

            ]);
        //$user= ... User
        $khachhang=new User(); //use App\users ở trên
        // ->db= ->name.blade
        $khachhang->name=$request->name;
        $khachhang->sdt=$request->sdt;
        $khachhang->email=$request->email;
        $khachhang->password=bcrypt($request->password) ; //mã hóa bcrypt
        $khachhang->save();
        return redirect()->back()->with('thanhcong','Đăng kí thành công');
        
    }
    


    public function getProfile()
    {
        //
        return view('khachhang.profile');

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
