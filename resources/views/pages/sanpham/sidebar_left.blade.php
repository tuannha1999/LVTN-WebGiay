<div class="left-sidebar">
    <div class="mt-3">
        <div class="card">
            <div class="card-header">
                <h5>LOẠI SẢN PHẨM</h5>
            </div>
                <div class="card-body">
                    @foreach ($loai_sp as $loai )
                        <div class="card-text">
                            <a href="{{ url('loai-sanpham/'.$loai->slug)}}" class="link">{{$loai->tenloai}}</a>
                        </div>
                    @endforeach
                </div>

        </div>
    </div>
    <div class="mt-3">
        <div class="card">
            <div class="card-header">
                <h5>THƯƠNG HIỆU</h5>
            </div>
                <div class="card-body">
                    @foreach ($thuonghieu as $loai )
                        <div class="list-group list-group-flush">
                            <a href="{{ url('loc-thuonghieu/'.$loai->ten)}}" class="link">{{$loai->ten}}</a>
                        </div>
                    @endforeach
                </div>

        </div>
    </div>

    <div class="mt-3">
        <h5>KHOẢNG GIÁ</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><input type="radio"  name="locgia" value="0" checked > All</li>
            <li class="list-group-item"><input type="radio" name="locgia"  @if(Session::get('locgia')==1) checked @endif value="1"> Giá dưới 1.000.000đ</li>
            <li class="list-group-item"><input type="radio" name="locgia"  @if(Session::get('locgia')==2) checked @endif value="2" > 1.000.000đ - 2.000.000đ</li>
            <li class="list-group-item"><input type="radio" name="locgia"  @if(Session::get('locgia')==3) checked @endif value="3" > 2.000.000đ - 3.000.000đ</li>
            <li class="list-group-item"><input type="radio" name="locgia"  @if(Session::get('locgia')==4) checked @endif value="4" > 3.000.000đ - 4.000.000đ</li>
            <li class="list-group-item"><input type="radio" name="locgia"  @if(Session::get('locgia')==5) checked @endif value="5" > 4.000.000đ - 5.000.000đ</li>
            <li class="list-group-item"><input type="radio" name="locgia"  @if(Session::get('locgia')==6) checked @endif value="6" > Giá trên 5.000.000đ</li>
        </ul>
    </div>
</div>

<script>
    $('input[name="locgia"]:radio').change(function(){
        var gt = document.querySelector('input[name = "locgia"]:checked').value;
            console.log(gt);
            location.replace('/loc-gia-san-pham/'+gt)
    });
</script>
