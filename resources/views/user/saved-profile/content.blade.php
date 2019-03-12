<?php use App\Save; 
      use App\Helpers\Helper;
?>

@foreach($accounts as $account)
  <tr>
    <td>
      <input type="checkbox" name="accountid[]" value="{{$account->accountid}}" class="checkaccid" data-id="{{$account->id}}">

      <input type="checkbox" class="checksaveid-{{$account->id}}" name="saveid[]" value="{{$account->id}}" style="display: none;">
    </td>
    <td data-label="Instagram">
      <div class="menu-nomobile">
        <img src="{{$account->prof_pic}}" style="max-width:50px; border-radius:50%;">
        <?php echo '@'.$account->username ?>
      </div>
      
      <div class="menu-mobile">
        <div class="view-details" data-id="{{$account->id}}">
          <span class="menu-mobile" style="display: inline-block; float: right;">
            <i class="fas fa-sort-down"></i>
          </span>
          <?php echo '@'.$account->username ?>  
        </div>
      </div>
      
    </td>
    <td data-label="Saved Date" class="menu-nomobile">
      {{ date("H:i", strtotime($account->created_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($account->created_at))  }}
    </td> 
    <td data-label="Groups" class="menu-nomobile">
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
      <div class="menu-nomobile">
        @if(Auth::user()->membership=='pro' or Auth::user()->membership=='premium')
          <button type="button" class="btn btn-sm btn-primary btn-profile" data-id="{{$account->accountid}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
            <i class="fas fa-file-pdf"></i>
          </button>
        @endif

        @if(Auth::user()->membership=='premium')
          <button type="button" class="btn btn-sm btn-primary btn-profile" data-id="{{$account->accountid}}" data-type="csv" data-toggle="modal" data-target="#send-file">
            <i class="fas fa-file-excel"></i>
          </button>
        @endif

        <button type="button" class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}">
          <i class="far fa-trash-alt"></i>
        </button>  
      </div>

      <div class="menu-mobile">
        <span class="menu-savepdf btn-profile" data-id="{{$account->accountid}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
          Save PDF 
        </span>

        |

        <span class="menu-delete btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}">
          Delete
        </span>  
      </div>
    </td>
  </tr>

  <tr class="details-{{$account->id}} d-none">
    <td></td>
    <td>
      Group : 
      @if($groups->count())
        <span class="tooltipstered txt" title="<?php echo $listgroup ?>">
          <?php echo $groups->count().' groups'?>
        </span>
      @else 
        <b>-</b>
      @endif
    </td>
    <td>
      Saved on : <b>{{date("H:i", strtotime($account->created_at))}}</b>
      <br>
      <b>{{date("Y/m/d", strtotime($account->created_at))}}</b>
    </td>
  </tr>
@endforeach