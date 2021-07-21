
@extends('layout')
@section('noidung')
@section('title')
Sản phẩm yêu thích
@endsection
<!--Container-->
<div class="container mt-4">
    <br>
    <h2 >SẢN PHẨM YÊU THÍCH</h2>
    @if (count($sp_yeuthich->sanpham)==0)
    <div class=" text-center">
        <img src="{{asset ('/img/empty_heart.png') }}" alt="">
        <h2 class="mt-4">Hãy nhấn yêu thích sản phẩm để xem lại thuận tiện nhất.</h2>
        <a href="{{URL('/')}}"><button type="button" class="btn btn-secondary">Tiếp tục xem sản phẩm</button></a>
    </div>
    @else
    <table class="table mt-5"  >
        <thead>
            <tr>
              <th scope="col">Sản phẩm</th>
              <th scope="col"> </th>
              <th scope="col">Số lượng</th>
              <th scope="col">Giá</th>
              <th scope="col"> </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sp_yeuthich->sanpham as $sp )
              <form>
                @csrf
              <tr>
                <td>
                  <a href="{{ url('chitiet-sanpham/'.$sp->id)}}" class="link">
                         <img src="{{asset ('storage/'.$sp->pivot->img) }}" alt="" height="100px" width="100px">
                  </a>
                </td>
                <td>
                    <a href="{{ url('chitiet-sanpham/'.$sp->id)}}" class="link">
                          <b>{{$sp->tensp}}</b><br>
                          <span>{{$sp->pivot->size}}</span>
                          <input hidden type="text" id="size-{{$sp->id}}" value="{{$sp->pivot->size}}">
                    </a>
                </td>
                <td>
                      <div class="input-group-prepend">
                          <span></span>
                          <input type="button" class="btn btn-light"
                           value="-" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                          <input type="number" value="1"
                          id="qty-{{$sp->id}}" class="btn btn-light text-center" min="1" max="10" readonly>
                           <input type="button" class="btn btn-light" value="+" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                      </div>
                </td>
                <td> {{ number_format($sp->giaban,0,'.','.').' '.'đ'}}</td>
                <td>
                    <button class="btn btn-dark btn-submit" data-id="{{$sp->id}}">Thêm vào giỏ hàng</button>&nbsp;
                    <a href="{{URL('delete-yeuthich/'.$sp->id)}}" class="link"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
            </form>
            @endforeach
          </tbody>
        </table>
    @endif
</div>
<!--Container-->
<script>
 $(document).ready(function() {
        $(".btn-submit").click(function(e){
            e.preventDefault();


            var _token = $("input[name='_token']").val();
            var id = $(this).data("id");
            var size =$("#size-"+id).val();
            var qty=$("#qty-"+id).val();
            console.log(size);
            $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                     }
                });
                $.ajax({
                    url:'/them-giohang',
                    type:'POST',
                    data:{_token:_token,id:id,size:size,qty:qty},
                }).done(function(response){
                    if($.isEmptyObject(response.error)){
                        $("#total-quanty-show").empty();
                         $("#total-quanty-show").html(response.data);
                        alertify.success(response.success);
                    }
                    else{
                        alertify .alert(response.error, function(){
                            location.reload();
                    });
                    }
                });
    });
     });

</script>
@endsection
