
@extends('layout')
@section('noidung')
@section('title')
Chi tiết đơn hàng
@endsection
<hr>

<div class="container">
    <h3 class="mt-4">CHI TIẾT ĐƠN HÀNG</h3>
    <div class="row">
        <div class="col-md-6 mt-3">
            <h3>Thông tin mua hàng</h3>
            <div class="row">
                <table class="table mb-0 border">
                    <tr>
                        <td>Mã đơn hàng</td>
                        <td>
                            {{$donhang->id}}

                        </td>
                  </tr>
                    <tr>
                          <td>Họ tên</td>
                          <td>
                              {{$donhang->hoten}}
                          </td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td>
                            {{$donhang->sdt}}

                        </td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>
                            {{$donhang->diachi}}

                        </td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td>@if ($donhang->ptthanhtoan==0)
                                <span>Thanh toán khi nhận hàng</span>
                            @else
                                <span>Chuyển khoản ngân hàng</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>  @if ($donhang->trangthai==0)
                                    <span class="text-warning">CHỜ XỬ LÝ</span>
                                @elseif ($donhang->trangthai==1)
                                    <span class="text-info">CHỜ GIAO HÀNG</span>
                                @elseif ($donhang->trangthai==2)
                                    <span class="text-primary">ĐANG GIAO HÀNG</span>
                                @elseif ($donhang->trangthai==3)
                                    <span class="text-success">HOÀN THÀNH</span>
                                @else
                                    <span class="text-danger">ĐÃ HỦY</span>
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ghi chú</td>
                        <td>
                            {{$donhang->ghichu}}
                        </td>
                    </tr>
                  </table>
            </div>
        </div>
        <div class="col-md-6 mt-5">
            <h4>Đơn hàng ({{count($donhang->sanpham)}} sản phẩm)</h4>
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0">
                  <tbody>
                      @foreach ($donhang->sanpham as $item)
                    <tr>
                        <td>
                            <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                                <img src="{{asset ('storage/'.$item->pivot->img) }}" alt="" height="100px" width="100px">
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                                <b>{{$item->tensp}}</b><br>
                            </a>
                             <span>{{$item->pivot->size}}</span><br>
                             <span>{{number_format($item->giaban,0,'.','.').''.'đ'}} x {{$item->pivot->soluong}}</span><br>
                        </td>
                        <td> {{number_format($item->pivot->soluong*$item->giaban,0,'.','.').''.'đ'}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>

            <hr>
            <div class="row mt-5">
                <div class="col-md-9">
                    <label for="" class="font-weight-bold">Tổng tiền</label>
                </div>
                <div class="col-md-3">
                   <label for="" class="h5 text-info">{{number_format($donhang->tongtien,0,'.','.')}}đ</label>
                </div>
            </div>



            <div class="row mt-5">
                <div class="col-md-8">
                    <a href="#" onClick="history.go(-1);" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay lại</span></a>
                </div>
                <div class="col-md-3">
                    @if ($donhang->trangthai==0 || $donhang->trangthai==1)
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModalCenter">
                        Hủy đơn hàng</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

{{-- //modal huy don hang --}}
<div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Chọn lý do hủy hàng</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <form action="{{URL('huy-donhang/'.$donhang->id)}}" method="get">
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

@endsection
