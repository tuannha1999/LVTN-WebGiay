
@extends('layout')
@section('noidung')
@section('title')
Đặt hàng
@endsection

<div class="container">
    <h3 class="mt-4">HOÀN TẤT ĐẶT HÀNG</h3>
    <form id="form-hoantat-dathang" action="{{URL('/dathang')}}" method="post" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6 mt-3">
            <h3>Thông tin mua hàng</h3>
            <div class="row">
                <table class="table mb-0 border">
                    <tr>
                          <td>Họ tên</td>
                          <td>
                              {{Session::get('hoten')}}
                              <input type="hidden" name="hoten" value="{{Session::get('hoten')}}">
                          </td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td>
                            {{Session::get('sdt')}}
                            <input type="hidden" name="sdt" value="{{Session::get('sdt')}}">

                        </td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>
                            {{Session::get('diachi')}}
                            <input type="hidden" name="diachi" value="{{Session::get('diachi')}}">

                        </td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td>@if (Session::get('thanhtoan')==0)
                                <span>Thanh toán khi nhận hàng</span>
                                <input type="hidden" name="thanhtoan" value="{{Session::get('thanhtoan')}}">
                            @else
                                <span>Chuyển khoản ngân hàng</span>
                                <input type="hidden" name="thanhtoan" value="{{Session::get('thanhtoan')}}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ghi chú</td>
                        <td>
                            {{Session::get('ghichu')}}
                            <input type="hidden" name="ghichu" value="{{Session::get('ghichu')}}">
                        </td>
                    </tr>
                  </table>
            </div>
        </div>
        <div class="col-md-6 mt-5">
            <h4>Đơn hàng ({{Cart::count()}} sản phẩm)</h4>
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0">
                  <tbody>
                      @foreach (Cart::content() as $item)
                    <tr>
                        <td>
                            <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                                <img src="{{asset ('storage/'.$item->options->images) }}" alt="" height="100px" width="100px">
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('chitiet-sanpham/'.$item->id)}}" class="link">
                                <b>{{$item->name}}</b><br>
                            </a>
                             <span>{{$item->options->size->size}}</span><br>
                             <span>{{number_format($item->price,0,'.','.').''.'đ'}} x {{$item->qty}}</span><br>
                        </td>
                        <td> {{number_format($item->qty*$item->price,0,'.','.').''.'đ'}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-9">
                    <label for="">Tổng tiền</label>
                </div>
                <div class="col-md-3">
                   <label for="">{{Cart::subtotal()}}đ</label>
                </div>
            </div>
            @if (Auth::check())
            <div class="row">
                <div class="col-md-9">
                    <label for="">Ưu đãi thành viên:</label>
                </div>
                <div class="col-md-3">
                    <label for="">- {{number_format(session()->get('tiengiamtv'),0,',',',')}}đ</label>
                </div>
            </div>
            @endif


            @if(session()->has('daapdung'))
            <div class="row">
                <div class="col-md-9">
                    <label for="" class="">Mã giảm giá ({{session()->get('macode')}}):</label>
                </div>
                <div class="col-md-3">
                   <label for="" class="h6">- {{number_format(session()->get('tiengiamma'),0,',',',')}}đ</label>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-9">
                    <label for="" class="font-weight-bold">Tổng tiền phải thanh toán:</label>
                </div>
                <div class="col-md-3">
                   <label for="" class="text-danger h5">{{number_format(session()->get('tongtien'),0,',',',')}}đ</label>
                </div>
            </div>
        </div>
            <div class="row mt-5">
                <div class="col-md-9">
                    <a href="{{URL('/form-dathang')}}" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay lại</span></a>
                </div>
                <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Hoàn tất</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
//dat hang
    // $(document).ready(function() {
    //     $("#form-hoantat-dathang").submit(function(e){
    //         e.preventDefault();

    //         var form = $(this);

    //         $.ajaxSetup({
    //                 headers: {
    //                     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    //                  }
    //             });

    //                 $.ajax({
    //                 url:'/dathang',
    //                 type:'post',
    //                 data:form.serialize(),
    //             }).done(function(response){
    //                     window.location.replace("dathang-thanhcong/"+response)
    //             });
    //     });
    // });
</script>

@endsection
