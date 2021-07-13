@extends('admin.layout_admin')
@section('home')
<div class="container">
    <div class="mt-2"><a href="{{URL('/admin/danhsachsanpham')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
        <div class="col-md-12">
            <h2 class="card-title text-center font-weight-bold">TẠO PHIẾU NHẬP</h2>
            <form action="{{URL('/admin/danhsachsanpham/add-sp')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="basic-url">Mã phiếu nhập</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="id" readonly>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="basic-url">Nhà cung cấp</label>
                        <div class="input-group mb-3">
                         <select class="form-control" id="list-ncc" name="ncc">
                            <option value="0">- Chọn nhà cung cấp-</option>
                             @foreach ($ncc as $item)
                              <option value="{{$item->id}}" >{{$item->tenncc}}</option>
                             @endforeach
                         </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="thongtin">
                        </div>
                    </div>
                </div>
                <label for="basic-url">Sản phẩm</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="search"  aria-describedby="basic-addon3" placeholder="Nhập size cần thêm...">
                    <div class="input-group-prepend">
                        <a href="#" class="btn btn-outline-info" data-id="" id="search_sp"><i class="fas fa-search"></i></a>
                    </div>
                </div>
                <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-sp">
                    <table class="table mb-0">
                      <thead class="sticky-top">
                        <tr>
                          <th scope="col">id</th>
                          <th scope="col">Tên sản phẩm</th>
                          <th scope="col">Size</th>
                          <th scope="col">Số lượng</th>
                          <th scope="col">Giá nhập</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody id="sp">
                          <tr>
                            </tr>
                      </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-success">Tạo phiếu nhập</button>
                </div>
            </form>


        </div>
    </div>

<script>
// jQuery


$(document).ready(function(){

      $("#list-ncc").change(function(){

            var id_ncc= $(this).val();
            if(id_ncc != '0')
            {
               $.ajax({
                  type: 'GET',
                  url: '/admin/dsphieunhap-nhacungcap/'+id_ncc,
                  success: function(data){
                    $("#thongtin").append(" <h5 class='font-weight-bold'>Thông tin nhà cung cấp</h5><span>"+data['tenncc']+"</span><br><span>"+data['diachi']+"</span><br><span>"+data['sdt']+"</span>");
                  }
               });
             }
             else
             {
                $("#thongtin").html('');
             }
      });

   });
   $("#search_sp").click(function(){

    var search = $("input[name='search']").val();
   $.ajax({
      type: 'GET',
      url: '/admin/dsphieunhap-sanpham/'+ $("input[name='search']").val(),
      success: function(data){
        $('#sp').empty();
        $('#sp').html(data);
      }
   });
});


    </script>
@endsection
