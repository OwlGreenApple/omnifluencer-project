<?php use App\Account; ?>

@foreach($compares as $compare)
  <tr>
    <td align="center">
      <input type="checkbox" class="checkcompareid" name="compareid[]" value="{{$compare->id}}">
    </td>
    <td data-label="Instagram">
      <?php 
        if(!is_null($compare->account_id_1)){
      ?>       
          {{'@'.$compare->acc1username}}
      <?php  
        }  

        if(!is_null($compare->account_id_2)){
      ?>       
        <i class="fas fa-arrows-alt-h icon-arrow"></i> 
        {{'@'.$compare->acc2username}}
      <?php  
        }

        if(!is_null($compare->account_id_3)){
      ?>
          <i class="fas fa-arrows-alt-h icon-arrow"></i> 
          {{'@'.$compare->acc3username}}          
      <?php  
        }

        if(!is_null($compare->account_id_4)){
      ?>
          <i class="fas fa-arrows-alt-h icon-arrow"></i> 
          {{'@'.$compare->acc4username}}          
      <?php } ?>
    </td>
    <td data-label="Date">
      {{ date("H:i", strtotime($compare->updated_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($compare->updated_at))  }}
    </td> 
    <td data-label="Action">
      <button type="button" class="btn btn-primary btn-profile" data-id="{{$compare->id}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
        <i class="fas fa-file-pdf"></i>
      </button>

      @if(Auth::user()->membership=='premium')
        <button type="button" class="btn btn-primary btn-profile" data-id="{{$compare->id}}" data-type="csv" data-toggle="modal" data-target="#send-file">
          <i class="fas fa-file-excel"></i>
        </button>
      @endif

      <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$compare->id}}">
        <i class="far fa-trash-alt"></i>
      </button>
    </td>
  </tr>
@endforeach