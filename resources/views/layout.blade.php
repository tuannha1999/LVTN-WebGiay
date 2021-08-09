
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
                                <a class="nav-link" href="{{ url('gioi-thieu')}}">GIỚI THIỆU</a>
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
                                         <a class="nav-link" href="{{ url('/profile/{id}' )}}"><i class="fas fa-2x fa-user-check"></i></a>
                                         <ul class="dropdown-menu">
                                             <li>
                                                 <a  class="nav-link" href="{{url('/profile/{id}' )}}">
                                                   {{ Auth::user()->name}}
                                                    <span>({{Auth::user()->phantram*100}}%)</span>
                                                </a>
                                             </li>
                                             <li>
                                                <a  class="nav-link" href="{{url('/lich-su-mua-hang/{id}' )}}">Lịch sử mua hàng</a></a>
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

<!--Container-->
@yield('noidung')

<!--Container-->
<!--Footer-->
    <hr class="my-4">
    <footer>
        <div class="container" >
            <div class="row p-4" >
                <div class="col-md-4 mt-6 p-2">
                    <h5 class="text-uppercase">Liên hệ</h5>
                    <br>
                    <p><i class="far fa-envelope"></i> Email: tuannha1234@gmail.com</p>
                    <p><i class="fas fa-phone"></i> Hotline: 0376440058</p>
                    <p><i class="fas fa-home"></i> Đ/c: 180 Cao Lỗ, P4, Quận 8, Tp HCM</p>
                    <p><i class="fas fa-phone"></i> Điện thoại: 0379307950</p>
                </div>
                <div class="col-md-4 ">
                    <h5 class="text-uppercase"><a class="nav-link text-color" href="{{ url('trang-chu')}}">Trang chủ</a></h5>
                    <ul class="list-unstyled">
                        <li>
                            <a class="nav-link text-color" href="{{ url('gioi-thieu')}}">Giới thiệu</a>
                        </li>
                        <li>
                            <a class="nav-link text-color" href="{{ url('san-pham')}}">Sản phẩm</a>
                        </li>
                        <li>
                            <a class="nav-link text-color" href="{{URL('/form-search-donhang')}}">Tìm kiếm đơn hàng</a>
                        </li>
                        <li>
                            <a class="nav-link text-color" href="{{url('chinh-sach-thanh-vien' )}}">Chính sách thành viên</a>
                        </li>
                        <li>
                            <a class="nav-link text-color" href="{{url('hinh-thuc-thanh-toan' )}}">Hình thức thanh toán</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 mt-3 text-center p-2">
                    <h5 class="text-uppercase">Follow US</h5>
                    <a href="https://www.facebook.com/NT-Store-100183609011131" target="_blank" ><i class="fab fa-facebook-square fa-3x"></i></a>
                    <a href="https://www.instagram.com/taitandinh.99/" target="_blank" ><i class="fab fa-instagram-square fa-3x"></i></a>
                    <a href="https://www.youtube.com/channel/UCoizrIR3iCClVypk23opfyg" target="_blank" ><i class="fab fa-youtube fa-3x"></i></a>
                </div>
            </div>
        </div>
        <!--Coppyright-->
        <hr>
        <div class="text-center " >
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


<div class="zalo-chat-widget" data-oaid="1786243485202090131" 
data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="" data-height=""></div>

<script src="https://sp.zalo.me/plugins/sdk.js"></script>
