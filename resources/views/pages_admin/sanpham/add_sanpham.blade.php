@extends('admin.layout_admin')
@section('home')
<div class="container">
    <div class="mt-2"><a href="{{URL('/admin/danhsachsanpham')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
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
            <h2 class="card-title text-center font-weight-bold">THÊM SẢN PHẨM</h2>
            <form action="{{URL('/admin/danhsachsanpham/add-sp')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="basic-url">Mã sản phẩm</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" readonly>
                </div>
                <label for="basic-url">Tên sản phẩm*</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control " id="basic-url" aria-describedby="basic-addon3" value="{{old('tensp')}}" name="tensp">

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="basic-url">Giá bán</label>
                        <div class="input-group mb-3">
                          <input type="number" class="form-control"
                           id="basic-url" aria-describedby="basic-addon3" value="{{old('giaban')}}" name="giaban">
                          @error('giaban')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <label for="basic-url">Giá nhập</label>
                        <div class="input-group mb-3">
                          <input type="number" class="form-control  @error('gianhap') is-invalid @enderror"
                          min="1000" max="100000000" id="basic-url" aria-describedby="basic-addon3" value="" name="gianhap">
                          @error('gianhap')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <label for="basic-url">Giá khuyến mãi</label>
                        <div class="input-group mb-3">
                          <input type="number" class="form-control  "
                          min="0" max="giaban" id="basic-url" aria-describedby="basic-addon3" value="0" name="giakm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="list-lsp">Loại sản phẩm</label> <a href="{{URL('/admin/dsloaisanpham')}}"><i class="fas fa-plus"></i></a>
                                 <select class="form-control " id="list-lsp" name="lsp">
                                    <option value="">- Chọn loại sản phẩm-</option>
                                    @foreach ($loai_sp as $item)
                                     <option @if (old('lsp') ==$item->id) selected="selected" @endif value="{{$item->id}}" >{{$item->tenloai}}</option>
                                     @endforeach
                                </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="list-th">Thương hiệu</label> <a href="{{URL('/admin/dsthuonghieu')}}"><i class="fas fa-plus"></i></a>
                                 <select class="form-control" id="list-th" name="th">
                                   <option value="">- Chọn thương hiệu-</option>
                                    @foreach ($thuonghieu as $item)
                                     <option @if (old('th') ==$item->id) selected="selected" @endif value="{{$item->id}}" >{{$item->ten}}</option>
                                     @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="basic-url">Hình ảnh</label>
                        <div class="input-group mb-3">
                            <input type="file"  id="basic-url" class="form-control "
                             aria-describedby="basic-addon3" value="" name="hinhanh[]"
                              multiple="multiple">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <input type="checkbox" @if (old('trangthai') ==1) checked
                            @endif id="basic-url" @if (old('nosize') ==1) checked  @endif name="nosize" value="1"> Chọn nếu sản phẩm không có nhiều size (vd: dây giày...)
                         </div>
                        <label for="basic-url">Size</label>
                            <input type="text"  class="form-control" placeholder="Nhập size và nhấn enter" id="basic-url"
                             name="tags" aria-describedby="basic-addon3" value="{{old('tags')}}">

                    </div>
                    <div class="col-md-6 mt-5">
                        <input type="checkbox" @if (old('trangthai') ==1) checked  @endif id="basic-url" name="trangthai" value="1"> Cho phép bán
                    </div>
                </div>
                
                <div class="mt-5">
                    <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
                </div>
            </form>


        </div>
    </div>

<script src="{{ asset ('/js/jQuery.tagify.min.js') }}"></script>
<script>
// jQuery
$('[name=tags]').tagify();

// Vanilla JavaScript
var input = document.querySelector('input[name=tags]'),
tagify = new Tagify( input );

$('[name=tags]').tagify({duplicates : false,maxTags:Infinity});

//tắt thông báo sau 3s
window.setTimeout(function() {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
    </script>
@endsection
