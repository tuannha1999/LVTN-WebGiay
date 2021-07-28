@extends('admin.layout_admin')
@section('home')
<div class="container">

    <div class="mt-2"><a href="#"  onClick="history.go(-2);"><i class="fas fa-2x fa-chevron-left"></i></a></div>
    @if (Session::has('success'))
    <div class="alert alert-success mt-4" id="alert-success">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    <div class="col-md-12">
        <h2 class="card-title text-center font-weight-bold">CHI TIẾT ĐƠN HÀNG </h2>
        
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
                        <td>Ghi chú</td>
                        <td>
                            {{$donhang->ghichu}}
                        </td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td>@if ($donhang->ptthanhtoan==0)
                                <span><b>Thanh toán khi nhận hàng</b></span>
                            @else
                                <span><b>Chuyển khoản ngân hàng</b></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                    <td>Trạng thái:</td>

                    @if ($donhang->ptthanhtoan==0)
                                
                        @if($donhang->trangthai==0)
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-warning">Chờ xử lý</a> </td>
                        @elseif($donhang->trangthai==2)   
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-primary" >Đang giao hàng</a> </td>
                        @elseif($donhang->trangthai==3)   
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-success" >Hoàn thành</a> </td>
                        @elseif($donhang->trangthai==4)   
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-danger" >Hủy đơn hàng</a> </td>  
                        @endif
                                         
                    @else
                    
                        @if($donhang->trangthai==0)
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-warning">Chờ xử lý</a> </td>
                        @elseif($donhang->trangthai==1)   
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-info" >Đã thanh toán</a> </td>
                        @elseif($donhang->trangthai==2)   
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-primary" >Đang giao hàng</a> </td>
                        @elseif($donhang->trangthai==3)   
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-success" >Hoàn thành</a> </td>  
                        @elseif($donhang->trangthai==4)   
                            <td> <a href="{{ route('actionDonhang',$donhang->id )}}" class="btn btn-danger" >Hủy đơn hàng</a> </td>  
                        @endif
                                                         
                        
                    @endif

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

        </div>
    </div>

    

    
</div>
<script>

//alert thông báo
window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);
</script>
@endsection
