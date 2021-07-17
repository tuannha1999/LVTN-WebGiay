
@extends('layout')
@section('noidung')
@section('title')
Đặt hàng
@endsection

<div class="container">
    <h3 class="mt-4">ĐẶT HÀNG</h3>
    <form action="{{URL('/hoantat-dathang')}}" method="POST">
        {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6 mt-3">
            <h3>Thông tin mua hàng</h3>
            <div class="row">

                <div class="col-md-6">
                    <label for="basic-url">Họ tên*</label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control @error('hoten') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="" name="hoten">
                      @error('hoten')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="basic-url">Số điện thoại*</label>
                     <div class="input-group mb-3">
                        <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="" name="sdt">
                        @error('sdt')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                          @enderror
                     </div>
                </div>
            </div>

            <label for="basic-url">Địa chỉ*</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('diachi') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" name="diachi" >
                  @error('diachi')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                    @enderror
                </div>

                {{-- <label for="basic-url">Tỉnh thành</label>
                <select class="form-control @error('lsp') is-invalid @enderror" id="list-prov" name="prov">
                    <option value="">- Chọn tỉnh thành-</option>
                    @foreach ($provinces as $item)
                     <option value="{{$item->id}}" >{{$item->name}}</option>
                     @endforeach
                     @error('lsp')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                </select>

                <label for="basic-url">Quận huyện</label>
                <select class="form-control " id="list-dist" name="dist">
                    <option value="">- Chọn quận huyện-</option>
                     <option value="0" ></option>
                     @error('lsp')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                </select>

                <label for="basic-url">Phường xã</label>
                <select class="form-control" id="list-ward" name="ward">
                    <option value="">- Chọn phường xã-</option>
                     <option value="0" ></option>

                </select> --}}

                <label for="basic-url">Ghi chú</label>
                <div class="input-group mb-3">
                    <textarea name="ghichu" id="" cols="200" rows="3"></textarea>
                </div>

        </div>
        <div class="col-md-6 mt-5">
            <h4>Đơn hàng ({{Cart::count()}} sản phẩm)</h4>
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0">
                  <tbody>
                      @foreach (Cart::content() as $item)
                    <tr>
                        <td>
                            <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                                <img src="{{asset ('storage/'.$item->options->images) }}" alt="" height="100px" width="100px">
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                                <b>{{$item->name}}</b><br>
                            </a>
                             <span>{{$item->options->size->size}}</span><br>
                             <span>{{number_format($item->price,0,'.','.').''.'đ'}} x {{$item->qty}}</span><br>
                        </td>
                        <td> {{number_format($item->qty*$item->price,0,'.','.').''.'đ'}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-9">
                    <label for="">Tạm tính</label>
                </div>
                <div class="col-md-3">
                   <label for="">{{Cart::subtotal()}}đ</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <label for="">Phí vận chuyển:</label>
                </div>
                <div class="col-md-3">
                    <label for="">Miễn phí</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <label for="" class="font-weight-bold">Tổng cộng:</label>
                </div>
                <div class="col-md-3">
                   <label for="" class="text-info h5">{{Cart::subtotal()}}đ</label>
                </div>
            </div>


            <hr>
            <div class="input-group">
                 <label for=""> <input type="radio" name="thanhtoan" value="0" checked >  Thanh toán khi nhận hàng </label>
            </div>
            <div class="input-group">
                <label for=""> <input type="radio" value="1" name="thanhtoan" >  Thanh toán chuyển khoản ngân hàng </label>
           </div>

            <div class="input-group">
                    <p class="font-italic"> (Thực hiện thanh toán vào tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng mã đơn hàng của bạn
                        trong phần nội dung thanh toán. Đơn hàng sẽ được giao sau khi tiền đã được chuyển.)
                    </p>
            </div>

            <div class="row mt-5">
                <div class="col-md-9">
                    <a href="{{URL('/cart')}}" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay về giỏ hàng</span></a>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Đặt hàng</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

{{-- <script >
$(document).ready(function(){

$("#list-prov").change(function(){

      var id_prov= $(this).val();
      console.log(id_prov);
      if(id_prov != '0')
      {
         $.ajax({
            type: 'GET',
            url: '/change-province/'+id_prov,
            success: function(data){
              var len=data.length;
              $("#list-dist").empty();
              for( var i = 0; i<len; i++){
              var id = data[i]['id'];
              var name = data[i]['name'];
              $("#list-dist").append("<option value='"+id+"'>"+name+"</option>");
          }
            }
         });
      }

});
});

$(document).ready(function(){
$("#list-dist").change(function(){

      var id_dist= $(this).val();
      console.log(id_dist);
      if(id_dist != '0')
      {
         $.ajax({
            type: 'GET',
            url: '/change-district/'+id_dist,
            success: function(data){
              var len=data.length;
              $("#list-ward").empty();
              for( var i = 0; i<len; i++){
              var id = data[i]['id'];
              var name = data[i]['name'];
              $("#list-ward").append("<option value='"+id+"'>"+name+"</option>");
          }
            }
         });
      }
});

});
</script> --}}
@endsection
