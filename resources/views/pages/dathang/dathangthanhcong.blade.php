@extends('layout')
@section('noidung')
<!--Container-->
<hr class="my-4">
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <span style="color: green" ><i class="fas fa-10x fa-check"></i></span><br>
            <h2 style="color: green" >CẢM ƠN BẠN ĐÃ MUA HÀNG!</h2>
            <div class="mt-4">
                <h4 class="mb-4">Bạn đã đặt hàng thành công</h4>
                <p>Mã đơn hàng: <span class="text-info"> <a href="{{URL('chitiet-donhang/'.$donhang->id)}}">{{$donhang->id}}</a></span></p>
                <a href="{{URL('/')}}"><button type="button" class="btn btn-secondary">Tiếp tục mua hàng</button></a>
            </div>
        </div>
    </div>
</div>
<!--Container-->
@endsection
