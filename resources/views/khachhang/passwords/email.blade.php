@extends('layout')
@section('noidung')
@section('title')
Quên mật khẩu
@endsection

<div class="container" >
<hr>
<br>
<h2 class="title text-center ">ĐĂNG NHẬP</h2>
<br>
<div class="col-md-12">
<div class="row">
    <div class="col-md-3"></div> 
    <div class="col-md-6">
    <form action="{{ url('/quen-mat-khau') }}" method="post">
    {{ csrf_field() }}
    @if(Session::has('success'))
    <div class="alert alert-success">{{Session::get('success')}} </div>
    @endif
    @if(Session::has('hethan'))
    <div class="alert alert-danger">{{Session::get('hethan')}} </div>
    @endif
    <br>
    <h4>Quên mật khẩu:</h4>
    <br>
    <div class="form-group">
        <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn..."  name="email">
        @if(Session::has('error'))
        <div class="text-danger">{{Session::get('error')}} </div>
        @endif
    </div>
    <button type="submit" class="btn btn-info" style="margin-left: 10px;" >Gửi</button>
    <br>
    </form>
    <br>
    <br>
    <br>
        <a href="#" onClick="history.go(-1);" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay lại</span></a>
   
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