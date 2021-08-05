
@extends('layout')
@section('title')
Tìm kiếm đơn hàng
@endsection

@section('noidung')
<hr>
<!--Container-->
<div class="container mt-5">
<h2>TÌM KIẾM ĐƠN HÀNG</h2>
<hr>
	<div class="row mt-5">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <form action="{{URL('/search-donhang')}}" method="get">
                <div class="form-group">
                  <span class="font-weight-bold">Nhập mã đơn hàng hoặc số điện thoại</span>
                  <input type="text" name="search" class="form-control mt-2" id="exampleInputEmail1"  placeholder="">
                </div>
                <button type="submit" class="btn btn-info">Kiểm tra</button>
              </form>
              <br>
          <br>
          <br>
          <br>
        </div>
        <div class="col-md-4">
          
        </div>
    </div>
</div>
<!--Container-->

@endsection




