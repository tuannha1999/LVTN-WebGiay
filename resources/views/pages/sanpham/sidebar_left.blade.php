<div class="left-sidebar">
    <h5>LOẠI SẢN PHẨM</h5>
    <div class="mt-3">
        @foreach ($loai_sp as $loai )
        <div id="accordion">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('loai-sanpham/'.$loai->slug)}}" class="link">{{$loai->tenloai}}</a>
                  <a class="collapsed link-col link" data-toggle="collapse" href="#collapse{{$loai->id}}">
                  </a>
                </div>
                <div id="collapse{{$loai->id}}" class="collapse" data-parent="#accordion">
                  <div class="card-body">

                      <ul class="list-group list-group-flush">
                          @foreach ($thuonghieu as $th)
                             @if ($th->id_lsp==$loai->id)
                                <li class="list-group-item">
                                    <a class="link" href="{{ url('loc-thuonghieu/'.$th->slug)}}">
                                         {{$th->ten}}
                                    </a></li>
                             @endif
                          @endforeach
                        </ul>
                  </div>
                </div>
              </div>
        </div>
        @endforeach
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
