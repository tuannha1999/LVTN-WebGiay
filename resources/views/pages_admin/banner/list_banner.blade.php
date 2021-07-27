
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách banner</h3>
@if (Session::has('success'))
<div class="alert alert-success mt-3" id="alert-success">
    <span>{{Session::get('success')}}</span>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-warning mt-3" id="alert-success">
    <span>{{Session::get('error')}}</span>
</div>
@endif
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)" id="create-banner"> Thêm banner</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="banner-list" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Tiêu đề</th>
                <th>Hình ảnh</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
</table>
</div>

<div class="modal fade" id="ajax-banner-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="bannerCrudModal"></h4>
        </div>
        <div class="modal-body">
            <form action="{{URL('/admin/dsbanner-add')}}" method="POST" id="bannerForm" enctype="multipart/form-data" >
                @csrf
                <div class="form-group">
                    <label for="id_banner" class="col-sm-5 control-label">Mã banner</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="id_banner" name="id_banner" value="" maxlength="50" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tieude" class="col-sm-5 control-label">Tiêu đề</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="tieude" name="tieude" value="" maxlength="50" required >
                    </div>
                </div>
                <div class="form-group">
                    <label for="tieude" class="col-sm-5 control-label">Hình ảnh (tiêu chuẩn:400 X 1600)</label>
                    <div class="col-sm-12">
                        <input type="file" class="form-control" id="anh" name="anh" value=""  max="" required >
                    </div>
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-success" id="btn-save" value="create" >Lưu</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    </div>

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
                $('#banner-list').DataTable({
                   processing: true,
                   serverSide: true,
                   order:[[2,'desc']],
                   ajax : '{!! route('getBanner') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tieude', name: 'tieude'},
                    { data: 'img', name: 'img'},
                    { data: 'trangthai', name: 'trangthai'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

//show form thêm
$('#create-banner').click(function () {
               $('#btn-save').val("create-banner");
               $('#bannerForm').trigger("reset");
               $('#bannerCrudModal').html("Thêm Banner");
               $('#ajax-banner-modal').modal('show');
            });

//btn-save
// $('#btn-save').click(function(e){
//                 e.preventDefault();
//                 $.ajaxSetup({
//                     headers: {
//                         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                     }
//                 });
//                 $.ajax({
//                     url: '/admin/dsbanner-add',
//                     method: 'post',
//                     data: {
//                         id: $('#id_banner').val(),
//                         tieude: $('#tieude').val(),
//                         anh: $("input[name='anh']").val(),
//                     },
//                     success: function(result){
//                         if(result.errors)
//                         {
//                             $('.alert-danger').html('');

//                             $.each(result.errors, function(key, value){
//                                 $('.alert-danger').show();
//                                 $('.alert-danger').append('<li>'+value+'</li>');
//                             });
//                             //tắt thông báo sau 3s
//                             setTimeout(function(){
//                                 $('.alert-danger').hide('');
//                             }, 3000);
//                         }
//                         else
//                         {
//                             location.reload('/admin/dsbanner');
//                         }
//                     }
//                 });
//             });


//Xóa đơn hàng
            $('body').on('click', '#delete-banner', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa banner này!")){
                $.ajax({
                      type: "GET",
                      url:'/admin/dsbanner-delete/'+id,
                      success: function (data) {
                      var oTable = $('#banner-list').dataTable();
                      oTable.fnDraw(false);
                      alertify.success("Đã xóa banner!")
                      },
                       error: function (data) {
                           console.log('Error:', data);
                       }
                });
            }
        });
//tắt thông báo sau 3s
setTimeout(function(){
        $('.alert-success').hide('');
        $('.alert-warning').hide('');
}, 3000);
 });

</script>
@endpush
