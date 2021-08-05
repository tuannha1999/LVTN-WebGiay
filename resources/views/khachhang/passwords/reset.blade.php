@extends('layout')
@section('noidung')
@section('title')
Đặt lại mật khẩu
@endsection

<div class="container" >
<br>
<br>
<div class="col-md-12">
<div class="row">
    <div class="col-md-2"></div> 
    <div class="col-md-8">
        @php
            $code=$_GET['code'];
            $email=$_GET['email'];
        @endphp
    <form action="{{ url('/dat-lai-mat-khau') }}" method="post">
    {{ csrf_field() }}
    <br>
    <h4>Đặt lại mật khẩu:</h4>
    <br>
    
                        <input type="hidden" name="email" value="{{$email}}">
                        <input type="hidden" name="code" value="{{$code}}">

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu') }}</label>

                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control" name="password" required >
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nhập lại mật khẩu') }}</label>

                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control" name="password_confirmation" required >
                                @if($errors->has('password'))
                                <div class="text-danger">
                                {{$errors->first('password')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-4 offset-md-5">
                                <button type="submit" class="btn btn-info" >Gửi</button>
                            </div>
                        </div>
    <br>
    </form>
    <br>
    <br>
    </div>
</div>
</div>
</div>

@endsection