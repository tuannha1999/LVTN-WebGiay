
    <h2 >SẢN PHẨM VỪA XEM</h2>
<hr>
<div class="row">

<div class="owl-carousel owl-theme" id="vuaxem">
                    @foreach($products as $value)
                        <div class="productinfo text-center">
                            <a href="{{ url('chitiet-sanpham/'.$value->id)}}"  class="link">
                                @foreach ($value->Hinhanh as $img )
                                @if ($img->avt==1)
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
                                    @if ($value->giakm==0)
                                    <p style="color: red;">{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</p>
                                    @else
                                    <p><del>{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</del></p>
                                    <p style="color: red;">{{ number_format($value->giakm,0,'.','.').' '.'đ' }}</p>
                                    @endif
                            </a>
                        </div>
                        </div>

                    @endforeach
</div>

    <script src="{{ asset ('/js/owl.carousel.min.js') }}" type="text/javascript"></script>

    <script>
     $('#vuaxem').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        responsive:{
            460:{
                items:4
            },
        }
    });
    </script>

