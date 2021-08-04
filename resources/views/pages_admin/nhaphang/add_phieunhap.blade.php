@extends('admin.layout_admin')
@section('home')
<div class="container">
    @if (Session::has('error'))
    <div class="alert alert-warning mt-3" id="alert-warning">
        <span>{{Session::get('error')}}</span>
    </div>
    @endif
    <div class="mt-2"><a href="{{URL('/admin/dsphieunhap')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
        <div class="col-md-12 mb-5">
            <h2 class="card-title text-center font-weight-bold">TẠO PHIẾU NHẬP</h2>
            <form action="{{URL('/admin/dsphieunhap-add')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="basic-url">Mã phiếu nhập</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" readonly>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <h4>Chọn nhà cung cấp</h4>
                        <div class="text-right">
                            <a class="btn btn-outline-success mb-2" href="{{URL('/admin/dsnhacungcap')}}">add</a>
                        </div>
                        <div class="">
                            <table class="display" id="list-ncc" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Mã nhà cung cấp</th>
                                        <th>Tên nhà cung cấp</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                        </table>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        @if (Session::has("Cart")!=null)
                        @foreach (Session::get("Cart")->supplier as $item)
                        <table class="table">
                            <tr>
                                <td class="text-right"><a href="{{URL('admin/dsphieunhap-deletencc/'.$item['supplierinfo']->id)}}"><i class="fas fa-trash-alt"></a></i></td>
                            </tr>
                            <tr>
                                <td>Tên nhà cung cấp:</td>
                                <td>{{$item['supplierinfo']->tenncc}}</td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:</td>
                                <td>{{$item['supplierinfo']->diachi}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{$item['supplierinfo']->email}}</td>
                            </tr>
                            <tr>
                                <td>Số điện thoại:</td>
                                <td>{{$item['supplierinfo']->sdt}}</td>
                            </tr>
                        </table>
                        @endforeach
                        @endif
                    </div>

                </div>

                <h4>Chọn sản phẩm nhập hàng</h4>



                <div class="text-right">
                    {{-- <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModalCenter">
                        Nhập nhiều sản phẩm</button> --}}
                    <a class="btn btn-outline-success mb-2" href="{{URL('admin/danhsachsanpham-formadd')}}">add</a>
                </div>
                <div class="">
                    <table class="display" id="list-pro" style="width:100%">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th> </th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá nhập</th>
                                <th> </th>
                            </tr>
                        </thead>
                </table>
                </div>

                <h4>Thông tin sản phẩm</h4>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-sp">
                        <table class="table mb-0">
                          <thead class="sticky-top">
                            <tr>
                              <th scope="col">Mã sản phẩm</th>
                              <th scope="col">Tên sản phẩm</th>
                              <th scope="col">Số lượng</th>
                              <th scope="col">Giá nhập</th>
                              <th scope="col"></th>

                            </tr>
                          </thead>
                          <tbody>
                              @if (Session::has("Cart")!=null)
                              @foreach (Session::get("Cart")->products as $item)
                                <tr>
                                    <td>{{$item['productinfo']->id}}</td>
                                    <td>{{$item['productinfo']->tensp .' - '. $item['size']}}</td>
                                    <td><input  type="number" min="1" id="qty-update-{{$item['productinfo']->id.$item['id_size']}}" value="{{$item['quanty']}}" style="width: 70px;height: 30px;"/></td>
                                    <td><input  type="number" id="price-update-{{$item['productinfo']->id.$item['id_size']}}" min="1" value="{{$item['entryprice']}}" style="width: 100px;height: 30px;"/></td>
                                    <td>
                                           <i onclick="updateCart('{{$item['productinfo']->id.$item['id_size']}}')" class="fas fa-2x fa-save"></i>
                                          <a href="{{URL('admin/dsphieunhap-deletesanpham/'.$item['productinfo']->id.$item['id_size'])}}"  class="">
                                          <i class="fas fa-2x fa-trash-alt"></i></a>
                                    </td>
                                  </tr>
                                  @endforeach
                                  @endif
                          </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <Span class="font-weight-bold">Thanh toán</Span><br><br>
                                    <input type="checkbox" name="thanhtoan" @if(old('thanhtoan')==1) checked @endif value="1"> Đã thanh toán
                                </div>
                                <div class="col-md-6">
                                    <Span class="font-weight-bold">Nhập kho</Span><br><br>
                                    <input type="checkbox" name="nhapkho" @if(old('nhapkho')==1) checked @endif value="1"> Nhập kho
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if (Session::has("Cart")!=null)
                            <Span class="">Số lượng:</Span>&nbsp;&nbsp;<Span>{{Session::get("Cart")->totalQuanty}}</Span><br>
                            <Span class="font-weight-bold">Tổng tiền:</Span>&nbsp;&nbsp;<Span>{{number_format(Session::get("Cart")->totalPrice,0,'.','.').' '}}</Span>
                            @endif
                        </div>
                    </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <Span class="font-weight-bold">Ngày nhập hàng</Span><br>
                        <div class="input-group mb-3">
                            <input class="form-control @error('ngaynhap') is-invalid @enderror" type="date" value="{{old('ngaynhap')}}" name="ngaynhap">
                            @error('ngaynhap')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                             @enderror
                           </div>
                    </div>
                    <div class="col-md-6">
                        <Span class="font-weight-bold">Ghi chú</Span><br>
                        <textarea name="ghichu" id="" cols="50" rows="3">{{old('ghichu')}}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Tạo phiếu nhập</button>
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
                $('#list-pro').DataTable({
                   processing: true,
                   serverSide: true,
                   lengthMenu: [5],
                   lengthChange: false,
                   info: false,
                   language: {
                           search: "_INPUT_",
                           searchPlaceholder: "Nhập sản phẩm cần tìm..."
                    },
                    ordering: false,
                   ajax : '{!! route('getdsSanPham') !!}',
                   columns: [
                    { data: 'id_sp', name: 'id_sp' },
                    { data: 'img', name: 'img' },
                    { data: 'tensp', name: 'tensp',orderable: false },
                    { data: 'soluong', name: 'soluong',orderable: false },
                    { data: 'gianhap', name: 'gianhap',orderable: false },
                    { data: 'action', name: 'action',orderable: false },
                    ]
               });
    //Nhacungcap
    $('#list-ncc').DataTable({
                   processing: true,
                   serverSide: true,
                   lengthMenu: [2],
                   info: false,
                   lengthChange: false,
                   language: {
                           search: "_INPUT_",
                           searchPlaceholder: "Tìm nhà cung cấp..."
                    },
                    ordering: false,
                    ajax : '{!! route('getdsNhaCungCap') !!}',
                    columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tenncc', name: 'tenncc' },
                    { data: 'action', name: 'action',orderable: false },
                    ]
               });
 });

    function updateCart(id) {
        //console.log($('#qty-update-'+id).val());
        $.ajax({
            type: 'GET',
            url: '/admin/dsphieunhap-updatesanpham/'+id+'/'+$('#qty-update-'+id).val()+'/'+$('#price-update-'+id).val(),
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
            url: '/admin/dsphieunhap-addsanpham/'+id+'/'+size+'/'+$('#qty-'+strid).val()+'/'+$('#price-'+strid).val(),
            success: function(data){
                location.reload();
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
