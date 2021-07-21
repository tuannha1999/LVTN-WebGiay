
@extends('layout')
@section('title')
Tìm kiếm đơn hàng
@endsection

@section('noidung')

<!--Container-->
<hr class="my-4">
<div class="container">
<h2>TÌM KIẾM ĐƠN HÀNG</h2>
<hr>
<div class="row mt-5 ">

    <div class="col-md-4">

    </div>
    <div class="col-md-4">
        <form action="{{URL('/search-donhang')}}" method="get">
            <div class="form-group">
              <span class="font-weight-bold">Nhập mã đơn hàng hoặc số điện thoại</span>
              <input type="text" name="search" class="form-control mt-2" id="exampleInputEmail1"  placeholder="">
            </div>
            <button type="submit" class="btn btn-info">Kiểm tra</button>
          </form>
    </div>
    <div class="col-md-4">

    </div>
</div>

@if (count($search)>0)
<div class="row mt-4">
    <div> <h5>Tìm thấy {{ $count = count($search) }} đơn hàng</h5> </div>
    <table class="table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Ngày đặt hàng</th>
                <th>Tình trạng</th>
                <th>Tổng tiền</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($search as $dh )
            <tr>
                <td>{{$dh->id}}</td>
                <td>{{$dh->hoten}}</td>
                <td>{{$dh->sdt}}</td>
                <td>{{$dh->created_at->toDateTimeString()}}</td>
                <td>
                    @if ($dh->trangthai==0)
                        <span class="text-warning">Chờ duyệt</span>
                    @elseif ($dh->trangthai==1)
                        <span class="text-warning">Chờ giao hàng</span>
                    @elseif ($dh->trangthai==2)
                        <span class="text-info">Đang giao hàng</span>
                    @elseif ($dh->trangthai==3)
                         <span class="text-success">Hoàn thành</span>
                    @elseif ($dh->trangthai==4)
                        <span class="text-warning">Đã hủy</span>
                    @endif
                </td>
                <td>{{ number_format($dh->tongtien,0,'.','.').' '.'đ' }}</td>
                <td>
                    <a href="{{URL('chitiet-donhang/'.$dh->id)}}" class="btn btn-outline-info"> Xem chi tiết</a>
                    @if ($dh->trangthai==0 || $dh->trangthai==1)
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModalCenter">
                        Hủy đơn hàng</button>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    {{-- //modal --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Chọn lý do hủy hàng</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form action="{{URL('huy-donhang/'.$dh->id)}}" method="get">
                <div class="modal-body">
                    <input type="radio" name="lydo" value="Muốn thay đổi sản phẩm trong đơn hàng"> Muốn thay đổi sản phẩm trong đơn hàng <br>
                    <input type="radio" name="lydo" value="Tìm thấy giá rẻ hơn ở nơi khác"> Tìm thấy giá rẻ hơn ở nơi khác <br>
                    <input type="radio" name="lydo" value="Đổi ý không muốn mua nữa"> Đổi ý không muốn mua nữa <br>
                    <input type="radio" name="lydo" value="Lý do khác"> Lý do khác
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-info">Hủy đơn hàng</button>
                  </div>
                </form>

          </div>
        </div>
      </div>
</div>
@endforeach
@else
<h4>Không tìm thấy đơn hàng!</h4>
@endif
</div>

<!--Container-->

@endsection




