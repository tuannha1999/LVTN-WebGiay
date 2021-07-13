
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
        <div class="owl-carousel owl-theme">
	            	@foreach($sp as $sp)
	                <div class="productinfo text-center">
                        <a href="{{ url('chitiet-sanpham/'.$sp->id)}}" class="link">
                            @foreach ($sp->Hinhanh as $img )
                            @if ($img->avt===1)
                                 <img class="card-img-top" src="{{asset ('storage/'.$img->name) }}" alt="Card image">
                            @endif
                            @endforeach
						  <div class="card-body">
                                @php
                               $total=0;
                                foreach ($sp->size as $size)
                                {
                                    $total+=$size->soluong;
                                }
                                    if ($total==0) {
                                        echo '<h5 class="card-title text-danger" >[HẾT HÀNG]</h5>';
                                    }
                                @endphp
						    <h4 class="card-title">{{$sp->tensp}}</h4>
                        </a>
                             @if ($sp->giakm===0)
                                  <p style="color: red;">{{ number_format($sp->giaban,0,'.','.').' '.'đ' }}</p>
                              @else
                                  <p><del>{{ number_format($sp->giaban,0,'.','.').' '.'đ' }}</del></p>
                                 <p style="color: red;">{{ number_format($sp->giakm,0,'.','.').' '.'đ' }}</p>
                              @endif
                    </div>
		    </div>
		            @endforeach
        </div>
    </div>
<h2 >SẢN PHẨM BÁN CHẠY</h2>
<hr>
	<div class="row">
        <div class="owl-carousel owl-theme">
	    @foreach($sp_banchay as $sp)
	                <div class="productinfo text-center">
                        <a href="{{ url('chitiet-sanpham/'.$sp->id)}}" class="link">
                            @foreach ($sp->Hinhanh as $img )
                            @if ($img->avt===1)
                                 <img class="card-img-top" src="{{asset ('storage/'.$img->name) }}" alt="Card image">
                            @endif
                            @endforeach
						  <div class="card-body">
                            @php
                            $total=0;
                             foreach ($sp->size as $size)
                             {
                                 $total+=$size->soluong;
                             }
                                 if ($total==0) {
                                     echo '<h5 class="card-title text-danger" >[HẾT HÀNG]</h5>';
                                 }
                             @endphp
						        <h4 class="card-title">{{$sp->tensp}}</h4>
                              </a>
                              @if ($sp->giakm===0)
                                    <p style="color: red;">{{ number_format($sp->giaban,0,'.','.').' '.'đ' }}</p>
                              @else
                                     <p><del>{{ number_format($sp->giaban,0,'.','.').' '.'đ' }}</del></p>
                                    <p style="color: red;">{{ number_format($sp->giakm,0,'.','.').' '.'đ' }}</p>
                              @endif
                            </div>
					</div>
		@endforeach
    </div>

</div>
</div>
<!--Container-->
<script src="{{ asset ('/js/owl.carousel.min.js') }}" type="text/javascript"></script>

<script>
     $('.owl-carousel').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        responsive:{
            460:{
                items:4
            },
        }
    })
</script>
@endsection




