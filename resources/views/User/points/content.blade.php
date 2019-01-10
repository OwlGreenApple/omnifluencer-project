@foreach($points as $point)
  <tr>
    <td data-label="Date" align="center">
      <b>
        {{ date("d M Y", strtotime($point->created_at))  }}
      </b>
    </td>
    <td data-label="Description">
      <b>
        {{$point->keterangan}}
      </b>
    </td>
    <td data-label="Points" align="center">
      <?php  
        $dif = $point->poin_after - $point->poin_before;
      ?>
      @if( $dif > 0 )
        <span class="poinplus">
          <b>
            +{{$point->jml_point}} Point
          </b>
        </span>
      @else 
        <span class="poinmin">
          <b>
            -{{$point->jml_point}} Point
          </b>
        </span>
      @endif

    </td>
  </tr>
@endforeach