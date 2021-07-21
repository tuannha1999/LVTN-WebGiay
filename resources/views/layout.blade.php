
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

    <link rel="stylesheet" type="text/css" href="{{ asset ('/fontawesome/css/all.css') }}">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    ntegrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>
        @yield('title')
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<!--Header-->
    <nav class="navbar navbar-expand-sm justify-content-center sticky-top ">

    <div class="container "  >
                <a class="navbar-brand" href="{{ url('/')}}">
                    <img src="/img/logo_website.png" height="50">
                </a>
                <div class="row">
                    <div class="">
                        <ul class="navbar-nav m-xl-auto">
                            <li class="nav-item ">
                                <a class="nav-link " href="{{ url('trang-chu')}}">TRANG CHỦ</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#">GIỚI THIỆU</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ url('san-pham')}}">SẢN PHẨM</a>
                                <ul class="dropdown-menu">
                                    @foreach ($loai_sp as $item)
                                    <li><a  class="nav-link" href="{{ url('loai-sanpham/'.$item->slug)}}">{{$item->tenloai}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL('/form-search-donhang')}}">TÌM KIẾM ĐƠN HÀNG</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group">
                            <button class="btn btn-primary-outline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            type="button"><img src="https://theme.hstatic.net/1000324393/1000429977/14/pic-search.png?v=1231" alt="">
                           </button>
                           <div class="dropdown-menu dropdown-menu-right" style="width: 300px;">
                               <form  class="search-fr" action="{{ url('search')}}" method="GET">
                                   <input class="form-control mr-sm-2" type="text" name="search" id="search" required="required" placeholder="Tìm kiếm...">
                                   <button style="outline: 0;" type="submit"><i class="fas fa-search"></i></button>
                               </form>
                            </div>
                      </div>
                        <ul class="navbar-nav m-xl-auto">


                            @if (Auth::check())
                                @if(Auth::user()->is_admin==1)
                                    <li class="nav-item">
                            		<a class="nav-link" href="{{url('/dangnhap')}}"><i class="fas fa-user fa-2x"></i></a>
                            	    </li>
                                @else(Auth::user()->is_admin==0)
                                    <li class="nav-item dropdown">
                                         <a class="nav-link" href="{{ url('/profile' )}}"><i class="fas fa-2x fa-user-check"></i></a>
                                         <ul class="dropdown-menu">
                                             <li>
                                                 <a  class="nav-link" href="{{url('/profile' )}}">
                                                   {{ Auth::user()->name}}
                                                    @if (Auth::user()->level==1)
                                                        <span>(5%)</span>
                                                    @elseif(Auth::user()->level==2)
                                                        <span>(6%)</span>
                                                    @elseif(Auth::user()->level==3)
                                                        <span>(7%)</span>
                                                    @elseif(Auth::user()->level==4)
                                                        <span>(8%)</span>
                                                    @elseif(Auth::user()->level==5)
                                                        <span>(9%)</span>
                                                    @elseif(Auth::user()->level==6)
                                                        <span>(10%)</span>
                                                    @else
                                                        <span>(0%)</span>
                                                    @endif
                                                </a>
                                             </li>
                                             <li>
                                                <a  class="nav-link" href="{{url('/profile' )}}">Lịch sử mua hàng</a></a>
                                            </li>
                                             <li>
                                                <a  class="nav-link" href="{{url('chinh-sach-thanh-vien' )}}">Ưu đãi thành viên</a>
                                            </li>
                                             <li>
                                                 <a  class="nav-link" href="{{url('/dangxuat' )}}">Đăng xuất</a>
                                             </li>
                                         </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link cart-head" style="position:relative;" href="{{url('yeuthich')}}">
                                            <i class="fas fa-2x fa-heart"></i>
                                            <span class="hd-cart-count">{{Auth::user()->yeuthich}}</span>
                                        </a>
                                    </li>
                                @endif
                            @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{url('/dangnhap')}}"><i class="fas fa-user fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  href="{{url('/dangnhap')}}"><i class="fas fa-2x fa-heart"></i>
                                </a>
                            </li>
                            @endif


                            <li class="nav-item">
                                <a class="nav-link cart-head" style="position:relative;" href="{{URL('cart')}}">
                                    <i class="fas fa-shopping-bag fa-2x" ></i>
                                    @if (Cart::count()>0)
                                    <span id="total-quanty-show" class="hd-cart-count">{{Cart::count()}}</span>
                                    @else
                                    <span id="total-quanty-show"  class="hd-cart-count">0</span></i>
                                    @endif
                                </a>
                            </li>
                        </ul>
                </div>
    </div>
</nav>
<!--Header-->
<!-- khachhang -->
@yield('dangki')
@yield('dangnhap')
@yield('profile')

<!-- khachhang -->
<!--Container-->
@yield('noidung')

<!--Container-->
<!--Footer-->
    <hr class="my-4">
    <footer>
        <div class="container" >
            <div class="row p-4" >
                <div class="col-md-4 mt-3 p-2">
                    <h5 class="text-uppercase">Liên hệ</h5>
                    <p><i class="far fa-envelope"></i> Email: tuannha1234@gmail.com</p>
                    <p><i class="fas fa-phone"></i> Hotline: 0376440058</p>
                    <p><i class="fas fa-home"></i> Đ/c: 180 Cao Lỗ, P4, Quận 8, Tp HCM</p>
                    <p><i class="fas fa-phone"></i> Điện thoại: 0379307950</p>
                </div>
                <div class="col-md-4 mt-3">
                    <h5 class="text-uppercase"><a class="nav-link text-color" href="#">Trang chủ</a></h5>
                    <ul class="list-unstyled">
                        <li>
                            <a class="nav-link text-color" href="#">Giới thiệu</a>
                        </li>
                        <li>
                            <a class="nav-link text-color" href="#">Sản phẩm</a>
                        </li>
                        <li>
                            <a class="nav-link text-color" href="#">Tìm kiếm đơn hàng</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 mt-3 text-center p-2">
                    <h5 class="text-uppercase">Follow US</h5>
                    <a href="#"><i class="fab fa-facebook-square fa-3x"></i></a>
                    <a href="#"><i class="fab fa-instagram-square fa-3x"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-3x"></i></a>
                </div>
            </div>
        </div>
        <!--Coppyright-->
        <hr>
        <div class="text-center p-2" >
        © Bản quyền thuộc về Tuấn Nhã - Tấn Tài | D17_TH06
      </div>
      <!--Coppyright-->
    </footer>
<!--Footer-->
<script type="text/javascript" src="{{asset('/Bootstrap/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{asset('/Bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset ('/Bootstrap/js/jquery-3.6.0.min.js') }}"></script>



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

{{-- <div class="zalo-chat-widget" data-oaid="579745863508352884"
data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="3" data-width="350" data-height="420"></div>

<script src="https://sp.zalo.me/plugins/sdk.js"></script> --}}
<!-- Messenger Plugin chat Code -->
<!-- Messenger Plugin chat Code -->
{{-- <div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "101987398844589");
  chatbox.setAttribute("attribution", "biz_inbox");

  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v11.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script> --}}
</body>
</html>
