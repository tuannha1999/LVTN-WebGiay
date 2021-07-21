@extends('admin.layout_admin')
@section('home')
<div class="container mb-5">

    <div class="mt-2"><a href="{{URL('/admin/dsphieunhap')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    <div class="col-md-12">
        <h2 class="card-title text-center font-weight-bold">CHI TIẾT PHIẾU NHẬP</h2>
        <div class="row mt-4">

            <div class="col-md-6">
                <table class="table">
                    <h4 class="font-weight-bold">Thông tin phiếu nhập</h4>
                 <tr>
                     <td>Mã phiếu nhập:</td>
                     <td>{{$phieunhap->id}}</td>
                 </tr>
                 <tr>
                     <td>Ngày nhập hàng:</td>
                     <td>{{$phieunhap->ngaynhap}}</td>
                 </tr>
                 <tr>
                     <td>Trạng thái:</td>
                     <td>
                         @if ($phieunhap->trangthai==0)
                            <span class="text-warning">Đang giao dịch</span>
                        @else
                             <span class="text-success">Hoàn thành</span>
                         @endif
                     </td>
                 </tr>
                 <tr>
                     <td>Thanh toán:</td>
                     <td>
                        @if ($phieunhap->thanhtoan==0)
                        <span class="text-warning">Chưa thanh toán</span>
                        @else
                         <span class="text-success">Đã thanh toán</span>
                         @endif
                     </td>
                 </tr>
                 <tr>
                    <td>Nhập kho:</td>
                    <td>
                        @if ($phieunhap->nhapkho==0)
                            <span class="text-warning">Chưa nhập kho</span>
                        @else
                             <span class="text-success">Đã nhập kho</span>
                         @endif
                    </td>
                </tr>
                <tr>
                    <td>Người tạo:</td>
                    <td>{{$phieunhap->user->name}}</td>
                </tr>
                <tr>
                    <td>Ghi chú:</td>
                    <td>{{$phieunhap->chichu}}</td>
                </tr>
             </table>
        </div>

        <div class="col-md-6">
                <table class="table">
                    <h4 class="font-weight-bold">Thông tin nhà cung cấp</h4>
                 <tr>
                     <td>Tên nhà cung cấp:</td>
                     <td>{{$phieunhap->nhacungcap->tenncc}}</td>
                 </tr>
                 <tr>
                     <td>Địa chỉ:</td>
                     <td>{{$phieunhap->nhacungcap->diachi}}</td>
                 </tr>
                 <tr>
                     <td>Email:</td>
                     <td>{{$phieunhap->nhacungcap->email}}</td>
                 </tr>
                 <tr>
                     <td>Số điện thoại:</td>
                     <td>{{$phieunhap->nhacungcap->sdt}}</td>
                 </tr>
             </table>
        </div>


    </div>
    </div>

    <div class="mt-4">
        <h4 class="font-weight-bold">Thông tin sản phẩm</h4>
        <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-size">
                <table class="table mb-0">
                  <thead class="sticky-top">
                    <tr>
                      <th scope="col">Mã sản phẩm</th>
                      <th scope="col">Tên sản phẩm</th>
                      <th scope="col">Số lượng</th>
                      <th scope="col">Giá nhập</th>

                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($phieunhap->sanpham as $sp)
                        <tr>
                            <td>{{$sp->id}}</td>
                            <td>{{$sp->tensp.' - '.$sp->pivot->size}}</td>
                            <td>{{$sp->pivot->soluong}}</td>
                            <td>{{$sp->pivot->gianhap}}</td>
                       </tr>
                      @endforeach
                  </tbody>
                </table>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    @if ($phieunhap->nhapkho==0)
                    <a href=""  data-id="{{$phieunhap->id}}" class="btn btn-info btn-nhapkho">Nhập kho</a>
                    @endif

                </div>
                <div class="col-md-9">
                    @if ($phieunhap->thanhtoan==0)
                    <a href="" data-id="{{$phieunhap->id}}" class="btn btn-info btn-thanhtoan">Thanh toán</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <span>Tổng tiền: {{number_format($phieunhap->tongtien,0,'.','.')}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

  //nhapkho
  $('.btn-nhapkho').on('click',function(){
               // console.log(product_id);
               if(confirm("Bạn có chắc muốn nhập kho?")){
                $.ajax({
                        url:'/admin/dsphieunhap-nhapkho/'+$(this).data("id"),
                        type:'GET',
                        success: function (data) {
                            location.reload();
                   },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                 })
               }
             });

//thanhtoan
  $('.btn-thanhtoan').on('click',function(){
               // console.log(product_id);
               if(confirm("Bạn có chắc muốn xác nhận đã thanh toán?")){
                $.ajax({
                        url:'/admin/dsphieunhap-thanhtoan/'+$(this).data("id"),
                        type:'GET',
                        success: function (data) {
                            location.reload();
                   },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                 })
               }
             })


</script>
@endsection
