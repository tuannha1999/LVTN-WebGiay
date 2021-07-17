<?php

use App\Chitietdondathang;
use App\Danhmuc;
use App\Dondathang;
use App\Sanpham;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Home Controller
Route::get('/', 'HomeController@index')->name('trangchu');
Route::get('/trang-chu', 'HomeController@index');
Route::get('search', 'HomeController@search');


//Khachhang
Route::get('dangnhap', 'KhachhangController@getLogin')->name('show-form-login');
Route::post('dangnhap', 'KhachhangController@postLogin')->name('login');

Route::get('dangki', 'KhachhangController@getRegister')->name('show-form-register');
Route::post('dangki', 'KhachhangController@postRegister')->name('register');
//
Route::middleware('checklogin')->group(function () {

    Route::get('dangxuat', 'KhachhangController@getLogout')->name('logout');

    Route::get('profile', 'KhachhangController@getProfile')->name('show-profile');
    Route::post('profile', 'KhachhangController@postProfile')->name('profile');
});
//Khachhang


//Admin
Route::get('admin', 'AdminController@getLogin')->name('show-form-login-admin');
Route::post('admin', 'AdminController@postLogin')->name('login-admin');
//
Route::middleware('checkloginadmin')->group(function () {

    Route::get('index', 'AdminController@index')->name('noi-dung-admin');
    Route::get('logout', 'AdminController@getLogout');
    //khachhang
    Route::resource('users', 'QLkhachhangController');
    Route::get('users/{id}/edit/', 'QLkhachhangController@edit');

    //sanpham
    Route::get('admin/danhsachsanpham', 'SanphamController@getDSSanpham')->name('getSanpham');
    Route::get('admin/danhsachsanpham-delete/{id}', 'SanphamController@destroy');
    Route::get('admin/danhsachsanpham-formadd', 'SanphamController@getformAdd');
    Route::post('admin/danhsachsanpham/add-sp', 'SanphamController@store')->name('create-product');
    Route::post('admin/danhsachsanpham/edit-sp', 'SanphamController@edit')->name('edit-product');
    Route::get('admin/danhsachsanpham-detail/{id}', 'SanphamController@chitietSanphamAdmin');
    Route::get('admin/khohang', 'SanphamController@khohang')->name('khohang');

    //hinhanh
    Route::get('delete/{id}', 'HinhanhController@delete');
    Route::get('avatar/{id}/{id_sp}', 'HinhanhController@avatar');

    //loaisp
    Route::get('admin/changelist/{id}', 'LoaisanphamController@changelist');

    //Phieunhap
    Route::get('admin/dsphieunhap', 'PhieunhapController@dsPhieuNhap')->name('getdsPhieuNhap');
    Route::get('admin/dsphieunhap-detail/{id}', 'PhieunhapController@detailPhieuNhap');
    Route::get('admin/dsphieunhap-delete/{id}', 'PhieunhapController@delete');
    Route::get('/admin/dsphieunhap-formadd', 'PhieunhapController@formAdd');
    Route::post('admin/dsphieunhap-add', 'PhieunhapController@addPhieuNhap');
    Route::get('/admin/dsphieunhap-nhacungcap', 'PhieunhapController@dsNhaCungCap')->name('getdsNhaCungCap');
    Route::get('admin/dsphieunhap-addncc/{id}', 'PhieunhapController@addNCC');
    Route::get('admin/dsphieunhap-deletencc/{id}', 'PhieunhapController@RemoveNCC');
    Route::get('/admin/dsphieunhap-getsanpham', 'PhieunhapController@dsSanPham')->name('getdsSanPham');
    Route::get('admin/dsphieunhap-addsanpham/{id}/{size}/{qty}/{price}', 'PhieunhapController@addSanPham');
    Route::get('admin/dsphieunhap-deletesanpham/{id}', 'PhieunhapController@RemoveItemCart');
    Route::get('admin/dsphieunhap-updatesanpham/{id}/{qty}/{price}', 'PhieunhapController@updateCart');
    Route::get('admin/dsphieunhap-nhapkho/{id}', 'PhieunhapController@nhapkho');
    Route::get('admin/dsphieunhap-thanhtoan/{id}', 'PhieunhapController@thanhtoan');

    //thuonghieu
    Route::get('/admin/dsthuonghieu', 'ThuonghieuController@getDanhSach')->name('getThuonghieu');
    Route::get('admin/dsthuonghieu-delete/{id}', 'ThuonghieuController@delete');
    Route::post('/admin/dsthuonghieu-add', 'ThuonghieuController@add');
    Route::get('admin/dsthuonghieu-edit/{id}', 'ThuonghieuController@edit');

    //loaisanpham
    Route::get('/admin/dsloaisanpham', 'LoaisanphamController@getDanhSach')->name('getLoaisanpham');
    Route::get('admin/dsloaisanpham-delete/{id}', 'LoaisanphamController@delete');
    Route::post('/admin/dsloaisanpham-add', 'LoaisanphamController@add');
    Route::get('admin/dsloaisanpham-edit/{id}', 'LoaisanphamController@edit');

    //nhacungcap
    Route::get('/admin/dsnhacungcap', 'NhacungcapController@getDanhSach')->name('getNhacungcap');
    Route::get('admin/dsnhacungcap-delete/{id}', 'NhacungcapController@delete');
    Route::post('/admin/dsnhacungcap-add', 'NhacungcapController@add');
    Route::get('admin/dsnhacungcap-detail/{id}', 'NhacungcapController@chitietNhaCungCap');
    Route::get('admin/dsnhacungcap-edit/{id}', 'NhacungcapController@edit');






    //size
    Route::get('admin/add-size/{id}/{size}', 'SizeController@create');
    Route::get('admin/list-size/{id}', 'SizeController@index');
    Route::get('admin/delete-size/{id}', 'SizeController@destroy');
});

//Admin


//sanpham
Route::get('/san-pham', 'SanphamController@all_sanpham');
Route::get('chitiet-sanpham/{id}', 'SanphamController@chitiet_sp');

//locsanpham
Route::get('loai-sanpham/{loai}', 'SanphamController@locLoaisp');
Route::get('loc-gia-san-pham/{value}', 'SanphamController@locgia');
Route::get('loc-thuonghieu/{loai}', 'SanphamController@locthuonghieu');



//dat hang
Route::get('/form-dathang', 'DondathangController@getformDatHang');
Route::post('/hoantat-dathang', 'DondathangController@getformHoanTat');
Route::get('dathang-thanhcong/{sdt}', 'DondathangController@formSuccess');
Route::post('/dathang', 'DondathangController@store');
// Route::get('change-province/{id}', 'DondathangController@changeProvinces');
// Route::get('change-district/{id}', 'DondathangController@changeDistrict');


//Giohang
Route::post('/them-giohang', 'CartController@themGiohang')->name('Cart.themgiohang');
Route::get('xoa-giohang/{id}', 'CartController@xoaGiohang')->name('Cart.xoagiohang');
Route::get('qty-up/{rowid}', 'CartController@qtyUp');
Route::get('qty-down/{rowid}', 'CartController@qtyDown');
Route::get('/cart', 'CartController@getCart');



Route::get('test/', 'SanphamController@update');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
