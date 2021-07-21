@extends('admin.layout_admin')
@section('home')
<div class="container">

    <div class="mt-2"><a href="{{URL('/admin/dskhachhang')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    <div class="col-md-12">
        <h2 class="card-title text-center font-weight-bold">CHI TIẾT KHÁCH HÀNG </h2>
        <div class="row mt-4">

            <div class="col-md-8">
                <table class="table">
                    <h4 class="font-weight-bold">Thông tin khách hàng </h4>
                 <tr>
                     <td>Tên khách hàng :</td>
                     <td>{{$khachhang->name}}</td>
                 </tr>
                 <tr>
                     <td>Email:</td>
                     <td>{{$khachhang->email}}</td>
                 </tr>
                 <tr>
                     <td>Số điện thoại:</td>
                     <td>{{$khachhang->sdt}}</td>
                 </tr>
                 <tr>
                    <td>Tổng giao dịch:</td>
                    <td>{{$khachhang->tonggd}}</td>
                </tr>
             </table>
            </div>

    </div>

    <div class="col-md-12">

        <div class="mt-4">
            <h4 class="font-weight-bold">Lịch sử mua hàng</h4>
            <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-size">
                    <table class="table mb-0">
                      <thead class="sticky-top">
                        <tr>
                          <th scope="col">Mã đơn hàng</th>
                          <th scope="col">Ngày mua hàng</th>
                          <th scope="col">Trạng thái</th>
                          <th scope="col"></th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($khachhang->dondathang as $dh)
                          <tr>
                            <td>{{$dh->id}}</td>
                            <td>{{$dh->created_at->toDateString()}}</td>

                            <td>
                                @if ($dh->trangthai==2)
                                    <span class="text-success">Hoàn thành</span>
                                @elseif ($dh->trangthai==1)
                                <span class="text-success">Chờ giao hàng</span>
                                @else
                                <span class="text-warning">Chờ duyệt</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{URL('/admin/dsphieunhap-detail/' . $dh->id)}}" class="btn btn-outline-primary">Chi tiết </a>
                            </td>
                        </tr>
                          @endforeach
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>

    {{-- <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    @if ($phieunhap->nhapkho==0)
                    <a href=""  data-id="{{$phieunhap->id}}" class="btn btn-outline-info btn-nhapkho">Nhập kho</a>
                    @endif

                </div>
                <div class="col-md-9">
                    @if ($phieunhap->thanhtoan==0)
                    <a href="" data-id="{{$phieunhap->id}}" class="btn btn-outline-info btn-thanhtoan">Thanh toán</a>
                    @endif

                </div>
            </div>
        </div>
    </div> --}}
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
