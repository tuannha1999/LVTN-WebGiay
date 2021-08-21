@extends('layout')
@section('noidung')
@section('title')
Đăng nhập
@endsection
<div class="container text-center" >
<hr>
<br>
<h2 class="title ">ĐĂNG NHẬP</h2>
<br>
<div class="col-md-12">
<div class="row"> 
  <div class="col-md-4 "></div>
  <div class="col-md-4 ">
  <form action="{{ url('/dangnhap') }}" method="post">
  {{ csrf_field() }}
  
    @if(Session::has('thongbao'))
    <div class="text-danger">{{Session::get('thongbao')}}   </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success">{{Session::get('success')}}   </div>
    @endif

    
    <div class="form-group">
    <input type="email" class="form-control" id="email" placeholder="Email của bạn" name="email">
        @if($errors->has('email'))
        <div class="text-danger">
        {{$errors->first('email')}}
        </div>
        @endif
    </div>
    <div class="form-group" >
    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password">
        @if($errors->has('password'))
        <div class="text-danger">
        {{$errors->first('password')}}
        </div>
        @endif
    </div>
    
    <button type="submit" class="btn btn-secondary"  >Đăng nhập</button>
   
  
  </form>
    <div>
    <a class="btn btn-link" href="{{ route('form-reset-password') }}" > Quên mật khẩu?</a>
    </div>
    <br>
    <div>
    <a class="btn btn-secondary" href="{{ url('/dangki') }}" >
    Đăng kí thành viên mới</a>
    </div>
    <br>
    <br>
    
   
  </div>
</div>
</div>
</div>
   
<script>
  window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
</script>

@endsection


