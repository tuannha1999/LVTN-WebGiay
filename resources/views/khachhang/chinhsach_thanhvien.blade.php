
@extends('layout')
@section('noidung')
@section('title')
Chính sách thành viên
@endsection
<hr>
<div class="container mt-4">
    <h3 class=" text-center">CHÍNH SÁCH THÀNH VIÊN</h3>
    <div class="mt-4">
        <p class="font-weight-bold h5">Điều kiện để trở thành thành viên</p>
        <p class="font-weight-normal">
            - Mua hàng tại cửa hàng và có nhu cầu đăng kí thành viên <br>
             - Đăng kí thành viên tại website
        </p>
        <p class="font-weight-bold h5">Chính sách tích điểm và giảm giá cho thành viên</p>
        <p class="font-weight-normal">
            Tổng số tiền cộng dồn các hóa đơn đã mua (Online hoặc tại cửa hàng).
        </p>
        <table class="table">
            <tr>
                <td class="font-weight-bold">Tổng hóa đơn cộng dồn</td>
                <td class="font-weight-bold">Giảm giá lần mua tiếp theo</td>
            </tr>
            <tr>
                <td>Từ 2.000.000đ - 3.999.000đ</td>
                <td>5%</td>
            </tr>
            <tr>
                <td>Từ 4.000.000đ - 5.999.000đ</td>
                <td>6%</td>
            </tr>
            <tr>
                <td>Từ 6.000.000đ - 7.999.000đ</td>
                <td>7%</td>
            </tr>
            <tr>
                <td>Từ 8.000.000đ - 9.999.000đ</td>
                <td>8%</td>
            </tr>
            <tr>
                <td>Từ 10.000.000đ - 11.999.000đ</td>
                <td>9%</td>
            </tr>
            <tr>
                <td>Trên 12.000.000đ</td>
                <td>10%</td>
            </tr>
        </table>
        <hr>
        <p class="font-weight-bold h5">Lưu ý</p>
        <p class="font-weight-normal">
            - Khi thanh toán tại cửa hàng chỉ cần đọc số điện thoại đã đăng kí để tích điểm và hưởng ưu đãi <br>
            - Khi mua hàng tại website cần đăng nhập khi thanh toán để tích điểm và nhận ưu đãi.
        </p>
    </div>
    <div class="col-md-8">
        <a href="#" onClick="history.go(-1);" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay lại</span></a>
    </div>
</div>
@endsection
