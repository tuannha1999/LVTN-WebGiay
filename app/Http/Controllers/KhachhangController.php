<?php

namespace App\Http\Controllers;

use App\Dondathang;
use App\Loaisanpham;
use App\Sanpham;
use App\Size;
use App\User;
use Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;




class KhachhangController extends Controller
{
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

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            if (auth()->user()->is_admin == 0) {
                return redirect('/');
            }
        }
        return redirect()->back()->with('thongbao', 'Email hoặc mật khẩu không chính xác. Và hãy đảm bảo bạn đã xác thực tài khoản ở email!');
    }
    public function getFormResetPassword()
    {
        $loai_sp = Loaisanpham::all();
        return view('khachhang.passwords.email', compact('loai_sp'));
    }
    public function sendCoderesetPassword(Request $request)
    {
        $email = $request->email;
        $checkUser = User::where('email', $email)->first();
        if (!$checkUser) {
            return redirect()->back()->with('error', 'Email không tồn tại.');
        }

        $code = bcrypt(md5(time() . $email));
        $checkUser->code = $code;
        $checkUser->time_code = Carbon::now();
        $checkUser->save();

        //dd($checkUser->toArray());
        $url = route('get-link-reset-password', ['code' => $checkUser->code, 'email' => $email]);
        $data = [
            'route' => $url
        ];

        Mail::send('email.reset_password', $data, function ($message) use ($email) {
            $message->to($email, 'Reset Password')->subject('Lấy lại mật khẩu - NT Store');
        });
        return redirect()->back()->with('success', 'Thành công! Link lấy lại mật khẩu đã gửi vào email của bạn.');
    }
    public function resetPassword(Request $request)
    {
        $loai_sp = Loaisanpham::all();

        $code = $request->code;
        $email = $request->email;
        $checkUser = User::where([
            'code' => $code,
            'email' => $email
        ])->first();

        if (!$checkUser) {
            return redirect('quen-mat-khau')->with('hethan', 'Vui lòng nhập lại email vì link đã quá hạn!');
        }

        return view('khachhang.passwords.reset', compact('loai_sp'));
    }
    public function saveResetpassword(Request $request)
    {
        $data = $request->all();
        $code_random = Str::random();
        $customer = User::where('email', '=', $data['email'])->where('code', '=', $data['code'])->get();
        $count = $customer->count();
        if ($count > 0) {
            foreach ($customer as $key => $cus) {
                $customer_id = $cus->id;
            }
            $this->validate(
                $request,
                [
                    'password' => 'min:6|max:20|confirmed'
                ],
                [
                    'password.min' => 'Mật khẩu ít nhất 6 kí tự',
                    'password.max' => 'Mật khẩu không quá 20 kí tự',
                    'password.confirmed' => 'Mật khẩu nhập lại không khớp'

                ]
            );
            $reset = User::find($customer_id);
            $reset->password = bcrypt($data['password']);
            $reset->code = $code_random;
            $reset->save();
            return redirect('dangnhap')->with('success', 'Mật khẩu đã được cập nhật mới.');
        } else {
            return redirect('quen-mat-khau')->with('hethan', 'Vui lòng nhập lại email vì link đã quá hạn');
        }
    }
    public function getLogout()
    {
        Auth::logout();
        session()->forget(['dagiamtv']);
        session()->put('tongtien', session()->get('tongtien') + session()->get('tiengiamtv'));
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
        $khachhang = new User();
        $khachhang->name = $request->name;
        $khachhang->sdt = $request->sdt;
        $khachhang->email = $request->email;
        $khachhang->yeuthich = 0;
        $khachhang->phantram = 0;
        $khachhang->password = bcrypt($request->password);
        $khachhang->save();

        if ($khachhang->id) {
            $email = $khachhang->email;
            $code = bcrypt(md5(time() . $email));
            $url = route('user-verify-account', ['id' => $khachhang->id, 'code' => $code]);
            $khachhang->code_active = $code;
            $khachhang->email_verified_at = Carbon::now();
            $khachhang->save();

            $data = [
                'route' => $url
            ];
            Mail::send('email.verify_account', $data, function ($message) use ($email) {
                $message->to($email, 'Account Verification')->subject('Xác thực tài khoản - NT Store');
            });
            return redirect()->back()->with('thongbao', 'LINK xác thực tài khoản đã gửi vào email của bạn!');
        }
        return redirect()->back();
    }

    public function verifyAccount(Request $request)
    {
        $code = $request->code;
        $id = $request->id;
        $code_random = Str::random();
        $checkUser = User::where([
            'code_active' => $code,
            'id' => $id
        ])->first();
        if (!$checkUser) {
            return redirect('dangki')->with('error', 'Xin lỗi! Đường dẫn xác thực không tồn tại');
        }
        $checkUser->active = 1;
        $checkUser->code_active = $code_random;
        $checkUser->save();
        return redirect('dangnhap')->with('success', 'Xác thực tài khoản thành công! Mời bạn đăng nhập');
    }

    public function getProfile()
    {
        $loai_sp = Loaisanpham::all();
        return view('khachhang.profile', compact('loai_sp'));
    }
    public function editProfile(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email',
                'sdt' => 'required|regex:/(0)[3-9][0-9]{8}/|max:10',
            ],
            [
                'name.required' => 'Vui lòng nhập tên thành viên',

                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',

                'sdt.required' => 'Vui lòng nhập số điện thoại',
                'sdt.regex' => 'Số điện thoại không hợp lệ',
                'sdt.max' => 'Số điện thoại không hợp lệ',
            ]
        );
        $profile = User::find($request->id);
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->sdt = $request->sdt;
        $profile->save();
        $request->session()->flash('success', 'Cập nhật thành công');
        return redirect()->back();
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
    public function dsDonhangganday($id)
    {
        $loai_sp = Loaisanpham::all();
        $donhang = Dondathang::where('id_kh', Auth::user()->id)->orderby('id', 'desc')->get();
        //dd($donhang);
        return view('khachhang.lichsumuahang', compact('loai_sp', 'donhang'));
    }
}
