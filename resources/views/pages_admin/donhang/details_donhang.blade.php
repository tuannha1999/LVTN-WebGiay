@extends('admin.layout_admin')
@section('home')
<div class="container">

    <div class="mt-2"><a href="{{URL('admin/dsdonhang')}}" ><i class="fas fa-2x fa-chevron-left"></i></a></div>
    @if (Session::has('success'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-warning mt-3" id="alert-success">
        <span>{{Session::get('error')}}</span>
    </div>
    @endif
    <div class="col-md-12">
        <h2 class="card-title text-center font-weight-bold">CHI TIẾT ĐƠN HÀNG </h2>
        @if ($donhang->trangthai==0||$donhang->trangthai==1)
        <form action="{{URL('/admin/dsdonhang-update-donhang/')}}" method="POST">
            @csrf
                <div class="row">
                    <h3 class="font-weight-bold">Thông tin mua hàng</h3>
                        <table class="table mb-0 border">
                            <tr>
                                <td>Mã đơn hàng</td>
                                <td>
                                    <input type="text" class="form-control" name="id" value="{{$donhang->id}}" readonly>
                                </td>
                            </tr>
                            <tr>
                                  <td>Họ tên</td>
                                  <td>
                                      <input type="text" class="form-control" name="hoten" value="{{$donhang->hoten}}">
                                  </td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td>
                                    <input type="number" class="form-control" name="sdt" value="{{$donhang->sdt}}">
                                </td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td>
                                    <input type="text" class="form-control" name="diachi" value="{{$donhang->diachi}}">
                                </td>
                            </tr>
                            <tr>
                                <td>Phương thức thanh toán</td>
                                <td>
                                    <select name="ptthanhtoan" id="" class="form-control">
                                        <option value="{{$donhang->ptthanhtoan}}">
                                        @if ($donhang->ptthanhtoan==0)
                                             <span><b>Thanh toán khi nhận hàng</b></span>
                                        @else
                                             <span><b>Chuyển khoản ngân hàng</b></span>
                                         @endif
                                        </option>
                                        <option value="@if ($donhang->ptthanhtoan==1) 0 @else 1 @endif">
                                         @if ($donhang->ptthanhtoan==1)
                                             <span><b>Thanh toán khi nhận hàng</b></span>
                                        @else
                                             <span><b>Chuyển khoản ngân hàng</b></span>
                                         @endif
                                        </option>
                                    </select>

                                </td>
                            </tr>
                            <tr>
                                <td>Ghi chú</td>
                                <td>
                                    <textarea name="ghichu" id="" cols="50" rows="2">{{$donhang->ghichu}}</textarea>

                                </td>
                            </tr>
                            <tr>
                                <td>Trạng thái</td>
                                <td>
                                        @if ($donhang->trangthai==0)
                                            <span class="text-warning">CHỜ XỬ LÝ</span>
                                        @elseif ($donhang->trangthai==1)
                                            <span class="text-info">CHỜ GIAO HÀNG</span>
                                        @elseif ($donhang->trangthai==2)
                                            <span class="text-primary">ĐANG GIAO HÀNG</span>
                                        @elseif ($donhang->trangthai==3)
                                            <span class="text-success">HOÀN THÀNH</span>
                                        @else
                                            <span class="text-danger">ĐÃ HỦY</span>
                                        @endif

                                </td>
                            </tr>

                          </table>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
        @else
        <div class="row">
            <h3 class="font-weight-bold">Thông tin mua hàng</h3>
                <table class="table mb-0 border">
                    <tr>
                        <td>Mã đơn hàng</td>
                        <td>
                            {{$donhang->id}}
                        </td>
                    </tr>
                    <tr>
                          <td>Họ tên</td>
                          <td>
                             {{$donhang->hoten}}
                          </td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td>
                            {{$donhang->sdt}}
                        </td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>
                            {{$donhang->diachi}}
                        </td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td>
                            @if ($donhang->ptthanhtoan==0)
                            <span><b>Thanh toán khi nhận hàng</b></span>
                             @else
                            <span><b>Chuyển khoản ngân hàng</b></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ghi chú</td>
                        <td>
                            {{$donhang->ghichu}}
                        </td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>
                                @if ($donhang->trangthai==0)
                                    <span class="text-warning">CHỜ XỬ LÝ</span>
                                @elseif ($donhang->trangthai==1)
                                    <span class="text-info">CHỜ GIAO HÀNG</span>
                                @elseif ($donhang->trangthai==2)
                                    <span class="text-primary">ĐANG GIAO HÀNG</span>
                                @elseif ($donhang->trangthai==3)
                                    <span class="text-success">HOÀN THÀNH</span>
                                @else
                                    <span class="text-danger">ĐÃ HỦY</span>
                                @endif

                        </td>
                    </tr>

                  </table>
        </div>
        @endif


        <div class="mt-4">
            <h4 class="font-weight-bold">Thông tin sản phẩm</h4>
            <div class="table-wrapper-scroll-y my-custom-scrollbar" id="table-size">
                    <table class="table mb-0">
                      <thead class="sticky-top">
                        <tr>
                          <th scope="col">Mã sản phẩm</th>
                          <th scope="col">Tên sản phẩm</th>
                          <th scope="col">Số lượng</th>
                          <th scope="col">Giá bán</th>
                          <th scope="col"> </th>

                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($donhang->sanpham as $sp)
                            <tr>
                                <td>{{$sp->id}}</td>
                                <td>
                                    <img src="{{asset ('storage/'.$sp->pivot->img) }}" alt="" height="50px" width="50px">
                                    {{$sp->tensp.' - '.$sp->pivot->size}}</td>
                                <td>
                                    <input  type="number" min="1"
                                    id="qty-update-{{$sp->id.$sp->pivot->size}}" value="{{$sp->pivot->soluong}}" style="width: 70px;height: 30px;"/>
                                    </td>
                                <td>{{number_format($sp->pivot->giaban,0,'.','.')}}</td>
                                @if ($donhang->trangthai==0||$donhang->trangthai==1||$donhang->trangthai==2)
                                <td>
                                    <i onclick="updateSanPham({{$donhang->id.','.$sp->id.','}}'{{$sp->pivot->size}}')" class="fas fa-2x fa-save"></i>
                                    <a href="{{URL('/admin/dsdonhang-delete-sanpham/'.$donhang->id.'/'.$sp->id.'/'.$sp->pivot->size)}}"><i class="fas fa-2x fa-trash-alt"></a></i>
                                </td>
                                @endif

                           </tr>
                          @endforeach
                      </tbody>
                    </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                                <div class="btn-group dropdown- show mb-2">
                                    @if ($donhang->trangthai==0)
                                     <a href="{{URL('admin/dsdonhang-duyetdon/'.$donhang->id)}}" class="btn btn-info btn-nhapkho">Duyệt đơn</a>
                                    @elseif ($donhang->trangthai==1)
                                     <a href="{{URL('admin/dsdonhang-giaohang/'.$donhang->id)}}" class="btn btn-primary btn-nhapkho">Giao hàng</a>
                                    @elseif ($donhang->trangthai==2)
                                     <a href="{{URL('admin/dsdonhang-hoanthanh/'.$donhang->id)}}" class="btn btn-success btn-nhapkho">Hoàn thành</a>
                                    @endif
                                    @if ($donhang->trangthai!=0&&$donhang->trangthai!=3)
                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-tt"   aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item " href="{{URL('/admin/dsdonhang-huytrangthai/'.$donhang->id)}}">Hủy trạng thái</a>
                                    </div>
                                    @endif

                                  </div>

                    </div>
                    <div class="col-md-6">
                        @if ($donhang->dathanhtoan==0&&$donhang->ptthanhtoan==1)
                        <a href="{{URL('/admin/dsdonhang-thanhtoan/'.$donhang->id)}}" class="btn btn-info btn-thanhtoan">Đã thanh toán</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <span>Tổng tiền: {{number_format($donhang->tongtien,0,'.','.')}}</span>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
   function updateSanPham(id,sp,size) {
    var strid=String(sp)+String(size);
        console.log(strid);
        // console.log($('#qty-update-'+strid).val());
        $.ajax({
            type: 'GET',
            url: '/admin/dsdonhang-update-sanpham/'+id+'/'+sp+'/'+size+'/'+$('#qty-update-'+strid).val(),
            success: function(data){
                location.reload();
            }
        });
}

     //alert thông báo
  window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);

</script>
@endsection
