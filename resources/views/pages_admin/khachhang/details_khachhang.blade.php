@extends('admin.layout_admin')
@section('home')
<div class="container">
<div class="mt-2"><a href="{{URL('/admin/danhsachkhachhang')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
<div class="col-md-12">
<h2 class="card-title text-center font-weight-bold">THÔNG TIN KHÁCH HÀNG</h2>
<br>
<div class="form-inline" style="padding-left: 100px;"> 
    <div class="">
    <div class="form-group">
    <label for="basic-url"><b>Mã khách hàng:</b>&nbsp;{{$chitiet_kh->id}}</label>
    </div>
<br>
    <div class="form-group">
    <label for="basic-url"><b>Tên khách hàng:</b>&nbsp;{{$chitiet_kh->name}}</label>
    </div>
<br>
    <div class="form-group">
    <label for="basic-url"><b>Email:</b>&nbsp;{{$chitiet_kh->email}}</label>
    </div>
<br>
    <div class="form-group">
    <label for="basic-url"><b>Số điện thoại:</b>&nbsp;{{$chitiet_kh->sdt}}</label>
    </div>
<br>
    <div class="form-group">
    <label for="basic-url"><b>Tổng giao dịch:</b>&nbsp;</label>
    <input type="text" class="form-control @error('tonggd') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="{{$chitiet_kh->tonggd}}" name="tonggd" readonly>     
    </div>

    <!-- <table class="display" id="ddh-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>ID KH</th>
                <th>Tác vụ</th>

            </tr>
        </thead>
    </table> -->
    
    </div>
</div>
</div>

</div>

@endsection
