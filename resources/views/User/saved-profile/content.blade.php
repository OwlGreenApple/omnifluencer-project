<?php use App\Save; 
      use App\Helpers\Helper;
?>

@foreach($accounts as $account)
  <tr>
    <td align="center">
      <input type="checkbox" name="accountid[]" value="{{$account->accountid}}">
    </td>
    <td data-label="Instagram">
      <img src="{{$account->prof_pic}}" style="max-width:50px; border-radius:50%;">
      <?php echo '@'.$account->username ?>
    </td>
    <td data-label="Saved Date">
      {{ date("H:i", strtotime($account->created_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($account->created_at))  }}
    </td> 
    <td data-label="Groups" align="center">
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
          <span class="tooltipstered txt" title="<?php echo $listgroup ?>">
            <?php echo $groups->count().' groups'?>       
          </span>
      <?php
        } else {
          echo '-';
        }
      ?>
    </td> 
    <td data-label="Action">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#send-file">
        <i class="fas fa-file-pdf"></i>
      </button>

      <a href="<?php echo url('history-search/print-csv').'/'.$account->accountid ?>" target="_blank">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#send-file">
          <i class="fas fa-file-csv"></i>
        </button>
      </a>

      <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}">
        <i class="far fa-trash-alt"></i>
      </button>
    </td>
  </tr>
@endforeach