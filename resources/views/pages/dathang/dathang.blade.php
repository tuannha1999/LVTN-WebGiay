
@extends('layout')
@section('noidung')
@section('title')
Đặt hàng
@endsection

<div class="container">

    <h3 class="mt-4">ĐẶT HÀNG</h3>
    @if (Auth::check()==null)
    <span><a href="{{URL('dangnhap')}}">Đăng nhập</a> để nhận được ưu đãi thành viên cho đơn hàng <a href="{{URL('/chinh-sach-thanh-vien')}}">xem chi tiết</a></span><br>
    <span> Bạn chưa có tài khoản?<a href="{{URL('dangki')}}">Đăng ký ngay</a></span>
    @endif
    <form action="{{URL('/hoantat-dathang')}}" method="POST">
        {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6 mt-3">
            <h3>Thông tin mua hàng</h3>
            <div class="row">

                <div class="col-md-6">
                    <label for="basic-url">Họ tên*</label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control @error('hoten') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3"
                      value="@if(Auth::check()&&Auth::user()->is_admin==0){{Auth::user()->name}} @else{{old('hoten')}}@endif" name="hoten">
                        @error('hoten')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="basic-url">Số điện thoại*</label>
                     <div class="input-group mb-3">
                        <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3"
                         value="@if(Auth::check()&&Auth::user()->is_admin==0){{Auth::user()->sdt}} @else{{old('sdt')}}@endif" name="sdt">
                        @error('sdt')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                </div>
            </div>

            <label for="basic-url">Địa chỉ*</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('diachi') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="{{old('diachi')}}" name="diachi" >
                  @error('diachi')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                    @enderror
                </div>

                <label for="basic-url">Ghi chú</label>
                <div class="input-group mb-3">
                    <textarea name="ghichu" id="" cols="200" rows="3">{{old('ghichu')}}</textarea>
                </div>

                <hr>
                <div class="input-group">
                     <label for=""> <input type="radio" name="thanhtoan" value="0" checked >  Thanh toán khi nhận hàng </label>
                </div>
                <div class="input-group">
                    <label for=""> <input type="radio" value="1" name="thanhtoan" >  Thanh toán chuyển khoản ngân hàng </label>
               </div>

                <div class="input-group">
                        <p class="font-italic"> (Thực hiện thanh toán vào <a href="{{url('hinh-thuc-thanh-toan' )}}" target="_blank">tài khoản ngân hàng </a> của chúng tôi. Vui lòng sử dụng mã đơn hàng của bạn
                            trong phần nội dung thanh toán. Đơn hàng sẽ được giao sau khi tiền đã được chuyển.)
                        </p>
                </div>

                <div class="row mt-5">
                    <div class="col-md-9">
                        <a href="{{URL('/cart')}}" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay về giỏ hàng</span></a>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Đặt hàng</button>
                    </div>
                </div>
            </form>

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
            @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-warning mt-3">
                {{ session('error') }}
            </div>
            @endif
            <div class="row">
                <div class="col-md-9">
                    <label for="">Tạm tính</label>
                </div>
                <div class="col-md-3">
                   <label for="">{{Cart::subtotal()}}đ</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <label for="">Phí vận chuyển:</label>
                </div>
                <div class="col-md-3">
                    <label for="">Miễn phí</label>
                </div>
            </div>
            @if (Auth::check())
            <div class="row">
                <div class="col-md-9">
                    <label for="" class="">Ưu đãi thành viên:</label>
                </div>
                <div class="col-md-3">
                   <label for="" class="h6">- {{number_format(session()->get('tiengiamtv'),0,',',',')}}đ</label>&nbsp;
                                                    @if (Auth::check())
                                                        <span>({{Auth::user()->phantram*100}}%)</span>
                                                    @endif
                </div>
            </div>
            @endif

            @if(session()->has('daapdung'))
            <div class="row">
                <div class="col-md-9">
                    <label for="" class="">Mã giảm giá ({{session()->get('macode')}}):<a href="{{URL('/delete-coupons')}}" class="link"> <i class="fas fa-trash-alt"></i></a></label>
                </div>
                <div class="col-md-3">
                   <label for="" class="h6">- {{number_format(session()->get('tiengiamma'),0,',',',')}}đ</label>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-9">
                    <label for="" class="font-weight-bold">Tổng cộng:</label>
                </div>
                <div class="col-md-3">
                   <label for="" class="text-danger h5">{{number_format(session()->get('tongtien'),0,',',',')}}đ</label>
                </div>
            </div>
            <hr>
            @if (session()->has('daapdung')==false)
            <form action="{{URL('/check-coupons')}}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="macode" aria-describedby="basic-addon3" placeholder="Nhập mã giảm giá">
                      <div class="input-group-prepend">
                          <button type="submit" class="btn btn-info">Áp dụng</button>
                      </div>
                  </div>
            </form>
            @endif
        </div>
    </div>
</div>

<script >
//tắt thông báo sau 3s
window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
 window.setTimeout(function() {
    $(".alert-warning").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
    </script>
@endsection
