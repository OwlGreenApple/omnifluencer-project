@foreach($points as $point)
  <tr>
    <td data-label="Date" align="center">
      {{ date("d M Y", strtotime($point->created_at))  }}
    </td>
    <td data-label="Description">
      {{$point->keterangan}}
    </td>
    <td data-label="Points" align="center">
      +{{$point->jml_point}} Point
    </td>
  </tr>
@endforeach