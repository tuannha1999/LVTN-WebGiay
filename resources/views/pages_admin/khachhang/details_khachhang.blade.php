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
                    <td>{{number_format($khachhang->tonggd,0,'.','.')}}</td>
                </tr>
                <tr>
                    <td>Ưu đãi cho mỗi đơn hàng:</td>
                    <td>
                       {{$khachhang->phantram*100}}%
                    </td>
                </tr>
             </table>
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
                            <td>{{$dh->ngaydat}}</td>

                            <td>
                                @if ($dh->trangthai==0)
                                <span class="text-warning">CHỜ XỬ LÝ</span>
                            @elseif ($dh->trangthai==1)
                                <span class="text-info">CHỜ GIAO HÀNG</span>
                            @elseif ($dh->trangthai==2)
                                <span class="text-primary">ĐANG GIAO HÀNG</span>
                            @elseif ($dh->trangthai==3)
                                <span class="text-success">HOÀN THÀNH</span>
                            @else
                                <span class="text-danger">ĐÃ HỦY</span>
                            @endif
                            </td>
                            <td>
                                <a href="{{URL('/admin/dsdonhang-donhang/' . $dh->id)}}" class="btn btn-outline-primary">Chi tiết </a>
                            </td>
                        </tr>
                          @endforeach
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>

</div>
<script>



</script>
@endsection
