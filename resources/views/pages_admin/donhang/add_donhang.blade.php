@extends('admin.layout_admin')
@section('home')
<div class="container">
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-warning">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-warning mt-3" id="alert-warning">
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
    <div class="mt-2"><a href="{{URL('/admin/dsdonhang')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
        <div class="col-md-12 mb-5">
            <h2 class="card-title text-center font-weight-bold">TẠO ĐƠN HÀNG</h2>

            <label for="basic-url">Mã đơn hàng</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" readonly>
            </div>

                <h4>Chọn sản phẩm</h4>
                        <table class="display" id="list-sanpham" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th> </th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th> </th>
                                </tr>
                            </thead>
                        </table>

                        <h4>Thông tin sản phẩm ({{Cart::count()}} sản phẩm)</h4>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-sp">
                            <table class="table mb-0">
                              <thead class="sticky-top">
                                <tr>
                                  <th scope="col">Mã sản phẩm</th>
                                  <th scope="col"></th>
                                  <th scope="col">Tên sản phẩm</th>
                                  <th scope="col">Giá bán</th>
                                  <th scope="col">Số lượng</th>
                                  <th scope="col"></th>

                                </tr>
                              </thead>
                              <tbody>
                                  @if (Cart::count()!=null)
                                  @foreach (Cart::content() as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td><img style="heigth:50px;width:50px;" src="{{asset('storage/' . $item->options->images) }} " alt="Card image"></td>
                                        <td>{{$item->name.' - '. $item->options->size->size}}</td>
                                        <td>{{number_format($item->price,0,'.','.')}}</td>
                                        <td><input  type="number" min="1" id="qty-update-{{$item->rowId}}" value="{{$item->qty}}" style="width: 70px;height: 30px;"/></td>
                                        <td>
                                               <i onclick="updateCart('{{$item->rowId}}')" class="fas fa-2x fa-save"></i>
                                              <a href="{{URL('/admin/dsdonhang-delete-cart/'.$item->rowId)}}"  class="">
                                              <i class="fas fa-2x fa-trash-alt"></i></a>
                                        </td>
                                      </tr>
                                      @endforeach
                                      @endif
                              </tbody>
                            </table>
                        </div>

            <div class="row mt-3">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    @if (Cart::count()>0)
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="">Tổng tiền:</label>
                        </div>
                        <div class="col-md-6">
                           <label for="" class="h6">{{Cart::subtotal()}}đ</label>
                        </div>
                    </div>
                    @if (Session::has("khachhang"))
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="">Ưu đãi({{Session::get('khachhang')->phantram*100}}%):</label>
                        </div>
                        <div class="col-md-6">
                           <label for="" class="h6">-{{number_format(str_replace(array(','), '', Cart::subtotal())*Session::get('khachhang')->phantram,0,',',',').' '}}đ</label>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="">Tổng phải trả:</label>
                        </div>
                        <div class="col-md-6">
                           <label for="" class="h6">{{number_format(Session::get("tongtien"),0,',',',').' '}}đ</label>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        <form action="{{URL('/admin/dsdonhang-add')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h3>Chọn Khách hàng</h3>
                    <table class="display" id="list-khachhang" style="width:100%">
                        <thead>
                            <tr>
                                <th>Mã khách hàng</th>
                                <th>Họ tên</th>
                                <th>Số điện thoại</th>
                                <th> </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-6 ">
                             <h3>Thông tin mua hàng</h3>
                             @if (Session::has('khachhang'))
                             <div class="text-right">
                                <a href="{{URL('admin/dsdonhang-delete-khachhang/')}}"><i class="fas fa-trash-alt"></a></i>
                              </div>
                              @endif
                             <div class="row">
                                 <div class="col-md-6">
                                     <label for="basic-url">Họ tên*</label>
                                     <div class="input-group mb-3">
                                       <input type="text" class="form-control" id="basic-url" required aria-describedby="basic-addon3" value="@if(Session::has('khachhang')) {{Session::get('khachhang')->name}}@else {{old('hoten')}}@endif" name="hoten">
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <label for="basic-url">Số điện thoại*</label>
                                      <div class="input-group mb-3">
                                         <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="@if(Session::has('khachhang')) {{Session::get('khachhang')->sdt}}@else {{old('sdt')}} @endif" name="sdt">
                                      </div>
                                 </div>
                             </div>

                              <label for="basic-url">Địa chỉ*</label>
                                 <div class="input-group mb-3">
                                   <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="{{old('diachi')}}" name="diachi" >
                                 </div>

                                 <div class="row">

                                     <div class="col-md-6">
                                         <label for="basic-url">Thanh toán</label>
                                         <div class="input-group mb-3">
                                             <select name="ptthanhtoan" id="" class="form-control">
                                                 <option value="0">Thanh toán tiền mặt</option>
                                                 <option value="1">Chuyển khoản ngân hàng</option>
                                             </select>
                                         </div>
                                         <input type="checkbox" name="thanhtoan" value="1" id="thanhtoan" onclick="changethanhtoan();"> Đã thanh toán

                                     </div>

                                     <div class="col-md-6">
                                         <label for="basic-url">Ghi chú</label>
                                         <div class="input-group mb-3">
                                             <textarea name="ghichu" id="" cols="200" rows="3">{{old('ghichu')}}</textarea>
                                         </div>
                                     </div>
                                 </div>
                                 <div id="nhanhang">

                                </div>
                             </div>
                </div>
            </div>

            <div class="mb-3">
                <button class="btn btn-success">Tạo đơn hàng</button>
            </div>
        </div>
    </form>

</div>



<script type="text/javascript">
//SanPham
 $(document).ready( function () {
              $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
                $('#list-sanpham').DataTable({
                   processing: true,
                   serverSide: true,
                   lengthMenu: [3],
                   lengthChange: false,
                   info: false,
                   language: {
                           search: "_INPUT_",
                           searchPlaceholder: "Nhập sản phẩm cần tìm..."
                    },
                    ordering: false,
                   ajax : '{!! route('getSanPhamDH') !!}',
                   columns: [
                    { data: 'id_sp', name: 'id_sp' },
                    { data: 'img', name: 'img' },
                    { data: 'tensp', name: 'tensp',orderable: false },
                    { data: 'giaban', name: 'gianban',orderable: false },
                    { data: 'soluong', name: 'soluong',orderable: false },
                    { data: 'action', name: 'action',orderable: false },
                    ]
               });
               //Khách hàng
               $('#list-khachhang').DataTable({
                   processing: true,
                   serverSide: true,
                   lengthMenu: [2],
                   lengthChange: false,
                   info: false,
                   language: {
                           search: "_INPUT_",
                           searchPlaceholder: "Nhập khách hàng cần tìm..."
                    },
                    ordering: false,
                   ajax : '{!! route('getKhachHangDH') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'sdt', name: 'sdt',orderable: false },
                    { data: 'action', name: 'action',orderable: false },
                    ]
               });


 });

//change thanh toán
function changethanhtoan()
{
  if (document.getElementById('thanhtoan').checked)
  {
    $("#thanhtoan").change(function() {
    $('#nhanhang').html(' <label for="basic-url">Nhận hàng</label><br><input type="checkbox" name="nhanhang" value="1"> Đã nhận hàng')
});
  } else {
    $("#thanhtoan").change(function() {
    $('#nhanhang').html('')
})  }
}



function updateCart(id) {
        //console.log($('#qty-update-'+id).val());
        $.ajax({
            type: 'GET',
            url: '/admin/dsdonhang-update-sanpham/'+id+'/'+$('#qty-update-'+id).val(),
            success: function(data){
                location.reload();
            }
        });
}

function addCart(id,size) {
    var strid=String(id)+String(size);
        console.log(strid);
        $.ajax({
            type: 'GET',
            url: '/admin/dsdonhang-add-sanpham/'+id+'/'+size+'/'+$('#qty-'+strid).val(),
            success: function(data){
                if($.isEmptyObject(data.error)){
                    location.reload();
                    }
                    else{
                        alertify .alert(data.error, function(){
                            location.reload();
                    });
                    }
            }
        });
}


  //alert thông báo
  window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);
    </script>
@endsection
