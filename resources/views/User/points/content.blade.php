@foreach($points as $point)
  <tr>
    <td align="center">
      {{ date("d M Y", strtotime($point->created_at))  }}
    </td>
    <td>
      {{$point->keterangan}}
    </td>
    <td align="center">
      +{{$point->jml_point}} Point
    </td>
  </tr>
@endforeach