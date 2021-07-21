
@extends('layout')
@section('noidung')
@section('title')
Chi tiết đơn hàng
@endsection

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
                        <td> @if ($donhang->trangthai==0)
                            <span class="text-warning">Chờ duyệt</span>
                        @elseif ($donhang->trangthai==1)
                            <span class="text-warning">Chờ giao hàng</span>
                        @elseif ($donhang->trangthai==2)
                            <span class="text-info">Đang giao hàng</span>
                        @elseif ($donhang->trangthai==3)
                             <span class="text-success">Hoàn thành</span>
                        @elseif ($donhang->trangthai==4)
                            <span class="text-warning">Đã hủy</span>
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
                {{-- <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Hoàn tất</button>
                </div> --}}
            </div>
        </div>
    </div>
    </form>
</div>


@endsection
