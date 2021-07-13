
        @foreach ($sanpham as $sp)
        <tr>
                <td >{{$sp->id}}</td>
                <td >{{$sp->tensp}}</td>
                <td >{{$sp->id}}</td>
                <td >
                    <input type="number" value="1" min="1">
                </td>
                <td >{{$sp->id}}</td>
                <td ><a href="#" class="btn btn-outline-danger">Chọn</a></td>

        </tr>
        @endforeach
