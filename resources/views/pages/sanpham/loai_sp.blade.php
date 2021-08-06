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
                          @foreach($loai->sanpham as $value)
                          @if ($value->trangthai==1)
                          <div class="col-md-4 col-sm-6">
                            <div class="productinfo text-center">
                                <a href="{{ url('chitiet-sanpham/'.$value->id)}}"  class="link">
                                    @foreach ($value->Hinhanh as $img )
                                    @if ($img->avt===1)
                                         <img class="card-img-top" src="{{asset ('storage/'.$img->name) }}" alt="Card image">
                                     @endif
                                    @endforeach
                                    <div class="card-body">
                                        @php
                                        $total=0;
                                         foreach ($value->size as $size)
                                         {
                                             $total+=$size->soluong;
                                         }
                                             if ($total==0) {
                                                 echo '<h5 class="card-title text-danger" >[HẾT HÀNG]</h5>';
                                             }
                                         @endphp
                                        <h4 class="card-title">{{$value->tensp}}</h4>
                                         @if ($value->giakm===0)
                                             <p style="color: red;">{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</p>
                                         @else
                                             <p><del>{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</del></p>
                                            <p style="color: red;">{{ number_format($value->giakm,0,'.','.').' '.'đ' }}</p>
                                         @endif
                                </a>
                            </div>
                            </div>
                        </div>
                          @endif
                          @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
<!--Container-->
@endsection
