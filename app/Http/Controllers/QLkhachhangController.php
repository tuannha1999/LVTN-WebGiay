<?php

namespace App\Http\Controllers;

use App\User;
use App\Dondathang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use Redirect;
use Response;

class QLkhachhangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDanhsach(Request $request)
    {
    if ($request->ajax()) {
    $kh = User::latest()->where('is_admin',0)->get();
    return Datatables::of($kh)
        ->addColumn('action', function ($kh) {
           return '<a class="btn btn-default"  id="edit-user" data-toggle="tooltip" href="' . URL('/admin/danhsachkhachhang-detail/'.$kh->id) . '"><i class="fa fa-eye"></i></a>
            <a class="btn btn-default" id="detail-user" data-toggle="tooltip" href="' . URL('/admin/danhsachkhachhang-edit/'.$kh->id) . '"><i class="far fa-edit"></i> </a>
            <a class="btn btn-default" href="javascript:void(0);" id="delete-user" data-toggle="tooltip" data-original-title="Delete" data-id="' . $kh->id . 
            '" class="delete"> <i class="fas fa-trash-alt"></i></a>
            ';
        
        })->rawColumns(['action'])->make(true);
    
    
    }

    return view('pages_admin.khachhang.list_khachhang');
    
    }
    public function getThem()
    {
        //
        return view('pages_admin.khachhang.add_khachhang');
    }
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                //kiem tra hop le
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'sdt' => 'required|unique:users,sdt|regex:/(0)[3-9][0-9]{8}/|max:10',
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


            ]
        );

        $new_user = new User();
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->sdt = $request->sdt;
        $new_user->password = bcrypt(123456); 
        $new_user->save();      

        return redirect('/admin/danhsachkhachhang');

    
    }
    public function getChitietkhachhang($id, Request $request)
    {
        //User::latest()->where('is_admin',0)->get()
        // $chitiet_kh = User::where('id', $id)->first();
        $chitiet_kh = User::with('dondathang')->where('id', $id)->first();

        if ($request->ajax()) {
            $dondathang_kh = Dondathang::with('users')->get();
            return Datatables::of($dondathang_kh)
                ->addColumn('action', function ($dondathang_kh) {
                   return '<a class="btn btn-default"  id="edit-user" data-toggle="tooltip" href="' . URL('/admin/danhsachkhachhang-detail/show/'.$dondathang_kh->id) . '"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-default" id="detail-user" data-toggle="tooltip" href="' . URL('/admin/danhsachkhachhang-edit/'.$dondathang_kh->id) . '"><i class="far fa-edit"></i> </a>
                    <a class="btn btn-default" href="javascript:void(0);" id="delete-user" data-toggle="tooltip" data-original-title="Delete" data-id="' . $dondathang_kh->id . 
                    '" class="delete"> <i class="fas fa-trash-alt"></i></a>
                    ';
                
                })->rawColumns(['action'])->make(true);
            
            
            }
        return view(
            'pages_admin.khachhang.details_khachhang',
             compact('chitiet_kh')
        );
    }
    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */

    public function show($id)
    {
    /* $where = array('id' => $id);
    $user = User::where($where)->first();
    
    return Response::json($user); */

    // return view('users.show',compact('user'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function getSua($id)
    {
        $chitiet_kh = User::where('id', $id)->first();
        return view('pages_admin.khachhang.edit_khachhang',
             compact('chitiet_kh')
        
    );
    }
    public function edit(Request $request)
    {
        $this->validate(
            $request,
            [
                //kiem tra hop le
                'name' => 'required',
                'email' => 'required|email',
                'sdt' => 'required|regex:/(0)[3-9][0-9]{8}/|max:10',
            ],
            [
                'name.required' => 'Vui lòng nhập tên khách hàng',

                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',

                'sdt.required' => 'Vui lòng nhập số điện thoại',
                'sdt.regex' => 'Số điện thoại không hợp lệ',
                'sdt.max' => 'Số điện thoại không hợp lệ',


            ]
        );

        $edit_user = User::find($request->id);
        $edit_user->name = $request->name;
        $edit_user->email = $request->email;
        $edit_user->sdt = $request->sdt;
        $edit_user->password = bcrypt(123456); 
        $edit_user->save();      
        $request->session()->flash('success', 'Cập nhật thành công');
        return redirect()->back();
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */

    public function destroy($id)
    {
    $user = User::where('id',$id)->delete();
    return Response::json($user);
    //return redirect()->route('users.index');
    }
}
