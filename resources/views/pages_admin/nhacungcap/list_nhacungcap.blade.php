
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách nhà cung cấp</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)"
          id="create-ncc"> Thêm nhà cung cấp</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="ncc-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã nhà cung cấp</th>
                <th>Tên nhà cung cấp</th>
                <th>Số điện thoại</th>
                <th>Tổng giao dịch</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
</table>
</div>

<div class="modal fade" id="ajax-ncc-modal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="nccCrudModal"></h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" style="display:none"></div>
            <form action="" method="post" id="nccForm" >
                @csrf
                <div class="form-group">
                    <label for="name" class="col-sm-5 control-label">Mã nhà cung cấp</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="id_ncc" name="id_ncc" value="" maxlength="50" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tenth" class="col-sm-5 control-label">Tên nhà cung cấp</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="tenncc" name="tenncc" value="" maxlength="50" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tenth" class="col-sm-5 control-label">Địa chỉ</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="diachi" name="diachi" value="" maxlength="50" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tenth" class="col-sm-5 control-label">Số điện thoại</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="sdt" name="sdt" value="" maxlength="50" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tenth" class="col-sm-5 control-label">Email</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="email" name="email" value="" maxlength="50" required="">
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
                $('#ncc-list').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getNhacungcap') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tenncc', name: 'tenncc'},
                    { data: 'sdt', name: 'sdt'},
                    { data: 'tonggd', name: 'tonggd'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });
//Show form Thêm
               $('#create-ncc').click(function () {
               $('#btn-save').val("create-ncc");
               $('#nccForm').trigger("reset");
               $('#nccCrudModal').html("Thêm Nhà Cung Cấp");
               $('#ajax-ncc-modal').modal('show');
            });

//btn-save
$('#btn-save').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/dsnhacungcap-add')}}",
                    method: 'post',
                    data: {
                        id: $('#id_ncc').val(),
                        tenncc: $('#tenncc').val(),
                        sdt: $('#sdt').val(),
                        email: $('#email').val(),
                        diachi: $('#diachi').val(),
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
                            location.reload('/admin/dsnhacungcap');
                        }
                    }
                });
            });


 //Show form sửa
           $('body').on('click', '#edit-nhacungcap', function () {
             var id = $(this).data('id');
             $.get('/admin/dsnhacungcap-edit/'+id, function (data) {
                $('#nccCrudModal').html("Sửa Nhà Cung Cấp");
                 $('#btn-save').val("edit-nhacungcap");
                 $('#ajax-ncc-modal').modal('show');
                 $('#id_ncc').val(data.id);
                 $('#tenncc').val(data.tenncc);
                 $('#email').val(data.email);
                 $('#diachi').val(data.diachi);
                 $('#sdt').val(data.sdt);
             })
          });

//Xóa Thương hiệu
            $('body').on('click', '#delete-nhacungcap', function () {
                var id = $(this).data("id");
                if(confirm("Bạn có chắc muốn xóa Nhà Cung cấp này!")){
                $.ajax({
                      type: "GET",
                      url:'/admin/dsnhacungcap-delete/'+id,
                      success: function (data) {
                      var oTable = $('#ncc-list').dataTable();
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
