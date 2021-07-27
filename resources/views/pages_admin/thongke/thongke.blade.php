
@extends('admin.layout_admin')
@section('home')
<div class="col-md-12 mt-3">
<h3 class="card-title">Thống kê</h3>
</div>
<div class="container-fluid">
    <div class="col-md-12">
        <h3 class="card-title text-center">Thống kê doanh số</h3>
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="basic-url">Từ ngày:</label>
                <div class="input-group mb-3">
                  <input type="date" class="form-control " id="basic-url" id="ngaybd" name="ngaybd" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="basic-url">Đến ngày:</label>
                <div class="input-group mb-3">
                  <input type="date" class="form-control " id="basic-url" id="ngaykt" name="ngaykt" >&nbsp;
                  <a href="#"class="btn btn-success btn-loc">Lọc</a>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                {{-- <select name="" id="chonngay" class="form-control">
                    <option value="7">7 ngày qua</option>
                    <option value="30">30 ngày qua</option>
                </select> --}}
            </div>
        </div>
    </div>
</div>
<div class="mt-4">
    <div id="tieude">
    </div>
    <div id="chart" style="height: 250px;"></div>
</div>

@endsection
@push('scripts')

<script type="text/javascript">

    $(function() {
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/admin/thongke-7ngay/",
          })
          .done(function( data ) {
            chart.setData(data);
            $('#tieude').html('Doanh số 7 ngày qua')
          })
          .fail(function() {
            alert( "error occured" );
          });
    });

    $(".btn-loc").click(function() {
        var ngaybd=$("input[name='ngaybd']").val();
        var ngaykt=$("input[name='ngaykt']").val();
        console.log(ngaykt);
        $.ajax({
            type: "get",
            url: "/admin/thongke-locngay/"+ngaybd+'/'+ngaykt,
          })
          .done(function( data ) {
            $('#tieude').html('Doanh số từ '+ ngaybd+' '+'đến '+ngaykt)
            chart.setData(data);
          }).fail(function() {
            alert( "error occured" );
          });

    })

    var chart = Morris.Bar({
          element: 'chart',
          barColors:['#0000CD','#87CEEB','#4682B4'],
          data: [0,0],
          xkey: 'ngaydat',
          ykeys: ['doanhthu','loinhuan','soluong'],
          labels: ['Doanh thu','Lợi nhuận','Số lượng đơn hàng']
        });


</script>
@endpush
