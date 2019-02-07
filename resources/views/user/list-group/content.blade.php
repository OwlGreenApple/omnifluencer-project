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
      <img src="{{$account->prof_pic}}" style="max-width:50px; border-radius:50%;">
      <?php echo '@'.$account->username ?>
    </td>
    <td data-label="Date">
      {{ date("H:i", strtotime($account->created_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($account->created_at))  }}
    </td> 
    <td data-label="Action">
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
    </td>
  </tr>
@endforeach