<?php use App\Account; ?>

@foreach($compares as $compare)
  <tr>
    <td align="center">
      <input type="checkbox" name="compareid[]" value="{{$compare->id}}">
    </td>
    <td data-label="Instagram">
      <?php  
        $account1 = Account::where('id',$compare->account_id_1)->select('accounts.username')->first();
        $account2 = Account::where('id',$compare->account_id_2)->select('accounts.username')->first();
      ?>

      {{'@'.$account1->username}} 
      <i class="fas fa-arrows-alt-h icon-arrow"></i> 
      {{'@'.$account2->username}}

      <?php 
        if(!is_null($compare->account_id_3)){
          $account3 = Account::where('id',$compare->account_id_3)->select('accounts.username')->first();
      ?>
          <i class="fas fa-arrows-alt-h icon-arrow"></i> 
          {{'@'.$account3->username}}          
      <?php  
        }

        if(!is_null($compare->account_id_4)){
          $account4 = Account::where('id',$compare->account_id_4)->select('accounts.username')->first();
      ?>
          <i class="fas fa-arrows-alt-h icon-arrow"></i> 
          {{'@'.$account4->username}}          
      <?php } ?>
    </td>
    <td data-label="Date">
      {{ date("H:i", strtotime($compare->created_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($compare->created_at))  }}
    </td> 
    <td data-label="Action">
      <button type="button" class="btn btn-primary btn-profile" data-id="{{$compare->id}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
        <i class="fas fa-file-pdf"></i>
      </button>

      <button type="button" class="btn btn-primary btn-profile" data-id="{{$compare->id}}" data-type="csv" data-toggle="modal" data-target="#send-file">
        <i class="fas fa-file-excel"></i>
      </button>

      <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$compare->id}}">
        <i class="far fa-trash-alt"></i>
      </button>
    </td>
  </tr>
@endforeach