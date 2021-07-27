@extends('admin.layout_admin')
@section('home')
<div class="container mb-5">

    <div class="mt-2"><a href="{{URL('/admin/dsphieutra')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    <div class="col-md-12">
        <h2 class="card-title text-center font-weight-bold">CHI TIẾT PHIẾU TRẢ</h2>
        <div class="row mt-4">

            <div class="col-md-6">
                <table class="table">
                    <h4 class="font-weight-bold">Thông tin phiếu trả</h4>
                 <tr>
                     <td>Mã phiếu trả:</td>
                     <td>{{$phieutra->id}}</td>
                 </tr>
                 <tr>
                    <td>Khách hàng:</td>
                    <td>{{$phieutra->dondathang->hoten}}</td>
                </tr>
                <tr>
                    <td>Số điện thoại:</td>
                    <td>{{$phieutra->dondathang->sdt}}</td>
                </tr>
                 <tr>
                     <td>Ngày trả hàng:</td>
                     <td>{{$phieutra->created_at}}</td>
                 </tr>
                 <tr>
                    <td>Lý do trả:</td>
                    <td>
                        @if ($phieutra->lydo==0)
                            <span > Sản phẩm lỗi, sản phẩm bảo hành...</span>
                        @else
                            <span >Lý do khác.</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Người tạo:</td>
                    <td>{{$phieutra->user->name}}</td>
                </tr>
                <tr>
                    <td>Ghi chú:</td>
                    <td>{{$phieutra->chichu}}</td>
                </tr>
             </table>
        </div>

        <div class="col-md-6">
            <h4 class="font-weight-bold">Trạng thái phiếu trả</h4>
                    <table class="table">
                        <tr>
                            <td>Trạng thái:</td>
                            <td>
                                @if ($phieutra->trangthai==0)
                                   <span class="text-warning">Đang giao dịch</span>
                               @else
                                    <span class="text-success">Hoàn thành</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Hoàn tiền:</td>
                            <td>
                               @if ($phieutra->hoantien==0)
                               <span class="text-warning">Chưa hoàn tiền</span>
                               @else
                                <span class="text-success">Đã hoàn tiền</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                           <td>Nhận lại hàng:</td>
                           <td>
                               @if ($phieutra->nhanhang==0)
                                   <span class="text-warning">Chưa nhận</span>
                               @else
                                    <span class="text-success">Đã nhận</span>
                                @endif
                           </td>
                       </tr>

                    </table>
        </div>
    </div>
    </div>

    <div class="mt-4">
        <h4 class="font-weight-bold">Thông tin sản phẩm</h4>
        <div class="table-wrapper-scroll-y my-custom-scrollbar" >
                <table class="table mb-0">
                  <thead class="sticky-top">
                    <tr>
                      <th scope="col">Mã sản phẩm</th>
                      <th scope="col">Tên sản phẩm</th>
                      <th scope="col">Số lượng</th>

                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($phieutra->sanpham as $sp)
                        <tr>
                            <td>{{$sp->id}}</td>
                            <td>{{$sp->tensp.' - '.$sp->pivot->size}}</td>
                            <td>{{$sp->pivot->soluong}}</td>
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
                    @if ($phieutra->hoantien==0)
                    <a href=""  data-id="{{$phieutra->id}}" class="btn btn-info btn-hoantien">Đã hoàn tiền</a>
                    @endif

                </div>
                <div class="col-md-9">
                    @if ($phieutra->nhanhang==0)
                    <a href="" data-id="{{$phieutra->id}}" class="btn btn-info btn-nhanhang">Đã nhận lại hàng</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <span>Tổng tiền: {{number_format($phieutra->tongtien,0,'.','.')}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

  //hoantien
  $('.btn-hoantien').on('click',function(){
               // console.log(product_id);
               if(confirm("Bạn có chắc phiếu trả đã hoàn tiền?")){
                $.ajax({
                        url:'/admin/dsphieutra-hoantien/'+$(this).data("id"),
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

//nhanhang
  $('.btn-nhanhang').on('click',function(){
               // console.log(product_id);
               if(confirm("Bạn có chắc muốn xác nhận đã nhận lại hàng?")){
                $.ajax({
                        url:'/admin/dsphieutra-nhanhang/'+$(this).data("id"),
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
