@extends('admin.layout_admin')
@section('home')
<div class="mt-5">
    <div class="col-md-12">
        <h2 class="card-title">Đơn hàng chờ xử lý</h2>
        </div>
        <div class="mt-4">
            <div class="container-fluid ">
                <table class="display" id="dh-list" style="width:100%">
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
                $('#dh-list').DataTable({
                   processing: true,
                   serverSide: true,
                   order:[[2,'desc']],
                   ajax : '{!! route('getDHcanxuly') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'hoten', name: 'hoten'},
                    { data: 'trangthai', name: 'trangthai'},
                    { data: 'created_at', name: 'created_at'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

// //Xóa Thương hiệu
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
