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
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
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
                    { data: 'dathanhtoan', name: 'dathanhtoan'},
                    { data: 'trangthai', name: 'trangthai'},
                    { data: 'tongtien', name: 'tongtien'},
                    { data: 'ngaydat', name: 'ngaydat'},
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

//Hủy đơn hàng
$('body').on('click', '#huy-dh', function () {
                 var id = $(this).data("id");
                 if(confirm("Bạn có chắc muốn hủy đơn hàng này!")){
                 $.ajax({
                       type: "GET",
                       url:'/huy-donhang/'+id,
                       success: function (data) {
                       var oTable = $('#dh-list').dataTable();
                       oTable.fnDraw(false);
                      alertify.success('Đã hủy đơn hàng!');
                       },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                 });
                }
                });

 //Xóa đơn hàng
 $('body').on('click', '#delete-dh', function () {
                 var id = $(this).data("id");
                 if(confirm("Bạn có chắc muốn xóa đơn hàng này!")){
                 $.ajax({
                       type: "GET",
                       url:'/admin/dsdonhang-delete/'+id,
                       success: function (data) {
                       var oTable = $('#dh-list').dataTable();
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
