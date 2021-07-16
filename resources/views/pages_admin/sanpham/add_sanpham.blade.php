@extends('admin.layout_admin')
@section('home')
<div class="container">
    <div class="mt-2"><a href="{{URL('/admin/danhsachsanpham')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
        <div class="col-md-12">
            <h2 class="card-title text-center font-weight-bold">THÊM SẢN PHẨM</h2>
            <form action="{{URL('/admin/danhsachsanpham/add-sp')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="basic-url">Mã sản phẩm</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" readonly>
                </div>
                <label for="basic-url">Tên sản phẩm*</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('tensp') is-invalid @enderror" id="basic-url" aria-describedby="basic-addon3" value="" name="tensp">
                    @error('tensp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="basic-url">Giá bán</label>
                        <div class="input-group mb-3">
                          <input type="number" class="form-control @error('giaban') is-invalid @enderror"
                           id="basic-url" aria-describedby="basic-addon3" min="1000" max="100000000" value="" name="giaban">
                          @error('giaban')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    </div>
                    <div class="col-md-4">
                        <label for="basic-url">Giá khuyến mãi</label>
                        <div class="input-group mb-3">
                          <input type="number" class="form-control  @error('giakm') is-invalid @enderror"
                          min="0" max="giaban" id="basic-url" aria-describedby="basic-addon3" value="" name="giakm">
                          @error('giakm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="list-lsp">Loại sản phẩm</label>
                                 <select class="form-control" id="list-lsp" name="lsp">
                                    <option value="0">- Chọn loại sản phẩm-</option>
                                    @foreach ($loai_sp as $item)
                                     <option value="{{$item->id}}" >{{$item->tenloai}}</option>
                                     @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="list-th">Thương hiệu</label>
                                 <select class="form-control" id="list-th" name="th">
                                   <option value="0"></option>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="basic-url">Hình ảnh</label>
                        <div class="input-group mb-3">
                            <input type="file"  id="basic-url" class="form-control @error('hinhanh') is-invalid @enderror"
                             aria-describedby="basic-addon3" value="" name="hinhanh[]"
                              multiple="multiple">
                              @error('hinhanh')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                             @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="basic-url">Size</label>
                            <input type="text"  placeholder="Nhập size và nhấn enter" id="basic-url" name="tags" aria-describedby="basic-addon3" value="">
                    </div>
                    <div class="col-md-6 mt-5">
                        <input type="checkbox" id="basic-url" name="trangthai" value="1"> Cho phép bán
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


$(document).ready(function(){

      $("#list-lsp").change(function(){

            var id_lsp= $(this).val();
            console.log(id_lsp);
            if(id_lsp != '0')
            {
               $.ajax({
                  type: 'GET',
                  url: '/admin/changelist/'+id_lsp,
                  success: function(data){
                    var len=data.length;
                    $("#list-th").empty();
                    for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['ten'];
                    $("#list-th").append("<option value='"+id+"'>"+name+"</option>");
                }
                  }
               });
            }
      });

   });
    </script>
@endsection
