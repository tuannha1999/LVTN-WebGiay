@extends('admin.layout_admin')
@section('home')
<div class="container">
<div class="mt-2"><a href="{{URL('/admin/danhsachkhachhang')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
<div class="col-md-12">
<h2 class="card-title text-center font-weight-bold">THÊM KHÁCH HÀNG</h2>
<br>
<form action="{{URL('/admin/danhsachkhachhang-add')}}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row" style="padding-left: 100px;"> 
    <div class="col-md-4 ">
    <div class="form-group">
    <label for="basic-url">Mã khách hàng:</label>
    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" readonly>
    </div>

    <div class="form-group">
    <label for="basic-url">Tên khách hàng (*):</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="" name="name">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>

    <div class="form-group">
    <label for="basic-url">Email (*):</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="" name="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>

    <div class="form-group">
    <label for="basic-url">Số điện thoại (*):</label>
    <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="" name="sdt">
            @error('sdt')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-success">Thêm khách hàng</button>
    </div>
    </div>
    
</div>

</div>


</form>
</div>


@endsection
