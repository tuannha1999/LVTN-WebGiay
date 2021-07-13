
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12">
<h3 class="card-title">Danh sách Phiếu Nhập</h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="{{ url('/admin/dsphieunhap-formadd')}}"
          id="create-new-product"> Tạo phiếu nhập</a>
  </div>
</div>

<table class="display" id="list-phieunhap" style="width:100%">
        <thead>
            <tr>
                <th>Mã phiếu nhập</th>
                <th>Tên nhà cung cấp</th>
                <th>Trạng thái</th>
                <th>Thanh toán</th>
                <th>Tổng tiền</th>
                <th>Nhân viên tạo</th>
                <th> </th>
            </tr>
        </thead>
</table>
@endsection

@push('scripts')
<script type="text/javascript">
 $(document).ready( function () {
              $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
                $('#list-phieunhap').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('getdsPhieuNhap') !!}',
                   columns: [
                    { data: 'id', name: 'id',orderable: false },
                    { data: 'tenncc', name: 'tenncc',orderable: false },
                    { data: 'trangthai', name: 'trangthai'},
                    { data: 'thanhtoan', name: 'thanhtoan'},
                    { data: 'tongtien', name: 'tongtien'},
                    { data: 'tennv', name: 'tennv'},
                    {data: 'action',name: 'action',orderable: false},
                   ]
               });

 });
      $('body').on('click', '#delete', function () {

             var id_pn = $(this).data("id");

             if(confirm("Bạn có chắc muốn xóa phiếu nhập này !")){
               $.ajax({
                   type: "GET",
                   url:'/admin/dsphieunhap-delete/'+id_pn,
                   success: function (data) {
                   var oTable = $('#list-phieunhap').dataTable();
                   oTable.fnDraw(false);
                   },
                    error: function (data) {
                        console.log('Error:', data);
                    }
               });
             }
        });

</script>
@endpush
