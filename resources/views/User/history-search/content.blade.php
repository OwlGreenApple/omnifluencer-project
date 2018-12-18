<?php use App\Save; ?>

@foreach($accounts as $account)
  <tr>
    <td>
      <input type="checkbox" name="accountid[]" value="{{$account->accountid}}">
    </td>
    <td>
      <img src="{{$account->prof_pic}}" style="max-width:50px">
      <?php echo '@'.$account->username ?>
    </td>
    <td>
      {{ date("d F Y", strtotime($account->created_at))  }}
    </td> 
    <td align="center">
      <?php  
        $groups = Save::join('groups','groups.id','=','saves.group_id')
                    ->select('groups.group_name')
                    ->where('saves.user_id',Auth::user()->id)
                    ->where('saves.account_id',$account->accountid)
                    ->get();

        if($groups->count()){ 
          $listgroup = '';
          foreach ($groups as $group) {
            $listgroup = $listgroup.'- '.$group->group_name.'<br>';
          }
      ?>
          <span class="tooltipstered" title="<?php echo $listgroup ?>">
            <?php echo $groups->count().' groups'?>       
          </span>
      <?php
        } else {
          echo '-';
        }
      ?>
    </td> 
    <td>
      <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}">Delete</button>

      <a href="<?php echo url('history-search/print-pdf').'/'.$account->accountid ?>" target="_blank">
        <button class="btn btn-primary">PDF</button>
      </a>

      <a href="<?php echo url('history-search/print-csv').'/'.$account->accountid ?>" target="_blank">
        <button class="btn btn-primary">CSV</button>
      </a>
    </td>
  </tr>
@endforeach