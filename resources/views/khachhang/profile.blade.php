@extends('layout')
@section('profile')
<div class="container text-center" >
<h2 class="title ">Profile</h2>
<br>
<div class="row "> 
  <div class="col-md-4 "></div>
  <div class="col-md-4 ">
  <form action="{{ url('/#') }}" method="post">
  {{ csrf_field() }}
    <!-- @if(Session::has('thongbao'))
    <div class="text-danger">{{Session::get('thongbao')}} </div>
    @endif -->
    <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email"  name="email">
        <!-- @if($errors->has('email'))
        <div class="text-danger">
        {{$errors->first('email')}}
        </div>
        @endif -->
    </div>
    <div class="form-group" >
    <label for="sdt">Số điện thoại</label>
    <input type="text" class="form-control" id="sdt"  name="sdt">
        <!-- @if($errors->has('password'))
        <div class="text-danger">
        {{$errors->first('password')}}
        </div>
        @endif -->
    </div>
    
    <button type="submit" class="btn btn-secondary"  >Chỉnh sửa</button>
   
  
  </form>
    <!-- <div>
    <a class="btn btn-link" href="#"> Quên mật khẩu?</a>
    </div>
    <br>
    <div>
    <a class="btn btn-secondary" href="{{ url('/dangki') }}" >
    Đăng kí thành viên mới</a>
    </div> -->
    
   
  </div>
</div>
</div>
   


@endsection


