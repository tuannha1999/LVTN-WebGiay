@extends('layout')
@section('noidung')
@section('title')
Thông tin Thành Viên
@endsection
<hr>
<div class="container mt-4">
<h3>Thông tin Thành Viên</h3>
<hr>
  <form action="{{ url('/profile-edit') }}" method="post" enctype="multipart/form-data">
  @csrf
    <div class="col-md-12">
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('success')}}</span>
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
        <div class="form-group">
          <label>Mã thành viên</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control " id="" name="id" value="{{Auth::user()->id}}" readonly>
            </div>
          </div>
          <div class="form-group">
          <label>Họ tên*</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control " id="" name="name" value="{{Auth::user()->name}}" >
            </div>
          </div>
          <div class="form-group">
          <label class="text-danger">Điểm tích lũy/Giảm giá</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control " id="" name="level" value="{{Auth::user()->phantram*100}}%" readonly>
            </div>
          </div>
          <div class="form-group">
          <label class="text-danger">Tổng giao dịch</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control " id="" name="level" value="{{number_format((Auth::user()->tonggd),0,',',',')}}đ" readonly>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6">
              <div class="form-group">
              <label>Email*</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control " id="" name="email" value="{{Auth::user()->email}}" >
                </div>
              </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <label>Số điện thoại*</label>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control " id="" name="sdt" value="{{Auth::user()->sdt}}" >
                  </div>
                </div>
              </div>

          </div>
          <br>
          <div class="text-center">
                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
          </div>


    </div>
    </form>
<br>
<br>
    <div class="col-md-8">
        <a href="#" onClick="history.go(-1);" class="link text-info"><i class="fas fa-chevron-left"></i> <span>Quay lại</span></a>
    </div>
</div>
<script>
//alert thông báo
window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);
</script>

@endsection


