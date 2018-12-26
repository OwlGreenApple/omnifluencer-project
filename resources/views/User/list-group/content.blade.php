<?php use App\Save; 
      use App\Helpers\Helper;
?>

@foreach($accounts as $account)
  <tr>
    <td align="center">
      <input type="checkbox" name="accountid[]" value="{{$account->accountid}}">
    </td>
    <td>
      <img src="{{$account->prof_pic}}" style="max-width:50px; border-radius:50%;">
      <?php echo '@'.$account->username ?>
    </td>
    <td>
      {{ date("H:i", strtotime($account->created_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($account->created_at))  }}
    </td> 
    <td>
      <a href="<?php echo url('history-search/print-pdf').'/'.$account->accountid ?>" target="_blank">
        <button class="btn btn-primary">
          <i class="fas fa-file-pdf"></i>
        </button>
      </a>

      <a href="<?php echo url('history-search/print-csv').'/'.$account->accountid ?>" target="_blank">
        <button class="btn btn-primary">
          <i class="fas fa-file-csv"></i>
        </button>
      </a>

      <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}">
        <i class="far fa-trash-alt"></i>
      </button>
    </td>
  </tr>
@endforeach