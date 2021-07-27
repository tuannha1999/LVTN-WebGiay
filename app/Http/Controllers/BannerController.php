<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    //
    public function getBanner(Request $req)
    {
        if ($req->ajax()) {
            $banner = Banner::all();
            return  DataTables::of($banner)
                ->addColumn('action', function ($banner) {
                    if ($banner->trangthai == 1) {
                        return '<a href="' . URL('/admin/dsbanner-stop/' . $banner->id) . '" class="btn btn-danger">Stop</a>
                        <a href="javascript:void(0);" id="delete-banner" data-id="' . $banner->id . ' " class="delete">
                        <i class="fas fa-2x fa-trash-alt"></i></a>';
                    } else {
                        return '<a href="' . URL('/admin/dsbanner-run/' . $banner->id) . '" class="btn btn-success">Run</a>
                        <a href="javascript:void(0);" id="delete-banner" data-id="' . $banner->id . ' " class="delete">
                        <i class="fas fa-2x fa-trash-alt"></i></a>';
                    }
                })->addColumn('img', function ($banner) {
                    return '<img style="heigth:100px;width:400px;" src="' . asset('storage/' . $banner->name) . '" alt="Card image">';
                })->editColumn('trangthai', function ($banner) {
                    if ($banner->trangthai == 1) {
                        return '<span class="text-success"> Đang chạy </span>';
                    } else {
                        return '<span class="text-warning"> Đang tắt </span>';
                    }
                })->rawColumns(['action', 'img', 'trangthai'])->make(true);
        }
        return view('pages_admin.banner.list_banner');
    }
    public function addBanner(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                //kiem tra hop le
                'anh' => 'mimes:png,jpg',
            ],
        );

        if ($validator->fails()) {
            return back()->with('error', 'File ảnh không hợp lệ!');
        }
        $banner = new Banner();
        $banner->tieude = $req->tieude;
        $banner->trangthai = 1;
        $banner->id_user = Auth::user()->id;
        if ($req->hasFile('anh')) {
            $imageName = uniqid() . '.' . $req->file('anh')->extension();
            $req->file('anh')->move(('storage'), $imageName);
        }
        $banner->name = $imageName;
        $banner->save();
        return back()->with('success', 'Đã thêm banner!');
    }
    public function stopBanner($id)
    {
        $banner = Banner::find($id);
        $banner->trangthai = 0;
        $banner->save();
        return back()->with('error', 'Đã dừng banner!');
    }
    public function runBanner($id)
    {
        $banner = Banner::find($id);
        $banner->trangthai = 1;
        $banner->save();
        return back()->with('success', 'Đã chạy banner!');
    }
    public function deleteBanner($id)
    {
        $delete_banner = Banner::find($id)->delete();
        return back()->with('error', 'Đã xóa banner!');
    }
}
