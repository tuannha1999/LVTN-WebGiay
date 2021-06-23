@extends('layout')
@section('noidung')
<hr class="my-4">
<div class="container">
    <div> <h3>Tìm thấy {{ $count = count($search) }} Kết quả</h3> </div>
    <hr>
	<div class="row">
	            	@foreach($search as $key=>$value)
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
</div>
</div>
@endsection
