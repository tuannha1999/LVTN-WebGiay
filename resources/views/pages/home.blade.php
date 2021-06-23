
@extends('layout')
@section('title')
NT store
@endsection

@section('noidung')
<!--barner-->
@include('barner')
<!--barner-->

<!--Container-->
<hr class="my-4">
<div class="container">
<h2>SẢN PHẨM MỚI</h2>
<hr>
	<div class="row">
	            	@foreach($sp as $key=>$value)
	            	<div class="col-md-3 col-sm-6">
	                <div class="productinfo text-center">
                        <a href="{{ url('chitiet-sanpham/'.$value->masp)}}" class="link">
						  <img class="card-img-top" src="{{asset ('/img/sanpham/'.$value->hinhanh) }}" alt="Card image">
						  <div class="card-body">
						    <h4 class="card-title">{{$value->tensp}}</h4>
                          </a>
                          <p class="text-danger">{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</p>
						</div>
					</div>

		</div>
		@endforeach
        <div class="col-md-12 text-center">
            <a href="#"><button type="button" class="btn btn-outline-secondary">Xem tất cả |  <i class="fas fa-arrow-right"></i></button></a>
        </div>
    </div>
<h2 >SẢN PHẨM BÁN CHẠY</h2>
<hr>
	<div class="row">
	            	@foreach($sp_banchay as $key=>$value)
	            	<div class="col-md-3 col-sm-6">
	                <div class="productinfo text-center">
                        <a href="{{ url('chitiet-sanpham/'.$value->masp)}}" class="link">
						  <img class="card-img-top" src="{{asset ('/img/sanpham/'.$value->hinhanh) }}" alt="Card image">
						  <div class="card-body">
						    <h4 class="card-title">{{$value->tensp}}</h4>
                          </a>
                          <p class="text-danger">{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</p>
						</div>
					</div>

		</div>
		@endforeach
        <div class="col-md-12 text-center">
            <a href="#"><button type="button" class="btn btn-outline-secondary">Xem tất cả |  <i class="fas fa-arrow-right"></i></button></a>
        </div>
</div>
</div>
<!--Container-->
@endsection




