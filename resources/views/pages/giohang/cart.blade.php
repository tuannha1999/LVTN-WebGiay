<div class="container" >
    <br>
    <h2 >GIỎ HÀNG</h2>
    @if (Cart::count()!=NULL)

        <table class="table" >
            <thead>
                <tr>
                  <th scope="col">Sản phẩm</th>
                  <th scope="col"> </th>
                  <th scope="col">Số lượng</th>
                  <th scope="col"> Tổng tiền</th>
                  <th scope="col">Xóa</th>
                </tr>
              </thead>
              @foreach (Cart::content() as $item)
              <tbody>
                <tr>
                    <td>
                    <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                        <img src="{{asset ('storage/'.$item->options->images) }}" alt="" height="150px" width="150px">
                    </a>
                    </td>
                    <td>
                        <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                            <b>{{$item->name}}</b><br>
                        </a>
                         <span>{{$item->options->size->size}}</span><br>
                         <span>{{ number_format($item->price,0,'.','.').' '.'đ'}}</span>
                    </td>
                    <td>
                        <div class="input-group-prepend">
                            <span></span>
                            <input type="button" class="btn btn-light" id="qtyminus{{$item->rowId}}" data-id="{{$item->rowId}}"
                             value="-" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                            <input type="number"  value="{{$item->qty}}"
                             name="soluong" class="btn btn-light text-center" min="1" max="10" readonly>
                             <input type="button" class="btn btn-light" id="qtyplus{{$item->rowId}}" data-id="{{$item->rowId}}"
                             value="+" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        </div>
                    </td>
                  <td> {{number_format($item->qty*$item->price,0,'.','.').' '.'đ'}}</td>
                  <td>
                    <a id="deletecart" data-id="{{$item->rowId}}" href="javascript:void(0);" data-toggle="tooltip"
                        data-original-title="Delete">
                        <i class="fas fa-trash-alt"></i></a>
                </td>
                </tr>
              </tbody>
              @endforeach
            </table>
            <div class="col-12 text-right">
                <div class="mb-4"><span class="font-weight-bold">
                    Tạm tính: </span> {{Cart::subtotal()}}
                </div>
                    <div class="text-right">
                      <a href="{{URL('/')}}"><button type="button" class="btn btn-secondary">Tiếp tục mua hàng</button></a>
                      <a href="{{URL('/form-dathang')}}" class="btn btn-danger">Thanh toán</a>
                    </div>
            </div>
            <div class="row"> <input hidden id="total-quanty-cart" type="number" value="{{Cart::count()}}"> </div>
    @else
    <div class="row"> <input hidden id="total-quanty-cart" type="number" value="0"> </div>
        <div class="col-12 text-center">
            <img src="//bizweb.dktcdn.net/100/377/398/themes/755909/assets/empty_cart.png?1623752419614" alt="">
            <h2 class="mt-4">Không có sản phẩm nào trong giỏ hàng của bạn</h2>
            <a href="{{URL('/')}}"><button type="button" class="btn btn-secondary">Tiếp tục mua hàng</button></a>
        </div>
    @endif
</div>
</div>
<script>

    //update cart
    @foreach (Cart::content() as $item)
    $("#qtyminus{{$item->rowId}}").on("click",function(){
        var id=$(this).data("id");
            $.ajax({
            url:'/qty-down/'+id,
            type:'GET',
        }).done(function(response){
                $("#list-cart").empty();
                 $("#list-cart").html(response);
                 $("#total-quanty-show").text($("#total-quanty-cart").val());

        });
    });
    $("#qtyplus{{$item->rowId}}").on("click",function(){
        var id=$(this).data("id");
        $.ajax({
            url:'/qty-up/'+id,
            type:'GET',
        }).done(function(response){
            if($.isEmptyObject(response.error)){
                $("#list-cart").empty();
                 $("#list-cart").html(response);
                 $("#total-quanty-show").text($("#total-quanty-cart").val());
                    }
                    else{
                        alertify .alert(response.error, function(){
                            location.reload();
                    });
                    }
             });
    });
    @endforeach
    //xóa giỏ hàng
    $('body').on('click', '#deletecart', function () {
        var id=$(this).data("id");
        $.ajax({
            url:'/xoa-giohang/'+id,
            type:'GET',
        }).done(function(response){
                 $("#list-cart").empty();
                 $("#list-cart").html(response);
                alertify.success('Đã xóa sản phẩm');
        });
    });

</script>

<!--Container-->
