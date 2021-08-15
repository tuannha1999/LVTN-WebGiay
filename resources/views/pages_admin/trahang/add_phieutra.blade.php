@extends('admin.layout_admin')
@section('home')
<div class="container">

    <div class="mt-2"><a href="{{URL('/admin/dsphieutra')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-warning mt-3" id="alert-success">
        <span>{{Session::get('error')}}</span>
    </div>
    @endif
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-md-12">
        <h2 class="card-title text-center font-weight-bold">TẠO PHIẾU TRẢ HÀNG</h2>
        <div class="row mt-4">

            <div class="col-md-8">
                <table class="table">
                    <h4 class="font-weight-bold">Thông tin khách hàng</h4>
                 <tr>
                     <td>Tên khách hàng:</td>
                     <td>{{$donhang->hoten}}</td>
                 </tr>
                 <tr>
                     <td>Địa chỉ:</td>
                     <td>{{$donhang->diachi}}</td>
                 </tr>
                 <tr>
                     <td>Số điện thoại:</td>
                     <td>{{$donhang->sdt}}</td>
                 </tr>
             </table>
            </div>

    </div>

    <div class="col-md-12">
        <div class="mt-4">
            <h4 class="font-weight-bold">Chọn sản phẩm trả hàng</h4>
            <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-size">
                    <table class="table mb-0">
                      <thead class="sticky-top">
                        <tr>
                          <th scope="col">Mã sản phẩm</th>
                          <th scope="col"></th>
                          <th scope="col">Tên sản phẩm</th>
                          <th scope="col">Số lượng</th>
                          <th scope="col"></th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach (Session::get('Phieutra')->products as $key=>$sp)
                          <tr>
                            <td>{{$sp['productinfo']->id}}</td>
                            <td><img style="heigth:50px;width:50px;" src="{{ asset('storage/' . $sp['img']) }}" alt="Card image"></td>
                            <td>{{$sp['productinfo']->tensp .' - '. $sp['size'] }}</td>
                            <td>
                                <input type="button" class="btn btn-light" id="qtyminus{{$key}}" data-id="{{$key}}"
                                value="-" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                               <input type="number"  value="{{$sp['quanty']}}"
                                name="soluong" class="btn btn-light text-center" min="1" max="10" readonly>
                                <input type="button" class="btn btn-light" id="qtyplus{{$key}}" data-id="{{$key}}"
                                value="+" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">

                                {{-- <input type="number"id="qty" min="1" style="width: 60px;height: 30px;" value="{{$sp['quanty']}}"> --}}
                            </td>
                            <td>
                                <a href="{{URL('/admin/dsphieutra-deletesanphamtra/'.$key)}}" class=""><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                          @endforeach
                      </tbody>
                    </table>
            </div>
            <div>

                <Span class="">Số lượng:</Span>&nbsp;&nbsp;<Span>{{Session::get("Phieutra")->QuantyPhieutra}}</Span><br>
                <Span class="font-weight-bold">Tổng tiền:</Span>&nbsp;&nbsp;<Span>{{number_format(Session::get("Phieutra")->totalPhieutra,0,'.','.').' '}}</Span>
            </div>
        </div>
    </div>
    <form action="{{URL('/admin/dsphieutra-add')}}" method="POST">
        @csrf
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="row mt-3">
                <div class="col-md-6">
                    <Span class="font-weight-bold">Hoàn tiền</Span><br><br>
                    <input type="checkbox" name="hoantien" @if(old('hoantien')==1) checked @endif value="1"> Đã hoàn tiền
                </div>
                <div class="col-md-6">
                    <Span class="font-weight-bold">Nhận lại hàng</Span><br><br>
                    <input type="checkbox" name="nhanhang" @if(old('nhanhang')==1) checked @endif value="1"> Đã nhận lại hàng
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="row">
                <div class="col-md-6">
                    <Span class="font-weight-bold">Ghi chú:</Span><br><br>
                    <textarea name="ghichu" id="" cols="20" rows="3">{{old('ghichu')}}</textarea>
                </div>
                <div class="col-md-6 ">
                    <Span class="font-weight-bold">Lý do trả:</Span><br><br>
                    <input type="radio" name="lydo" value="0" > Sản phẩm lỗi, sản phẩm bảo hành...<br>
                    <input type="radio" name="lydo" value="1" > Lý do khác
                </div>
            </div>

        </div>
    </div>
    <div class="mb-5">
        <input type="text" hidden name="id_dh" value="{{$donhang->id}}">
        <button type="submit" class="btn btn-success">Tạo phiếu trả</button>
    </div>
</form>
</div>

</div>
<script>

@foreach (Session::get('Phieutra')->products as $key=>$sp)
    $("#qtyminus{{$key}}").on("click",function(){
        var id=$(this).data("id");
       console.log(id);
            $.ajax({
            url:'/admin/dsphieutra-minus-sanphamtra/'+id,
            type:'GET',
        }).done(function(response){
            if($.isEmptyObject(response.error)){
                location.reload();
            }else{
                alertify.error(response.error);
            }
        });
    });
    // $("#qtyplus{{$key}}").on("click",function(){
    //     var id=$(this).data("id");
    //    console.log(id);
    //         $.ajax({
    //         url:'/admin/dsphieutra-plus-sanphamtra/'+id,
    //         type:'GET',
    //     }).done(function(response){
    //         if($.isEmptyObject(response.error)){
    //             location.reload();
    //         }else{
    //             alertify.error(response.error);
    //         }
    //     });
    // });
@endforeach

//alert thông báo
window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);
</script>
@endsection
