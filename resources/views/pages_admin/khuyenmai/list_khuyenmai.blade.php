
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách Khuyến mãi</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)" id="create-khuyenmai"> Tạo khuyến mãi</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="khuyenmai-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã khuyến mãi</th>
                <th>Tên khuyến mãi</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
</table>
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
                    { data: 'ngaybd', name: 'ngaybd'},
                    { data: 'ngaykt', name: 'ngaykt'},
                    { data: 'trangthai', name: 'trangthai'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

// //Show form Thêm
//                $('#create-khuyenmai').click(function () {
//                $('#btn-save').val("create-khuyenmai");
//                $('#khuyenmaiForm').trigger("reset");
//                $('#khuyenmaiCrudModal').html("Thêm Khách Hàng");
//                $('#ajax-khuyenmai-modal').modal('show');
//             });

//  //Show form sửa
//            $('body').on('click', '#edit-khuyenmai', function () {
//              var id = $(this).data('id');
//              $.get('/admin/dskhuyenmai-edit/'+id, function (data) {
//                 $('#khuyenmaiCrudModal').html("Sửa Khách Hàng");
//                  $('#btn-save').val("edit-khuyenmai");
//                  $('#ajax-khuyenmai-modal').modal('show');
//                  $('#id_khuyenmai').val(data.id);
//                  $('#tenkh').val(data.name);
//                  $('#sdt').val(data.sdt);
//                  $('#email').val(data.email);
//              })
//           });

//Xóa Thương hiệu
            $('body').on('click', '#delete-khuyenmai', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa khách hàng!")){
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
 });

</script>
@endpush
