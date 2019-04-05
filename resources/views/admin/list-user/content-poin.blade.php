@foreach($points as $point)
  <tr>
    <td data-label="Poin Before">
      {{$point->poin_before}}
    </td>
    <td data-label="Poin After">
      {{$point->poin_after}}
    </td>
    <td data-label="Jumlah Poin">
      {{$point->jml_point}}
    </td> 
    <td data-label="Keterangan">
      {{$point->keterangan}}
    </td>
    <td data-label="Created At">
      {{$point->created_at}}
    </td>
  </tr>
@endforeach