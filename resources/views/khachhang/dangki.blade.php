@extends('layout')
@section('dangki')
<div class="container text-center" >
<br>
<h2 class="title ">ĐĂNG KÍ THÀNH VIÊN MỚI</h2>
<br>
  <div class="row "> 
  <div class="col-md-4 "></div>
  <div class="col-md-4 ">

  <form action="{{ url('/dangki') }}" method="post">
  {{ csrf_field() }}

<!--     @if(count($errors)>0)
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
            {{$err}}
            @endforeach
        </div>
    @endif -->
    
    @if(Session::has('thanhcong'))
        <div class="alert alert-success">{{Session::get('thanhcong')}} </div>
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
    <a class="btn btn-link" href="{{ url('/dangnhap') }}">
    Quay lại</a>
    
    
  </form>

  </div>
  <div class="col-md-4 "></div>
  </div>

</div>
@endsection


