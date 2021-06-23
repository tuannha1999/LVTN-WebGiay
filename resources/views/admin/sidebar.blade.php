@section('sidebar')
<div class="w3-sidebar w3-bar-block bg-secondary w3-card" style="width:200px;">

  <button class="btn btn-secondary w3-block w3-left-align" onclick="myAccFunc1()">
  Đơn hàng <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc1" class="w3-hide w3-white w3-card">
    <a href="#" class="btn w3-bar-item">Danh sách đơn hàng</a>
    <a href="#" class="btn w3-bar-item">Trả hàng</a>
  </div>

  <button class="btn btn-secondary w3-block w3-left-align" onclick="myAccFunc()">
  Sản phẩm <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc" class="w3-hide w3-white w3-card">
    <a href="{{ url('/danhsachsanpham') }}" class="btn w3-bar-item">Danh sách sản phẩm</a>
    <a href="#" class="btn w3-bar-item">Quản lý kho</a>
    <a href="#" class="btn w3-bar-item">Nhập hàng</a>
    <a href="#" class="btn w3-bar-item">Danh mục</a>
  </div>

  <a href="#" class="btn btn-secondary w3-bar-item">Khách hàng</a>
  <a href="#" class="btn btn-secondary w3-bar-item">Nhà cung cấp</a>
  <a href="#" class="btn btn-secondary w3-bar-item">Khuyến mãi</a>

</div>

<div class="w3-container" style="margin-left:200px">
@yield('home')
@yield('danhsachsanpham')

</div>

<script>
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-light-blue";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-light-blue", "");
  }
}
function myAccFunc1() {
  var x = document.getElementById("demoAcc1");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-light-blue";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-light-blue", "");
  }
}
</script>
@endsection


