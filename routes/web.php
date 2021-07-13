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

    //loaisp
    Route::get('admin/changelist/{id}', 'LoaisanphamController@changelist');

    //Phieunhap
    Route::get('admin/dsphieunhap', 'PhieunhapController@dsPhieuNhap')->name('getdsPhieuNhap');
    Route::get('admin/dsphieunhap-delete/{id}', 'PhieunhapController@delete');
    Route::get('admin/dsphieunhap-formadd', 'PhieunhapController@formAdd');
    Route::get('admin/dsphieunhap-nhacungcap/{id}', 'PhieunhapController@infoNhaCungCap');
    Route::get('admin/dsphieunhap-sanpham/{id}', 'PhieunhapController@searchSanPham');




    //size
    Route::get('admin/add-size/{id}/{size}', 'SizeController@create');
    Route::get('admin/list-size/{id}', 'SizeController@index');
    Route::get('admin/delete-size/{id}', 'SizeController@destroy');
});

//Admin


//sanpham
Route::get('/san-pham', 'SanphamController@all_sanpham');
Route::get('chitiet-sanpham/{id}', 'SanphamController@chitiet_sp');

//Loaisanpham
Route::get('loai-sanpham/{loai}', 'LoaisanphamController@index');

//thuonghieu
Route::get('thuonghieu/{loai}', 'ThuonghieuController@index');


//dat hang
Route::get('/form-dathang', 'DondathangController@getformDatHang');
Route::post('/hoantat-dathang', 'DondathangController@getformHoanTat');
Route::get('dathang-thanhcong/{sdt}', 'DondathangController@formSuccess');
Route::post('/dathang', 'DondathangController@store');

//hinhanh
Route::get('delete/{id}', 'HinhanhController@delete');
Route::get('avatar/{id}/{id_sp}', 'HinhanhController@avatar');



//Giohang
Route::post('/them-giohang', 'CartController@themGiohang')->name('Cart.themgiohang');
Route::get('xoa-giohang/{id}', 'CartController@xoaGiohang')->name('Cart.xoagiohang');
Route::get('qty-up/{rowid}', 'CartController@qtyUp');
Route::get('qty-down/{rowid}', 'CartController@qtyDown');
Route::get('/cart', 'CartController@getCart');



Route::get('test/', 'SanphamController@update');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
