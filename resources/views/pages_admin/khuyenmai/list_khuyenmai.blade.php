
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách Khuyến mãi</h3>
@if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
@endif
  <div class="text-right">
    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exampleModalCenter">
        Tạo khuyến mãi</button>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="khuyenmai-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã khuyến mãi</th>
                <th>Tên khuyến mãi</th>
                <th>Mã giảm giá</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
                <th>Hết hạn</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
</table>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Chọn hình thức khuyến mãi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{URL('admin/dskhuyenmai-form-tangsp')}}" class="btn btn-info">Mã giảm giá <i class="fas fa-gift"></i></a>
                    </div>

                </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
              </div>

      </div>
    </div>
  </div>


  {{-- <div class="modal fade" id="ajax-khuyenmai-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="khuyenmaiCrudModal"></h4>
        </div>
        <div class="modal-body">
                <label for="basic-url">Tên khuyến mãi</label>
                <div class="input-group mb-3">
                    <div class="form-control" id="tenkm">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="basic-url">Ngày bắt đầu</label>
                        <div class="input-group mb-3">
                            <div class="form-control" id="ngaybd"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="basic-url">Ngày kết thúc</label>
                        <div class="input-group mb-3">
                            <div class="form-control" id="ngaykt">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <h5>Mã giảm giá</h5>
                        <div class="form-control" id="macode">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Điều kiện (Tổng đơn hàng)</h5>
                        <div class="form-control" id="dieukien">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Tiền giảm</h5>
                        <div class="form-control" id="tiengiam">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <input type="text" hidden id="id_km" value="">
                    <div id="stop">

                    </div>
                    <div id="run">

                </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    </div> --}}

</div>


@endsection

@push('scripts')
<script type="text/javascript">
 $(document).ready( function () {
              $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
                $('#khuyenmai-list').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getkhuyenmai') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tenkm', name: 'tenkm'},
                    { data: 'macode', name: 'macode'},
                    { data: 'ngaybd', name: 'ngaybd'},
                    { data: 'ngaykt', name: 'ngaykt'},
                    { data: 'trangthai', name: 'trangthai'},
                    { data: 'hethan', name: 'hethan'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });


//  //Show form chi tiet
//            $('body').on('click', '#edit-khuyenmai', function () {
//              var id = $(this).data('id');
//              $.get('/admin/dskhuyenmai-detail/'+id, function (data) {
//                 $('#khuyenmaiCrudModal').html("Chi tiết Khuyến mãi");
//                  $('#btn-save').val("edit-khuyenmai");
//                  $('#ajax-khuyenmai-modal').modal('show');
//                  $('#id_km').val(data.id);
//                  $('#tenkm').html(data.tenkm);
//                  $('#ngaybd').html(data.ngaybd);
//                  $('#ngaykt').html(data.ngaykt);
//                  $('#macode').html(data.macode);
//                  $('#dieukien').html(data.dieukien);
//                  $('#tiengiam').html(data.tiengiam);

//              })
//           });

//Xóa Thương hiệu
            $('body').on('click', '#delete-khuyenmai', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa Khuyến mãi này!")){
                $.ajax({
                      type: "GET",
                      url:'/admin/dskhuyenmai-delete/'+id,
                      success: function (data) {
                      var oTable = $('#khuyenmai-list').dataTable();
                      oTable.fnDraw(false);
                     //console.log(product_id);
                      },
                       error: function (data) {
                           console.log('Error:', data);
                       }
                });
            }
        });

// //Dừng khuyến mãi
// $('.btn-stop').on('click',function(){
//                console.log($('#id_km').val());
//                if(confirm("Bạn có chắc muốn dừng khuyến mãi này?")){
//                 $.ajax({
//                         url:'/admin/dskhuyenmai-stop/'+$('#id_km').val(),
//                         type:'GET',
//                         success: function (data) {
//                             location.reload();
//                    },
//                     error: function (data) {
//                         console.log('Error:', data);
//                     }
//                  })
//                }
//              })
// //Chạy khuyến mãi
// $('.btn-run').on('click',function(){
//                console.log($('#id_km').val());
//                if(confirm("Bạn có chắc muốn chạy khuyến mãi này?")){
//                 $.ajax({
//                         url:'/admin/dskhuyenmai-run/'+$('#id_km').val(),
//                         type:'GET',
//                         success: function (data) {
//                             location.reload();
//                    },
//                     error: function (data) {
//                         console.log('Error:', data);
//                     }
//                  })
//                }
//              })
 });

 //Tắt thông báo
 window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
</script>
@endpush
