
@extends('layout')
@section('title')
{{$chitiet_sp->tensp}}
@endsection
@section('noidung')
<!--Container-->
<hr class="my-4">
<div class="container" id="change-item-cart">
	<div class="row">
    <div class="col-6">
        <img class="card-img-top" height="520px" width="420px"
        src="{{asset ('/img/sanpham/'.$chitiet_sp->hinhanh) }}" alt="Card image">
    </div>
    <div class="col-6">
        <h2>{{$chitiet_sp->tensp}}</h2>
        ________
        <h3 class="text-danger">{{ number_format($chitiet_sp->giaban,0,'.','.').' '.'đ' }}</h3>
        <div class="cate">Trạng thái:
        @if ($chitiet_sp->trangthai==1)
            <span>Còn hàng</span>
        @else
               <span class="text-danger">Hết hàng</span>
        @endif</div>
        <hr>
        <div class="cate select-swap">Size:
            @foreach($size as $value)
            @if ($value->soluong==0)
                <input type="radio" value="{{$value->size}}" >{{$value->size}}
            @else
            <button  class="btn btn-outline"><input type="radio" value="{{$value->size}}">{{$value->size}}</button>
            @endif
            @endforeach
        </div>
        <div class="mt-3" id="total-quanty-cart">
            Số lượng:
            <div class="input-group-prepend">
                    <span class="btn btn-light" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</span>
                    <input type="number" value="1" id="quanty-item" name="soluong" class="btn btn-light text-center" min="1" max="10" readonly>
                     <span class="btn btn-light"onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</span>
            </div>
        </div>
        <div class="mt-3">
            <a onclick="addCart({{$chitiet_sp->masp}})" href="javascript:">
                <button type="button" class="btn btn-dark"> Thêm vào giỏ hàng</button>
            </a>
        </div>
    </div>
    </div>
    <div class="mt-5">
        <hr>
        <h2 class="text-center ">Sản phẩm liên quan</h2>
    </div>

</div>
<!--Container-->
@endsection




