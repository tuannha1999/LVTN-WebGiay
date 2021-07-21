
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách đơn hàng</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="javascript:void(0)" id="create-lsp"> Tạo đơn hàng</a>
  </div>
</div>
<div class="container-fluid">
    <table class="display" id="donhang-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Trạng thái</th>
                <th>Ngày mua hàng</th>
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
                $('#donhang-list').DataTable({
                   processing: true,
                   serverSide: true,
                   order:[[2,'desc']],
                   ajax : '{!! route('getDonHang') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'hoten', name: 'hoten'},
                    { data: 'trangthai', name: 'trangthai'},
                    { data: 'created_at', name: 'created_at'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

// //Xóa đơn hàng
//             $('body').on('click', '#delete-lsp', function () {
//                 var id = $(this).data("id");
//                 if(confirm("Bạn có chắc muốn xóa thương hiệu này!")){
//                 $.ajax({
//                       type: "GET",
//                       url:'/admin/dsloaisanpham-delete/'+id,
//                       success: function (data) {
//                       var oTable = $('#lsp-list').dataTable();
//                       oTable.fnDraw(false);
//                      //console.log(product_id);
//                       },
//                        error: function (data) {
//                            console.log('Error:', data);
//                        }
//                 });
//             }
//         });
 });

</script>
@endpush
