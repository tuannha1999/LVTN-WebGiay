<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');

    }

    
    
    public function getLogin()
    {
        //
        return view('admin.dangnhap');

    }

    public function postLogin(Request $request)
    {
        $this->validate($request,
        [
            'email'=>'required',
            'password'=>'required|min:6|max:20'
        ],
        [
            'email.required'=>'Vui lòng nhập Email',

            'password.required'=>'Vui lòng nhập Password',
            'password.min'=>'Password ít nhất 6 kí tự',
            'password.max'=>'Password không quá 20 kí tự'
        ]
        );
        
        $credential=['email'=>$request->email,'password'=>$request->password];
        
        
        if(Auth::attempt($credential))
        {
            if (auth()->user()->is_admin == 1)
            return redirect()->route('noi-dung-admin');
        }
       
            return redirect()->back()->with('thongbao','Email hoặc Password không chính xác.');

    }
    public function getLogout()
    {
        //
        Auth::logout();
        return redirect()->route('show-form-login-admin');
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
