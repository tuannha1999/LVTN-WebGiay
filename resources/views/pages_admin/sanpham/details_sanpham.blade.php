@extends('admin.layout_admin')
@section('home')
<div class="container">

    <div class="mt-2"><a href="{{URL('/admin/danhsachsanpham')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
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
    <div class="col-md-12">
        <h2 class="card-title text-center font-weight-bold">CHI TIẾT SẢN PHẨM</h2>
        <form action="{{URL('/admin/danhsachsanpham/edit-sp/')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="basic-url">Mã sản phẩm</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control " id="basic-url" name="id" aria-describedby="basic-addon3" value="{{$chitiet_sp->id}}" readonly>
            </div>
            <label for="basic-url">Tên sản phẩm</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control " name="tensp" id="basic-url" aria-describedby="basic-addon3" value="{{$chitiet_sp->tensp}}">

            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="basic-url">Giá bán</label>
                    <div class="input-group mb-3">
                      <input type="number" class="form-control" name="giaban" id="basic-url" aria-describedby="basic-addon3" value="{{$chitiet_sp->giaban}}">

                    </div>
                </div>

                <div class="col-md-4">
                    <label for="basic-url">Giá khuyến mãi</label>
                    <div class="input-group mb-3">
                      <input type="number" class="form-control" name="giakm" id="basic-url" aria-describedby="basic-addon3" value="{{$chitiet_sp->giakm}}">

                    </div>
                </div>
                <div class="col-md-4">
                    <label for="basic-url">Giá nhập</label>
                    <div class="input-group mb-3">
                      <input type="number" class="form-control" readonly name="gianhap" id="basic-url" aria-describedby="basic-addon3" value="{{$chitiet_sp->gianhap}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Loại sản phẩm</label>
                                <select class="form-control" name="lsp" id="exampleFormControlSelect1">
                                    <option value="{{$chitiet_sp->loaisanpham->id}}" >{{$chitiet_sp->loaisanpham->tenloai}}</option>
                                  @foreach ($all_loai as $item)
                                  <option value="{{$item->id}}">{{$item->tenloai}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Thương hiệu</label>
                                <select class="form-control" name="th" id="exampleFormControlSelect1">
                                    @if ($chitiet_sp->id_th!==null)
                                    <option value="{{$chitiet_sp->thuonghieu->id}}">{{$chitiet_sp->thuonghieu->ten}}</option>
                                    @else
                                    <option value=""></option>
                                    @endif
                                  @foreach ($thuonghieu as $item)
                                  <option value="{{$item->id}}" >{{$item->ten}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="row">
                            <div class="col-6"><div class="input-group mt-4">
                                Trạng thái kho:
                                @if($total_sp!=0)
                                    <span class="text-success"> Còn hàng</span>
                                @else
                                    <span class="text-warning"> Hết hàng</span>
                                @endif
                            </div>
                        </div>
                            <div class="col-6 mt-4">
                                <input type="checkbox" id="basic-url" name="trangthai" value="1" {{$chitiet_sp->trangthai==1?'checked':''}}> Cho phép bán
                            </div>
                        </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Hình ảnh</label>
                            <input type="file"  id="basic-url" class="form-control "
                             aria-describedby="basic-addon3" value="" name="hinhanh[]"
                              multiple="multiple">

                        </div>
                          <div class="owl-carousel owl-theme mt-3">
                            @foreach ($chitiet_sp->Hinhanh as $img)
                            <div class="form-group">
                                <div class="dropdown- show mb-2">
                                    <a class="link" href="#" role="button" id="dropdownMenuLink"
                                     data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">...</a>
                                    <div class="dropdown-menu dropdown-menu-tt"   aria-labelledby="dropdownMenuLink">
                                      <a class="dropdown-item " href="{{URL('avatar/'.$img->id.'/'.$img->id_sp)}}">Đặt làm avatar</a>
                                      <a class="dropdown-item" href="{{URL('delete/'.$img->id)}}">Xóa</a>
                                    </div>
                                  </div>
                                 <div class="item text-center"><img src="{{asset ('storage/'.$img->name) }}" alt="">
                                    @if ($img->avt==1)
                                       <span>Avatar</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            {{-- @if($chitiet_sp->loaisanpham->slug=='giay') --}}

                <div class="col-md-6">
                    <label for="basic-url">Bảng size</label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="size-name" aria-describedby="basic-addon3" placeholder="Nhập size cần thêm...">
                        <div class="input-group-prepend">
                            <a href="#"class="btn btn-primary" data-id="{{$chitiet_sp->id}}" id="create_size">Thêm</a>

                        </div>
                    </div>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-size">
                        <table class="table mb-0">
                          <thead class="sticky-top">
                            <tr>
                              <th scope="col">Size</th>
                              <th scope="col">Số lượng</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($chitiet_sp->Size as $item)
                            <tr>
                                <td>{{$item->size}}</td>
                                <td>{{$item->soluong}}</td>
                                <td>
                                    <a href="#" data-id="{{$item->id}}" class=" delete-size"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
                {{-- @endif --}}
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">Lưu</button>
            </div>
        </form>
    </div>

</div>
<script src="{{ asset ('/js/owl.carousel.min.js') }}" type="text/javascript"></script>
<script>

 //hinhanh
 $('.owl-carousel').owlCarousel({
                loop:false,
                margin:10,
                nav:true,
                responsive:{
                    50:{
                        items:3
                        },
                }
            })
    $(document).ready( function () {

            //Them size
            $('#create_size').on('click',function(){
                var product_id = $(this).data("id");
               // console.log(product_id);
               $.ajaxSetup({
                  headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
                 });
                $.ajax({
                        url:'/admin/add-size/'+product_id+'/'+$("#size-name").val(),
                        type:'GET',
                        success: function (data) {
                            if(data==false)
                            {
                                alertify.error("Size đã tồn tại!");
                            }
                            else
                            location.reload();
                   },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                 })
             })
             //Delete Size
             $('.delete-size').on('click',function(){
               // console.log(product_id);
               if(confirm("Bạn có chắc muốn xóa size này !!")){
                $.ajax({
                        url:'/admin/delete-size/'+$(this).data("id"),
                        type:'GET',
                        success: function (data) {
                            location.reload();
                            //alertify.success("Xóa thành công")
                   },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                 })
               }
             })

    });
    //alert thông báo
             window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);
</script>
@endsection
