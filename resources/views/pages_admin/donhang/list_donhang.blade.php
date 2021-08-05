
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">Danh sách đơn hàng</h3>
@if (Session::has('success'))
<div class="alert alert-success mt-3" id="alert-success">
    <span>{{Session::get('success')}}</span>
</div>
@endif
  <div class="text-right">
  <a class="btn btn-success mb-3" href="{{ url('/admin/dsdonhang-chuyenform')}}"> Tạo đơn hàng</a>  </div>
</div>
<div class="container-fluid">
    <table class="display" id="donhang-list" style="width:100%">
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
                    order: false,
                   ajax : '{!! route('getDonHang') !!}',
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
                       var oTable = $('#donhang-list').dataTable();
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
                       var oTable = $('#donhang-list').dataTable();
                       oTable.fnDraw(false);
                       alertify.success('Đã xóa đơn hàng!');
                      //console.log(product_id);
                       },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                 });
                }
                });
 });

    //alert thông báo
    window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              6000);
</script>
@endpush
