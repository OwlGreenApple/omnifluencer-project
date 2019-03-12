<?php use App\Save; 
      use App\Helpers\Helper;
?>

@foreach($accounts as $account)
  <tr>
    <td>
      <input type="checkbox" name="accountid[]" value="{{$account->accountid}}" class="checkaccid" data-id="{{$account->id}}">
      <input type="checkbox" class="checkhisid-{{$account->id}}" name="historyid[]" value="{{$account->id}}" style="display: none;">
    </td>
    <td data-label="Instagram">
      <div class="menu-nomobile">
        <form action="{{url('search')}}" method="POST">
          @csrf
          <input type="hidden" name="keywords" value="{{$account->username}}">

          <img class="menu-nomobile" src="{{$account->prof_pic}}" style="max-width:50px; border-radius:50%;">
          <button class="link-username" type="submit">
            <?php echo '@'.$account->username ?>
          </button>
        </form>
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
    <td class="menu-nomobile" data-label="Eng. Rate">
      <?php 
        $eng_rate = $account->eng_rate*100;
        echo $eng_rate.'%';
      ?> 
    </td>
    <td class="menu-nomobile" data-label="Followers">
      <?php 
        echo Helper::abbreviate_number($account->jml_followers,2)
      ?>
    </td>
    <td class="menu-nomobile" data-label="Posts">
      <?php 
        echo Helper::abbreviate_number($account->jml_post,2)
      ?>
    </td>
    <td class="menu-nomobile" data-label="Groups">
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
    <td class="menu-nomobile" data-label="Date">
      {{ date("H:i", strtotime($account->updated_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($account->updated_at))  }}
    </td> 
    <td data-label="Action">
      <div class="menu-nomobile">
        <button type="button" class="btn btn-sm btn-primary btn-profile" data-id="{{$account->accountid}}" data-type="pdf" data-toggle="modal" data-target="#send-file">
          <i class="fas fa-file-pdf"></i>
        </button>

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
      Eng rate : <b><?php 
                    $eng_rate = $account->eng_rate*100;
                    echo $eng_rate.'%';
                  ?></b><br>
      Followers : <b><?php 
                    echo Helper::abbreviate_number($account->jml_followers,2)
                  ?></b><br>
      Posts : <b><?php 
                echo Helper::abbreviate_number($account->jml_post,2)
              ?></b><br>
      Group : 
      @if($groups->count())
        <span class="tooltipstered txt" title="<?php echo $listgroup ?>">
          <b><?php echo $groups->count().' groups'?></b>
        </span>
      @else 
        <b>-</b>
      @endif
    </td>
    <td>
      Search on : <b>{{date("H:i", strtotime($account->updated_at))}}</b>
      <br>
      <b>{{date("Y/m/d", strtotime($account->updated_at))}}</b>
    </td>
  </tr>
@endforeach