<?php

namespace App\Http\Controllers;

use App\Loaisanpham;
use App\Sanpham;
use App\Size;
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
        $loai_sp = Loaisanpham::all();
        return view('khachhang.dangnhap', compact('loai_sp'));
    }


    public function postLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:20'
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',

                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 6 kí tự',
                'password.max' => 'Mật khẩu không quá 20 kí tự'
            ]
        );

        $credential = ['email' => $request->email, 'password' => $request->password];


        if (Auth::attempt($credential)) {
            if (auth()->user()->is_admin == 0)
                return redirect('/');
        }

        return redirect()->back()->with('thongbao', 'Email hoặc mật khẩu không chính xác.');
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
        $loai_sp = Loaisanpham::all();
        return view('khachhang.dangki', compact('loai_sp'));
    }

    public function postRegister(Request $request)
    {

        $this->validate(
            $request,
            [
                //kiem tra hop le
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'sdt' => 'required|unique:users,sdt|regex:/(0)[3-9][0-9]{8}/|max:10',
                'password' => 'required|min:6|max:20'
            ],
            [
                'name.required' => 'Vui lòng nhập tên khách hàng',

                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại',

                'sdt.required' => 'Vui lòng nhập số điện thoại',
                'sdt.unique' => 'Số điện thoại đã tồn tại',
                'sdt.regex' => 'Số điện thoại không hợp lệ',
                'sdt.max' => 'Số điện thoại không hợp lệ',


                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 6 kí tự',
                'password.max' => 'Mật khẩu không quá 20 kí tự'

            ]
        );
        //$user= ... User
        $khachhang = new User(); //use App\users ở trên
        // ->db= ->name.blade
        $khachhang->name = $request->name;
        $khachhang->sdt = $request->sdt;
        $khachhang->email = $request->email;
        $khachhang->yeuthich = 0;
        $khachhang->level = 0;
        $khachhang->password = bcrypt($request->password); //mã hóa bcrypt
        $khachhang->save();
        return redirect()->back()->with('thanhcong', 'Đăng kí thành công');
    }



    public function getProfile()
    {
        //
        $loai_sp = Loaisanpham::all();
        return view('khachhang.profile', compact('loai_sp'));
    }

    public function chinhsachThanhVien()
    {
        //
        $loai_sp = Loaisanpham::all();
        return view('khachhang.chinhsach_thanhvien', compact('loai_sp'));
    }
    public function yeuthich()
    {
        //
        $loai_sp = Loaisanpham::all();
        $sp_yeuthich = User::find(Auth::user()->id);
        //dd(count($sp_yeuthich->sanpham));
        return view('khachhang.list_yeuthich', compact('sp_yeuthich', 'loai_sp'));
    }

    public function addyeuthich($id, $size)
    {
        //
        $loai_sp = Loaisanpham::all();
        if (Auth::check()) {
            $sanpham = Sanpham::with('hinhanh')->find($id);
            $size_sp = Size::where('size', $size)->where('id_sp', $id)->first();
            $user = User::find(Auth::user()->id);
            $user->yeuthich += 1;
            $user->save();
            foreach ($sanpham->hinhanh as $img) {
                if ($img->avt == 1) {
                    $user->sanpham()->attach([$id], ['img' => $img->name, 'size' => $size_sp->size]);
                }
            }
            return back();
        }
        return redirect('dangnhap');
    }
    public function deleteyeuthich($id)
    {
        //
        $loai_sp = Loaisanpham::all();
        $user = User::find(Auth::user()->id);
        $user->yeuthich -= 1;
        $user->save();
        $user->sanpham()->detach($id);
        return back();
    }
}
