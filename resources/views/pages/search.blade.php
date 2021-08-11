@extends('layout')
@section('noidung')
<hr class="my-4">
<div class="container">
    <div> <h3>Tìm thấy {{ $count = count($search) }} Kết quả</h3> </div>
    <hr>
	<div class="row">
	            	@foreach($search as $value)
	            	<div class="col-md-3 col-sm-6">
	                <div class="productinfo text-center">
                        <a href="{{ url('chitiet-sanpham/'.$value->id)}}" class="link">
                            @foreach ($value->Hinhanh as $img )
                            @if ($img->avt==1)
                                    <img class="card-img-top" src="{{asset ('storage/'.$img->name) }}" alt="Card image">
                            @endif
                            @endforeach
                            <div class="card-body">
                                @php
                                $total=0;
                                 foreach ($value->size as $size)
                                 {
                                     $total+=$size->soluong;
                                 }
                                     if ($total==0) {
                                         echo '<h5 class="card-title text-danger" >[HẾT HÀNG]</h5>';
                                     }
                                 @endphp
                              <h4 class="card-title">{{$value->tensp}}</h4>
                        </a>
						    <p class="text-danger">{{ number_format($value->giaban,0,'.','.').' '.'đ' }}</p>
						</div>
					</div>
		</div>
		@endforeach
</div>
</div>
@endsection
