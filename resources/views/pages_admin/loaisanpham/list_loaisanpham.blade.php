
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách loại sản phẩm</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)"
          id="create-lsp"> Thêm loại</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="lsp-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã loại</th>
                <th>Tên loại</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
</table>
</div>

<div class="modal fade" id="ajax-lsp-modal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="lspCrudModal"></h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" style="display:none"></div>
            <form action="" method="post" id="lspForm" >
                @csrf
                <div class="form-group">
                    <label for="name" class="col-sm-5 control-label">Mã loại</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="id_loai" name="id_loai" value="" maxlength="50" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tenth" class="col-sm-5 control-label">Tên loại</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="tenloai" name="tenloai" value="" maxlength="50" required="">
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
                $('#lsp-list').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getLoaisanpham') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tenloai', name: 'tenloai'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });
//Show form Thêm
               $('#create-lsp').click(function () {
               $('#btn-save').val("create-lsp");
               $('#lspForm').trigger("reset");
               $('#lspCrudModal').html("Thêm Loại Sản Phẩm");
               $('#ajax-lsp-modal').modal('show');
            });


            $('#btn-save').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/dsloaisanpham-add')}}",
                    method: 'post',
                    data: {
                        id: $('#id_loai').val(),
                        tenloai: $('#tenloai').val(),
                    },
                    success: function(result){
                        if(result.errors)
                        {
                            $('.alert-danger').html('');

                            $.each(result.errors, function(key, value){
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>'+value+'</li>');
                            });
                            //tắt thông báo sau 3s
                            setTimeout(function(){
                                $('.alert-danger').hide('');
                            }, 3000);;
                        }
                        else
                        {
                            location.reload('/admin/dsloaisanpham');
                        }
                    }
                });
            });

 //Show form sửa
           $('body').on('click', '#edit-lsp', function () {
             var id = $(this).data('id');
             $.get('/admin/dsloaisanpham-edit/'+id, function (data) {
                $('#lspCrudModal').html("Sửa Loại Sản Phẩm");
                 $('#btn-save').val("edit-lsp");
                 $('#ajax-lsp-modal').modal('show');
                 $('#id_loai').val(data.id);
                 $('#tenloai').val(data.tenloai);
             })
          });

//Xóa Thương hiệu
            $('body').on('click', '#delete-lsp', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa loại sản phẩm này!")){
                $.ajax({
                      type: "GET",
                      url:'/admin/dsloaisanpham-delete/'+id,
                      success: function (data) {
                      var oTable = $('#lsp-list').dataTable();
                      oTable.fnDraw(false);
                      alertify.success("Đã xóa loại sản phẩm!");
                      },
                       error: function (data) {
                           //console.log('Error:', data);
                           alertify.error("Không thể xóa loại sản phẩm này!");
                       }
                });
            }
        });
 });

</script>
@endpush
