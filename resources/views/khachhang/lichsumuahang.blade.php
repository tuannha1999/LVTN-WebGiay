@extends('layout')
@section('noidung')
@section('title')
Lịch sử mua hàng
@endsection
<hr>
<div class="container mt-4">
<h3>Lịch sử mua hàng</h3>
<hr>
@if (count($donhang)>0)
    <table class="table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Ngày đặt hàng</th>
                <th>Tình trạng</th>
                <th>Tổng tiền</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donhang as $dh )
            <tr>
                <td>{{$dh->id}}</td>
                <td>{{$dh->hoten}}</td>
                <td>{{$dh->created_at->toDateTimeString()}}</td>
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
                <td>{{ number_format($dh->tongtien,0,'.','.').' '.'đ' }}</td>
                <td>
                    <a href="{{URL('chitiet-donhang/'.$dh->id)}}" class="btn btn-outline-info"> Xem chi tiết</a>
                    @if ($dh->trangthai==0 || $dh->trangthai==1)
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModalCenter">
                        Hủy đơn hàng</button>
                    @endif
                </td>
            </tr>

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
                            <button type="submit" class="btn btn-info btn-huy">Hủy đơn hàng</button>
                          </div>
                        </form>

                  </div>
                </div>
              </div>
            @endforeach
        </tbody>
    </table>

    {{-- //modal --}}
@else
<h4>Không có đơn hàng nào!</h4>
@endif
</div>
@endsection
