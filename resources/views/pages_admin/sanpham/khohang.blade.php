
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
<h3 class="card-title">KHO HÀNG</h3>
  <div class="mt-5">
    <table class="display" id="khohang" style="width:100%">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th> </th>
            <th>Sản phẩm</th>
            <th>Có thể bán</th>
            <th>Tồn kho</th>
            <th>Đang giao dịch</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
</table>
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
                $('#khohang').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax : '{!! route('khohang') !!}',
                   columns: [
                    { data: 'id_sp', name: 'id_sp' },
                    { data: 'img', name: 'img' },
                    { data: 'tensp', name: 'tensp',orderable: false  },
                    { data: 'soluong', name: 'soluong'},
                    { data: 'tonkho', name: 'tonkho'},
                    { data: 'giaodich', name: 'giaodich'},
                    { data: 'trangthai', name: 'trangthai'},
                   ]
               });

 });

</script>
@endpush
