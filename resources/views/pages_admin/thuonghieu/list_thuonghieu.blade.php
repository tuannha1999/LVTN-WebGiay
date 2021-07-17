
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12">
<h3 class="card-title">Danh sách thương hiệu</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)"
          id="create-thuonghieu"> Thêm thương hiệu</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="thuonghieu-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã thương hiệu</th>
                <th>Tên thương hiệu</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
</table>
</div>

<div class="modal fade" id="ajax-thuonghieu-modal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="thuonghieuCrudModal"></h4>
        </div>
        <div class="modal-body">
            <form action="{{URL('/admin/dsthuonghieu-add')}}" method="post" id="thuonghieuForm" >
                @csrf
                <div class="form-group">
                    <label for="name" class="col-sm-5 control-label">Mã thương hiệu</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="id_th" id="id_th" value="" maxlength="50" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tenth" class="col-sm-5 control-label">Tên thương hiệu</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="tenth" name="tenth" value="" maxlength="50" required="">
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
                $('#thuonghieu-list').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getThuonghieu') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'ten', name: 'ten'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });
//Show form Thêm
               $('#create-thuonghieu').click(function () {
               $('#btn-save').val("create-thuonghieu");
               $('#thuonghieuForm').trigger("reset");
               $('#thuonghieuCrudModal').html("Thêm Thương Hiệu");
               $('#ajax-thuonghieu-modal').modal('show');
            });

 //Show form sửa
           $('body').on('click', '#edit-thuonghieu', function () {
             var id = $(this).data('id');
             $.get('/admin/dsthuonghieu-edit/'+id, function (data) {
                $('#thuonghieuCrudModal').html("Sửa thương hiệu");
                 $('#btn-save').val("edit-thuonghieu");
                 $('#ajax-thuonghieu-modal').modal('show');
                 $('#id_th').val(data.id);
                 $('#tenth').val(data.ten);
             })
          });

//Xóa Thương hiệu
            $('body').on('click', '#delete-thuonghieu', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa thương hiệu này!")){
                $.ajax({
                      type: "GET",
                      url:'/admin/dsthuonghieu-delete/'+id,
                      success: function (data) {
                            var oTable = $('#thuonghieu-list').dataTable();
                             oTable.fnDraw(false);
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
