
@extends('layout')
@section('noidung')
@section('title')
Giỏ hàng
@endsection
<!--Container-->
<div class="container" id="delete-cart" >
    <br>
    <h2 >GIỎ HÀNG</h2>
    @if (Session::has('Cart')!=null)
    <form action="" method="">
        <table class="table" >
            <thead>
                <tr>
                  <th scope="col">Sản phẩm</th>
                  <th scope="col">Giá</th>
                  <th scope="col">Số lượng</th>
                  <th scope="col">Tổng tiền</th>
                  <th scope="col">Xóa</th>
                </tr>
              </thead>
              @foreach (Session::get('Cart')->products as $item )
              <tbody>
                <tr>
                  <td>
                    <a href="{{ url('chitiet-sanpham/'.$item['productInfo']->masp)}}" class="link">
                        <img src="{{asset ('/img/sanpham/'.$item['productInfo']->hinhanh) }}" alt="" height="150px" width="150px">
                        &nbsp;&nbsp;{{$item['productInfo']->tensp}}</td>
                    </a>
                    <td>{{ number_format($item['productInfo']->giaban,0,'.','.').' '.'đ'}}</td>
                    <td>
                        <div class="input-group-prepend">
                        <span class="btn btn-light" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</span>
                            <input type="number" data-id="{{$item['productInfo']->masp }}"  id="quanty-item" value="{{$item['quanty']}}"
                             name="soluong" class="btn btn-light text-center" min="1" max="10" readonly>
                             <span class="btn btn-light"onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</span>
                        </div>
                    </td>
                  <td>{{number_format($item['quanty']*$item['productInfo']->giaban,0,'.','.').' '.'đ'}}</td>
                  <td><a onclick="deleteCart({{$item['productInfo']->masp}})" href="javascript:">X</a></td>
                </tr>
              </tbody>
              @endforeach
            </table>
            <div class="col-12 text-right">
                <div class="mb-4"><span class="font-weight-bold">Tạm tính: </span> {{number_format(Session::get('Cart')->totalPrice,0,'.','.').' '.'đ'}}</div>
                    <div class="text-right">
                      <a href="{{URL('/')}}"><button type="button" class="btn btn-secondary">Tiếp tục mua hàng</button></a>
                      <button type="button" class="btn btn-info update">Cập nhật giỏ hàng</button>
                      <button type="submit" class="btn btn-danger">Thanh toán</button>
                    </div>
            </div>
    </form>
    @else
    <div class="col-12 text-center">
        <img src="//bizweb.dktcdn.net/100/377/398/themes/755909/assets/empty_cart.png?1623752419614" alt="">
        <h2 class="mt-4">Không có sản phẩm nào trong giỏ hàng của bạn</h2>
        <a href="{{URL('/')}}"><button type="button" class="btn btn-secondary">Tiếp tục mua hàng</button></a>
    </div>
    @endif

</div>
<!--Container-->
<script>
    function deleteCart(id)
    {
        $.ajaxSetup({
            headers:{
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            url:'xoa-giohang/'+id,
            type:'GET',
        }).done(function(response){
            //$("#delete-cart").empty(),
            //$('#delete-cart').html(response),
        location.reload(),
        alertify.success('Đã xóa thành công');
        });
    }
    $(".update").on("click",function(){
        var list=[];
        $("table tbody tr td").each(function(){
            $(this).find("input").each(function(){
                var element={key:$(this).data("id"),value:$(this).val()};
                list.push(element);
            });
        });
        console.log(list);
        $.ajaxSetup({
            headers:{
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            url:'suaAll-giohang',
            type:'POST',
            data:{
                "_token":"{{csrf_token()}}",
                "data":list
            }
        }).done(function(response){
        location.reload();
            //$("#delete-cart").empty(),
            //$('#delete-cart').html(response),
        });
    });
</script>
@endsection
