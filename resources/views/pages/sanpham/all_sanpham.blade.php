@extends('layout')
@section('noidung')
<!--Container-->
<hr class="my-4">
<div class="container">
    <div class="row">
            <div class="col-3">
                @include('pages.sanpham.sidebar_left')
            </div>
            <div class="col-9">
                <div class="row">
                    @foreach($all_sp as $key=>$value)
                    <div class="col-md-4 col-sm-6">
                        <div class="productinfo text-center">
                            <a href="{{ url('chitiet-sanpham/'.$value->masp)}}"  class="link">
                                <img class="card-img-top" src="{{asset ('/img/sanpham/'.$value->hinhanh) }}" alt="Card image">
                                <div class="card-body">
                                    <h4 class="card-title">{{$value->tensp}}</h4>
                                    <p style="color: red;">{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</p>
                            </a>
                        </div>
                    </div>
                 </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
<!--Container-->
@endsection
