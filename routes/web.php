<?php

use App\Chitietdondathang;
use App\Danhmuc;
use App\Dondathang;
use App\Sanpham;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;





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
Route::get('/trang-chu', 'HomeController@index');//
Route::get('search', 'HomeController@search');
Route::get('/form-search-donhang', 'HomeController@formsearchDonHang');
Route::get('/search-donhang', 'HomeController@searchDonHang');
Route::get('/form-search-donhang', 'HomeController@formsearchDonHang');
Route::get('/gioi-thieu', 'HomeController@gioiThieu');
Route::get('/hinh-thuc-thanh-toan', 'HomeController@hinhThucThanhToan');
Route::get('chinh-sach-thanh-vien', 'KhachhangController@chinhsachThanhVien');



//Khachhang
Route::get('dangnhap', 'KhachhangController@getLogin')->name('show-form-login');
Route::post('dangnhap', 'KhachhangController@postLogin')->name('login');
Route::get('quen-mat-khau', 'KhachhangController@getFormResetPassword')->name('form-reset-password');
Route::post('quen-mat-khau', 'KhachhangController@sendCoderesetPassword');
Route::get('dat-lai-mat-khau', 'KhachhangController@resetPassword')->name('get-link-reset-password');
Route::post('dat-lai-mat-khau', 'KhachhangController@saveResetpassword');

Route::get('dangki', 'KhachhangController@getRegister')->name('show-form-register');
Route::post('dangki', 'KhachhangController@postRegister')->name('register');
Route::get('xac-nhan-tai-khoan', 'KhachhangController@verifyAccount')->name('user-verify-account');





//
Route::middleware('checklogin')->group(function () {

    Route::get('dangxuat', 'KhachhangController@getLogout')->name('logout');
    //yeuthich
    Route::get('yeuthich', 'KhachhangController@yeuthich');
    Route::get('add-yeuthich/{id}/{size}', 'KhachhangController@addyeuthich');
    Route::get('delete-yeuthich/{id}', 'KhachhangController@deleteyeuthich');

    Route::get('profile/{id}', 'KhachhangController@getProfile');
    Route::post('profile-edit', 'KhachhangController@editProfile');

    Route::get('lich-su-mua-hang/{id}', 'KhachhangController@dsDonhangganday')->name('list-don-hang-gan-day');



});
//Khachhang


