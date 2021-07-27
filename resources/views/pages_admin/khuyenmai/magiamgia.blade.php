@extends('admin.layout_admin')
@section('home')
<div class="container">
    <div class="mt-2"><a href="{{URL('/admin/dskhuyenmai')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2 class="card-title text-center font-weight-bold">TẠO KHUYẾN MÃI</h2>
            <form action="{{URL('/admin/dskhuyenmai-add-khuyenmai')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="basic-url">Mã khuyến mãi</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" readonly>
                </div>
                <label for="basic-url">Tên khuyến mãi*</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" aria-describedby="basic-addon3" value="{{old('tenkm')}}" name="tenkm">

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="basic-url">Ngày bắt đầu*</label>
                        <div class="input-group mb-3">
                          <input type="date" class="form-control"
                           id="basic-url" aria-describedby="basic-addon3" value="{{old('ngaybd')}}" name="ngaybd">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="basic-url">Ngày kết thúc*</label>
                        <div class="input-group mb-3">
                          <input type="date" class="form-control"  value="{{old('ngaykt')}}" name="ngaykt">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <h5>Nhập mã giảm giá</h5>
                        <input type="text" name="macode" id="" value="{{old('macode')}}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <h5>Điều kiện giảm giá (Tổng giá trị đơn hàng)</h5>
                        <input type="number" name="dieukien" value="{{old('dieukien')}}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <h5>Nhập số tiền giảm</h5>
                        <input type="number" name="tiengiam" id="" value="{{old('tiengiam')}}" class="form-control">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-success">Tạo khuyến mãi</button>
                </div>
            </form>


        </div>
    </div>

<script src="{{ asset ('/js/jQuery.tagify.min.js') }}"></script>
<script>

//tắt thông báo sau 3s
window.setTimeout(function() {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
    </script>
@endsection
