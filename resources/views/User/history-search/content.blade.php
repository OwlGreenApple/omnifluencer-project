@foreach($accounts as $account)
  <tr>
    <td>
      <img src="{{$account->prof_pic}}" style="max-width:50px">
      <?php echo '@'.$account->username ?>
    </td>
    <td>
      {{ date("d F Y", strtotime($account->created_at))  }}
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