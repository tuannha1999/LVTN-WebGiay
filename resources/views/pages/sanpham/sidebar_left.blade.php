<div class="left-sidebar">
    <h5>DANH MỤC SẢN PHẨM</h5>
    <div class="mt-3">
        @foreach ($danhmuc as $value )
        @if ($value->loaidm==0)
        <div id="accordion">
            <div class="card">
                <div class="card-header">
                  <a class="collapsed link" data-toggle="collapse" href="#collapse{{$value->madm}}">
                        {{$value->tendm}}
                  </a>
                </div>
                <div id="collapse{{$value->madm}}" class="collapse" data-parent="#accordion">
                  <div class="card-body">

                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a class="link" href="#">{{$value->tendm}}</a></li>
                    </ul>

                  </div>
                </div>
              </div>
        </div>
        @endif
        @endforeach
    </div>
    <div class="mt-3">
        <h5>KHOẢNG GIÁ</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><input value="3" type="checkbox"> Giá dưới 1.000.000đ</li>
            <li class="list-group-item"><input type="checkbox" > 1.000.000đ - 2.000.000đ</li>
            <li class="list-group-item"><input type="checkbox" > 2.000.000đ - 3.000.000đ</li>
            <li class="list-group-item"><input type="checkbox" > 3.000.000đ - 4.000.000đ</li>
            <li class="list-group-item"><input type="checkbox" > 4.000.000đ - 5.000.000đ</li>
            <li class="list-group-item"><input type="checkbox" > Giá trên 5.000.000đ</li>
        </ul>
    </div>
</div>
