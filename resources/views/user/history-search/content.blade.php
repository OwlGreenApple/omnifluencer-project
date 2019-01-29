<?php use App\Save; 
      use App\Helpers\Helper;
?>

@foreach($accounts as $account)
  <tr>
    <td align="center">
      <input type="checkbox" name="accountid[]" value="{{$account->accountid}}" class="checkaccid" data-id="{{$account->id}}">
      <input type="checkbox" class="checkhisid-{{$account->id}}" name="historyid[]" value="{{$account->id}}" style="display: none;">
    </td>
    <td data-label="Instagram">
      <form action="{{url('search')}}" method="POST">
        @csrf
        <input type="hidden" name="keywords" value="{{$account->username}}">

        <img src="{{$account->prof_pic}}" style="max-width:50px; border-radius:50%;">
        <button class="link-username" type="submit">
          <?php echo '@'.$account->username ?>
        </button>

      </form>
    </td>
    <td data-label="Eng. Rate">
      <?php 
        $eng_rate = $account->eng_rate*100;
        echo $eng_rate.'%';
      ?> 
    </td>
    <td data-label="Followers">
      <?php 
        echo Helper::abbreviate_number($account->jml_followers,2)
      ?>
    </td>
    <td data-label="Posts">
      <?php 
        echo Helper::abbreviate_number($account->jml_post,2)
      ?>
    </td>
    <td data-label="Groups">
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
    <td data-label="Date">
      {{ date("H:i", strtotime($account->updated_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($account->updated_at))  }}
    </td> 
    <td data-label="Action">
      
      @if(Auth::user()->membership=='premium' or Auth::user()->membership=='pro')      
        <button type="button" class="btn btn-primary btn-profile" data-id="{{$account->accountid}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
        <i class="fas fa-file-pdf"></i>
        </button>
      @endif

      @if(Auth::user()->membership=='premium')
        <button type="button" class="btn btn-primary btn-profile" data-id="{{$account->accountid}}" data-type="csv" data-toggle="modal" data-target="#send-file">
          <i class="fas fa-file-excel"></i>
        </button>
      @endif
      
      <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}">
        <i class="far fa-trash-alt"></i>
      </button>  
    </td>
  </tr>
@endforeach