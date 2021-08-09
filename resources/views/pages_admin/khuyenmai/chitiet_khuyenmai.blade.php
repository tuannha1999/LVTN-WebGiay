@extends('admin.layout_admin')
@section('home')
<div class="container">
    <div class="mt-2"><a href="{{URL('/admin/dskhuyenmai')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
        <div class="col-md-12">
            @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2 class="card-title text-center font-weight-bold">CHỈNH SỬA KHUYẾN MÃI</h2>
            <form action="{{URL('/admin/dskhuyenmai-edit-khuyenmai')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="basic-url">Mã khuyến mãi</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" value="{{$khuyenmai->id}}" readonly>
                </div>
                <label for="basic-url">Tên khuyến mãi*</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" aria-describedby="basic-addon3" value="{{$khuyenmai->tenkm}}" name="tenkm">

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="basic-url">Ngày bắt đầu*</label>
                        <div class="input-group mb-3">
                          <input type="date" class="form-control"
                           id="basic-url" aria-describedby="basic-addon3" value="{{$khuyenmai->ngaybd}}" name="ngaybd">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="basic-url">Ngày kết thúc*</label>
                        <div class="input-group mb-3">
                          <input type="date" class="form-control"  value="{{$khuyenmai->ngaykt}}" name="ngaykt">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <h5>Nhập mã giảm giá</h5>
                        <input type="text" name="macode" id="" value="{{$khuyenmai->macode}}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <h5>Điều kiện giảm giá (Tổng giá trị đơn hàng)</h5>
                        <input type="number" name="dieukien" value="{{$khuyenmai->dieukien}}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <h5>Nhập số tiền giảm</h5>
                        <input type="number" name="tiengiam" id="" value="{{$khuyenmai->tiengiam}}" class="form-control">
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">Chỉnh sửa</button>
                    </div>
                    <div class="col-md-10">
                        @if ($khuyenmai->trangthai == 1 && $khuyenmai->ngaykt >= Carbon::now())
                            <a href="{{ URL('/admin/dskhuyenmai-stop/' . $khuyenmai->id)}}" class="btn btn-danger">Stop</a>
                        @elseif ($khuyenmai->trangthai == 0 && $khuyenmai->ngaykt >= Carbon::now())
                            <a href="{{URL('/admin/dskhuyenmai-run/' . $khuyenmai->id) }}" class="btn btn-success">Run</a>
                        @endif
                    </div>
                </div>

            </form>


        </div>
    </div>

<script>

//tắt thông báo sau 3s
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
    </script>
@endsection
