
@extends('layout')
@section('title')
NT Store
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
                @php
                $total=0;
                 foreach ($sp->size as $size)
                 {
                     $total+=$size->soluong;
                 }
                 @endphp
                @if ($sp->loaisanpham->slug=='giay'&& $total>0)
                <div class="productinfo text-center">
                        <a href="{{ url('chitiet-sanpham/'.$sp->id)}}" class="link">
                            @foreach ($sp->Hinhanh as $img )
                            @if ($img->avt===1)
                                 <img class="card-img-top" src="{{asset ('storage/'.$img->name) }}" alt="Card image">
                            @endif
                            @endforeach
					    <div class="card-body">
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
                @endif
                @endforeach
        </div>
    </div>


    <div class="container">
    <h2 >SẢN PHẨM BÁN CHẠY</h2>
<hr>
	<div class="row">
        <div class="owl-carousel owl-theme">
	    @foreach($sp_banchay as $sp)
        @php
                $total=0;
                 foreach ($sp->size as $size)
                 {
                     $total+=$size->soluong;
                 }
                 @endphp
        @if ($sp->loaisanpham->slug=='giay'&&$total>0)

	                <div class="productinfo text-center">
                        <a href="{{ url('chitiet-sanpham/'.$sp->id)}}" class="link">
                            @foreach ($sp->Hinhanh as $img )
                            @if ($img->avt===1)
                                 <img class="card-img-top" src="{{asset ('storage/'.$img->name) }}" alt="Card image">
                            @endif
                            @endforeach
						  <div class="card-body">
                            {{-- @php
                            $total=0;
                             foreach ($sp->size as $size)
                             {
                                 $total+=$size->soluong;
                             }
                                 if ($total==0) {
                                     echo '<h5 class="card-title text-danger" >[HẾT HÀNG]</h5>';
                                 }
                             @endphp --}}
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
                @endif
		@endforeach
    </div>
    </div>


    <div id="product_view"></div>

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
    });


    $(function(){
        $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                     }
                });
        let routeRenderProduct ='{{ route('post-product-view') }}';
        checkRenderProduct=false;
        $(document).on('scroll',function(){
            if($(window).scrollTop()>150 && checkRenderProduct==false){

                console.log('LOG')
                checkRenderProduct=true;
                let products=localStorage.getItem('products');
                //products.reverse();
                products=$.parseJSON(products)
                if(products.length>0)
                {
                    $.ajax({
                        url: routeRenderProduct,
                        method:"POST",
                        data: {id : products},
                        success : function(result)
                        {
                            $("#product_view").html('').append(result.data)
                        }
                    });
                }
            }
        })
        
    })
</script>
@endsection




