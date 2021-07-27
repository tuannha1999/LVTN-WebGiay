@extends('admin.layout_admin')
@section('home')
<div class="container">
    <div class="mt-2"><a href="{{URL('/admin/dskhuyenmai')}}"><i class="fas fa-2x fa-chevron-left"></i></a></div>
        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2 class="card-title text-center font-weight-bold">CHI TIẾT KHUYẾN MÃI</h2>
            <table class="table">
                <tr>
                    <td>Tên Khuyến mãi:</td>
                    <td>{{$khuyenmai->tenkm}}</td>
                </tr>
                <tr>
                    <td>Tên Khuyến mãi:</td>
                    <td>{{$khuyenmai->tenkm}}</td>
                </tr>
            </table>


        </div>
    </div>

<script src="{{ asset ('/js/jQuery.tagify.min.js') }}"></script>
<script>

//tắt thông báo sau 3s
window.setTimeout(function() {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});
 },4000);
    </script>
@endsection