//Admin
Route::get('admin', 'AdminController@getLogin')->name('show-form-login-admin');
Route::post('admin', 'AdminController@postLogin')->name('login-admin');
//
Route::middleware('checkloginadmin')->group(function () {

    Route::get('index', 'AdminController@homeAdmin')->name('getDHcanxuly');
    Route::get('logout', 'AdminController@getLogout');

    //Home

    //Donhang
    Route::get('/admin/dsdonhang', 'DondathangController@getDanhsach')->name('getDonHang');
    Route::post('admin/dsdonhang-update-donhang/', 'DondathangController@updateDonHang');
    Route::get('admin/dsdonhang-update-sanpham/{id}/{sp}/{size}/{qty}', 'DondathangController@updateSanPham');
    Route::get('admin/dsdonhang-delete-sanpham/{id}/{sp}/{size}', 'DondathangController@deleteSanPhamDH');
    Route::get('admin/dsdonhang-formadd', 'DondathangController@formTaoDon');
    Route::get('admin/dsdonhang-chuyenform', 'DondathangController@chuyenformTaoDon');
    Route::post('admin/dsdonhang-add', 'DondathangController@addDonHang');
    Route::get('admin/dsdonhang-add-sanpham/{id}/{size}/{qty}', 'DondathangController@addCart');
    Route::get('admin/dsdonhang-update-sanpham/{id}/{qty}', 'DondathangController@updateCart');
    Route::get('admin/dsdonhang-delete/{id}', 'DondathangController@destroy');
    Route::get('admin/dsdonhang-donhang/{id}', 'DondathangController@getChitietdonhangAdmin');
    Route::get('admin/dsdonhang-duyetdon/{id}', 'DondathangController@duyetDonHang');
    Route::get('admin/dsdonhang-thanhtoan/{id}', 'DondathangController@thanhtoan');
    Route::get('admin/dsdonhang-giaohang/{id}', 'DondathangController@giaohang');
    Route::get('admin/dsdonhang-hoanthanh/{id}', 'DondathangController@hoanthanh');
    Route::get('admin/dsdonhang-delete-cart/{id}', 'DondathangController@deleteCart');
    Route::get('admin/dsdonhang-getsanpham', 'DondathangController@dsSanpham')->name('getSanPhamDH');
    Route::get('admin/dsdonhang-getkhachhang', 'DondathangController@dsKhachhang')->name('getKhachHangDH');
    Route::get('admin/dsdonhang-chon-khachhang/{id}', 'DondathangController@chonKhachhang');
    Route::get('admin/dsdonhang-delete-khachhang/', 'DondathangController@deleteKhachhang');



    Route::get('admin/active/{id}', 'DondathangController@actionDonhang')->name('actionDonhang');

    //khachhang
    Route::get('/admin/dskhachhang', 'QLKhachhangController@getDanhsach')->name('getKhachhang');
    Route::post('/admin/dskhachhang-add', 'QLKhachhangController@add');
    Route::get('/admin/dskhachhang-edit/{id}', 'QLKhachhangController@edit');
    Route::get('/admin/dskhachhang-delete/{id}', 'QLKhachhangController@delete');
    Route::get('/admin/dskhachhang-detail/{id}', 'QLKhachhangController@detail');




    //sanpham
    Route::get('admin/danhsachsanpham', 'SanphamController@getDSSanpham')->name('getSanpham');
    Route::get('admin/danhsachsanpham-delete/{id}', 'SanphamController@destroy');
    Route::get('admin/danhsachsanpham-formadd', 'SanphamController@getformAdd');
    Route::post('admin/danhsachsanpham/add-sp', 'SanphamController@store')->name('create-product');
    Route::post('admin/danhsachsanpham/edit-sp', 'SanphamController@edit')->name('edit-product');
    Route::get('admin/danhsachsanpham-detail/{id}', 'SanphamController@chitietSanphamAdmin');
    Route::get('admin/khohang', 'SanphamController@khohang')->name('khohang');

    //size
    Route::get('admin/add-size/{id}/{size}', 'SizeController@create');
    Route::get('admin/list-size/{id}', 'SizeController@index');
    Route::get('admin/delete-size/{id}', 'SizeController@destroy');

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
    Route::post('admin/dsphieunhap-import', 'PhieunhapController@import');



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



    //banner
    Route::get('admin/dsbanner/', 'BannerController@getBanner')->name('getBanner');
    Route::get('admin/dsbanner-stop/{id}', 'BannerController@stopBanner');
    Route::get('admin/dsbanner-run/{id}', 'BannerController@runBanner');
    Route::post('admin/dsbanner-add/', 'BannerController@addBanner');
    Route::get('admin/dsbanner-delete/{id}', 'BannerController@deleteBanner');


    //thống kê
    Route::get('admin/thongke', 'ThongkeController@thongke');
    Route::get('admin/thongke-locngay/{ngaybd}/{ngaykt}', 'ThongkeController@locngay');
    Route::get('admin/thongke-7ngay', 'ThongkeController@loc7ngay');



    //phieutra
    Route::get('admin/dsphieutra/', 'PhieutraController@getPhieuTra')->name('getPhieutra');
    Route::post('admin/dsphieutra-add/', 'PhieutraController@AddPhieuTra');
    Route::get('admin/dsphieutra-detail/{id}', 'PhieutraController@detailPhieuTra');
    Route::get('admin/dsphieutra-nhanhang/{id}', 'PhieutraController@nhanhang');
    Route::get('admin/dsphieutra-hoantien/{id}', 'PhieutraController@hoantien');
    Route::get('admin/dsphieutra-delete/{id}', 'PhieutraController@deletePhieuTra');
    Route::get('admin/dsphieutra-getdonhang/', 'PhieutraController@getDonhang')->name('getDonhangPT');
    Route::get('admin/dsphieutra-addphieutra/{id}', 'PhieutraController@formAddPhieuTra');
    Route::get('admin/dsphieutra-addsanphamtra/{id}', 'PhieutraController@addSanPhamTra');
    Route::get('admin/dsphieutra-deletesanphamtra/{id}', 'PhieutraController@deleteSanPhamTra');
    Route::get('admin/dsphieutra-minus-sanphamtra/{id}', 'PhieutraController@minusSanPhamTra');
    Route::get('admin/dsphieutra-plus-sanphamtra/{id}', 'PhieutraController@plusSanPhamTra');


    //khuyenmai
    Route::get('admin/dskhuyenmai/', 'KhuyenmaiController@getdsKhuyenMai')->name('getkhuyenmai');
    Route::get('admin/dskhuyenmai-form-tangsp', 'KhuyenmaiController@getformMaGiamGia');
    Route::get('admin/dskhuyenmai-delete/{id}', 'KhuyenmaiController@deleteKhuyenmai');
    Route::get('admin/dskhuyenmai-detail/{id}', 'KhuyenmaiController@detailKhuyenmai');
    Route::get('admin/dskhuyenmai-stop/{id}', 'KhuyenmaiController@stopKhuyenmai');
    Route::get('admin/dskhuyenmai-run/{id}', 'KhuyenmaiController@runKhuyenmai');
    Route::post('admin/dskhuyenmai-add-khuyenmai', 'KhuyenmaiController@addKhuyenmai');
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
Route::get('/chuyen-form-dathang', 'DondathangController@chuyenformDatHang');
Route::get('/form-dathang', 'DondathangController@getformDatHang');
Route::post('/hoantat-dathang', 'DondathangController@getformHoanTat');
Route::get('dathang-thanhcong/{id}', 'DondathangController@formSuccess');
Route::post('/dathang', 'DondathangController@dathang');
Route::post('/check-coupons', 'DondathangController@checkCoupons');
Route::get('/delete-coupons', 'DondathangController@deleteCoupons');


//huydonhang
Route::get('huy-donhang/{id}', 'DondathangController@huyDonHang');
Route::get('chitiet-donhang/{id}', 'DondathangController@chitietDonHang');




//Giohang
Route::post('/them-giohang', 'CartController@themGiohang')->name('Cart.themgiohang');
Route::get('xoa-giohang/{id}', 'CartController@xoaGiohang')->name('Cart.xoagiohang');
Route::get('qty-up/{rowid}', 'CartController@qtyUp');
Route::get('qty-down/{rowid}', 'CartController@qtyDown');
Route::get('/cart', 'CartController@getCart');



Route::get('test/', 'SanphamController@update');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
