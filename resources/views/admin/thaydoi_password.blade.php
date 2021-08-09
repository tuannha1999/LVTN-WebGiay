@extends('admin.layout_admin')
@section('home')
<div class="mt-5">
    <div class="col-md-12">
                 <div class="mt-2"><a href="{{URL('index')}}" ><i class="fas fa-2x fa-chevron-left"></i></a></div>

                 @if (session('error'))
                 <div class="alert alert-danger">
                     {{ session('error') }}
                 </div>
                  @endif
                 @if (session('success'))
                     <div class="alert alert-success">
                         {{ session('success') }}
                     </div>
                 @endif
                 <h2 class="card-title">Thay đổi password</h2>
                 </div>
                 <div class="mt-4">
                     <div class="container-fluid ">
                         <form action="{{URL('/admin/change-password')}}" method="POST">
                             @csrf
                             <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                 <label for="new-password" class="col-md-4 control-label">Mật khẩu hiện tại</label>

                                 <div class="col-md-6">
                                     <input id="current-password" type="password" class="form-control" name="current-password" required>
                                     @if($errors->has('current-password'))
                                     <div class="text-danger">
                                     {{$errors->first('current-password')}}
                                     </div>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                 <label for="new-password" class="col-md-4 control-label">Mật khẩu mới</label>

                                 <div class="col-md-6">
                                     <input id="new-password" type="password" class="form-control" name="new-password" required>
                                     @if($errors->has('new-password'))
                                     <div class="text-danger">
                                     {{$errors->first('new-password')}}
                                     </div>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group">
                                 <label for="new-password-confirm" class="col-md-4 control-label">Nhập lại mật khẩu mới</label>

                                 <div class="col-md-6">
                                     <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                 </div>
                             </div>

                             <div class="form-group">
                                 <div class="col-md-6 col-md-offset-4">
                                     <button type="submit" class="btn btn-primary">
                                         Thay đổi
                                     </button>
                                 </div>
                             </div>
                         </form>
                           </form>

            </div>
        </div>
</div>

<script>
     setTimeout(function(){
        $('.alert').hide('');
        }, 3000);;
</script>

@endsection
