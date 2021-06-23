@section('login')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset ('/Bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('/css/style.css') }}">
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
        Đăng nhập ADMIN
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container text-center" >
<br>
<div class="row"> 
  <div class="col-md-4 "></div>
  <div class="col-md-4 bg-dark text-white">
  <br>
  <h2 class="title ">ĐĂNG NHẬP ADMIN</h2>
  <form action="{{ url('/admin') }}" method="post">
  {{ csrf_field() }}
    @if(Session::has('thongbao'))
    <div class="text-danger">{{Session::get('thongbao')}} </div>
    @endif
    <div class="form-group">
    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
        @if($errors->has('email'))
        <div class="text-danger">
        {{$errors->first('email')}}
        </div>
        @endif
    </div>
    <div class="form-group" >
    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
        @if($errors->has('password'))
        <div class="text-danger">
        {{$errors->first('password')}}
        </div>
        @endif
    </div>
    
    <button type="submit" class="btn btn-secondary"  >Đăng nhập</button>
<br>
<br>  
  </form>
   




<!-- /----/ -->
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

<!-- JavaScript -->
</body>
</html>
