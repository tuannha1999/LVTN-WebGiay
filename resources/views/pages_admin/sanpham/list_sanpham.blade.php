
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-5">
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
<h3 class="card-title">Danh sách sản phẩm </h3>
  <div class="text-right">
      <a class="btn btn-success mb-3" href="{{ url('/admin/danhsachsanpham-formadd')}}"
          id="create-new-product"> Thêm sản phẩm</a>
  </div>
</div>

<table class="display" id="product-list" style="width:100%">
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th></th>
                <th>Tên sản phẩm</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
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
                $('#product-list').DataTable({
                   processing: true,
                   serverSide: true,
                   order:[[ 0, 'desc' ], [ 1, 'desc' ]],
                   ajax : '{!! route('getSanpham') !!}',
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'img', name: 'img' },
                    { data: 'tensp', name: 'tensp',orderable: false },
                    { data: 'trangthai', name: 'trangthai' },
                    {data: 'action',name: 'action',orderable: false},

                   ]
               });

 });
      $('body').on('click', '#delete-product', function () {

             var product_id = $(this).data("id");

             if(confirm("Bạn có chắc muốn xóa sản phẩm này !")){
               $.ajax({
                   type: "GET",
                   url:'/admin/danhsachsanpham-delete/'+product_id,
                   success: function (data) {
                   var oTable = $('#product-list').dataTable();
                   oTable.fnDraw(false);
                  //console.log(product_id);
                   },
                    error: function (data) {
                        console.log('Error:', data);
                    }
               });
             }
        });


//alert thông báo
window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);

</script>
@endpush
