@extends('layout')
@section('noidung')
@section('title')
Đăng kí
@endsection
<div class="container text-center" >
<hr>

<br>
<h2 class="title ">ĐĂNG KÍ THÀNH VIÊN MỚI</h2>
<br>
  <div class="row "> 
  <div class="col-md-4 "></div>
  <div class="col-md-4 ">

  <form action="{{ url('/dangki') }}" method="post">
  {{ csrf_field() }}
    
    @if(Session::has('thongbao'))
        <div class="alert alert-success">{{Session::get('thongbao')}} </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger">{{Session::get('error')}} </div>
    @endif

    <div class="form-group">
        <input type="text" class="form-control" id="name" placeholder="Họ và tên*" name="name">
        @if($errors->has('name'))
        <div class="text-danger">
        {{$errors->first('name')}}
        </div>
        @endif
    </div>
    
    <div class="form-group">
        <input type="email" class="form-control" id="email" placeholder="Email*" name="email">
        @if($errors->has('email'))
        <div class="text-danger">
        {{$errors->first('email')}}
        </div>
        @endif
    </div>
    
    <div class="form-group">
        <input type="text" class="form-control" id="sdt" placeholder="Số điện thoại*" name="sdt">
        @if($errors->has('sdt'))
        <div class="text-danger">
        {{$errors->first('sdt')}}
        </div>
        @endif
    </div>
    
    <div class="form-group" >
      <input type="password" class="form-control" id="password" placeholder="Mật khẩu*" name="password">
      @if($errors->has('password'))
      <div class="text-danger">
      {{$errors->first('password')}}
      </div>
      @endif
    </div>
    
    
    <button type="submit" class="btn btn-secondary " >Đăng kí</button>
    <br>
    <br>
    
    <br>
        <a href="#" onClick="history.go(-1);" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay lại</span></a>
    
    
  </form>
  
  </div>
  </div>

</div>

@endsection


