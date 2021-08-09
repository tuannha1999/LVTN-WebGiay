<!--Header-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="{{ asset ('/Bootstrap/css/bootstrap.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset ('/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('/css/tagify.css') }}">



    <link rel="stylesheet" type="text/css" href="{{ asset ('/fontawesome/css/all.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    ntegrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- khachhang  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"defer ></script>

    <script>
    error=false

    function validate()
    {
    if(document.userForm.name.value !='' && document.userForm.email.value !='' && document.userForm.sdt.value !='')
    document.userForm.btnsave.disabled=false
    else
    document.userForm.btnsave.disabled=true
    }

    function checkEmail()
    {

    }


    </script>



    <!-- khachhang  -->
    <title>
        @yield('title')
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!--Header-->
<nav class="navbar navbar-expand-sm justify-content-center sticky-top ">
    <div class="container ">
        <a class="navbar-brand" href="{{ url('/index' )}}">
        <img src="/img/logo_website.png" height="50">
        </a>

        <div class="row">
            <div class="">
                <ul class="navbar-nav m-xl-auto">
                    <!-- <li class="nav-item">
                    <a class="nav-link" href="{{url('/admin')}}"><i class="fas fa-user fa-2x"></i></a>
                    </li> -->



                            @if (Auth::check())
                            <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('/index' )}}">HI {{ Auth::user()->name}}                   <i class="fas fa-user fa-2x"></i> </a>
                            <ul class="dropdown-menu">

                                <li><a  class="nav-link" href="{{url('/admin/form-change-password' )}}">Đổi mật khẩu</a></li>
                                <li><a  class="nav-link" href="{{url('/logout' )}}">Đăng xuất</a></li>
                            </ul>
                            </li>
                            @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{url('/admin')}}"><i class="fas fa-user fa-2x"></i></a>
                            </li>
                            @endif

                </ul>
            </div>
        </div>

    </div>
</nav>

<!-- sidebar -->
<div class="w3-sidebar w3-bar-block bg-secondary w3-card" style="width:200px;">

  <button class="btn btn-secondary w3-block w3-left-align" onclick="myAccFunc1()">
  Đơn hàng <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc1" class="w3-hide w3-white w3-card">
    <a href="{{ url('/admin/dsdonhang') }}" class="btn w3-bar-item">Danh sách đơn hàng</a>
    <a href="{{ url('/admin/dsphieutra') }}" class="btn w3-bar-item">Trả hàng</a>
  </div>

  <button class="btn btn-secondary w3-block w3-left-align" onclick="myAccFunc()">
  Sản phẩm <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc" class="w3-hide w3-white w3-card">
    <a href="{{ url('/admin/danhsachsanpham') }}" class="btn w3-bar-item">Danh sách sản phẩm</a>
    <a href="{{ url('/admin/khohang') }}" class="btn w3-bar-item">Xem kho hàng</a>
    <a href="{{ url('/admin/dsphieunhap') }}" class="btn w3-bar-item">Nhập hàng</a>
    <a href="{{ url('/admin/dsthuonghieu') }}" class="btn w3-bar-item">Thương hiệu</a>
    <a href="{{ url('/admin/dsloaisanpham') }}" class="btn w3-bar-item">Loại sản phẩm</a>

  </div>

  <a href="{{ url('/admin/dskhachhang') }}" class="btn btn-secondary w3-bar-item">Khách hàng</a>
  <a href="{{ url('/admin/dsnhacungcap') }}" class="btn btn-secondary w3-bar-item">Nhà cung cấp</a>
  <a href="{{ url('/admin/dsbanner') }}" class="btn btn-secondary w3-bar-item">Banner</a>
  <a href="{{ url('/admin/thongke') }}" class="btn btn-secondary w3-bar-item">Thống kê</a>
  <a href="{{ url('/admin/dskhuyenmai') }}" class="btn btn-secondary w3-bar-item">Khuyến mãi</a>

</div>

<div class="w3-container" style="margin-left:200px">
<!-- noidung -->
@yield('home')
<!-- noidung -->

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

<!-- sidebar -->




<!-- /----/ -->
<script type="text/javascript" src="{{asset('/Bootstrap/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{asset('/Bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset ('/Bootstrap/js/jquery-3.6.0.min.js') }}"></script>


<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>


<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

<!-- JavaScript -->
<!-- sidebar -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- sidebar -->

{{-- thư viện moris --}}
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

@stack('scripts')

</body>
</html>
