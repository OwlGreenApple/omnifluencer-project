@php
$no = 1;
@endphp
@foreach($data as $row)
  <tr>
    <td>{{$no}}</td>
    <td>{{$row['content']['account_number']}}</td>
    <td>
        @if($row['isexecute'] == 0)
            Gagal
        @else
            Berhasil    
        @endif
    </td>
    <td>{{$row['created']}}</td>
    <td>{{$row['updated']}}</td>
    <td><a class="btn btn-warning btn-sm detail" data-toggle="modal" data-target="#details" id="{{$row['id']}}">Details</a></td>
  </tr>   
@php
$no++
@endphp
@endforeach