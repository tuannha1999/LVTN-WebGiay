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
Route::get('dangnhap','KhachhangController@getLogin')->name('show-form-login');
Route::post('dangnhap','KhachhangController@postLogin')->name('login');

Route::get('dangki','KhachhangController@getRegister')->name('show-form-register');
Route::post('dangki','KhachhangController@postRegister')->name('register');
//
Route::middleware('checklogin')->group(function(){

Route::get('dangxuat','KhachhangController@getLogout')->name('logout');
    
Route::get('profile','KhachhangController@getProfile')->name('show-profile');
Route::post('profile','KhachhangController@postProfile')->name('profile');
});
//Khachhang


//Admin
Route::get('admin','AdminController@getLogin')->name('show-form-login-admin');
Route::post('admin','AdminController@postLogin')->name('login-admin');
//
Route::middleware('checkloginadmin')->group(function(){

Route::get('logout','AdminController@getLogout');

//donhang
Route::get('danhsachdonhang','DonhangController@getDSDonhang')->name('danh-sach-don-hang');//index admin
//sanpham
});

//Admin


//sanpham
Route::get('/san-pham', 'SanphamController@all_sanpham');
Route::get('chitiet-sanpham/{id}', 'SanphamController@chitiet_sp');
Route::get('loai-sanpham/{id}', 'SanphamController@loai_sp');

//Giohang
Route::get('them-giohang/{id}/{quanty}', 'CartController@themGiohang');
Route::get('xoa-giohang/{id}', 'CartController@xoaGiohang');
Route::post('/suaAll-giohang', 'CartController@suaAllGiohang');
Route::get('/cart', 'CartController@getCart');



Route::get('/test', function () {
    return view('pages.sanpham.cart');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
