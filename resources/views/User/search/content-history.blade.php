<?php if(!is_null($accounts) && $accounts->count()) { ?>
  @foreach($accounts as $account)
    <img src="{{$account->prof_pic}}" style="max-width:50px">
    <?php echo '@'.$account->username ?>
    <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}"> 
      Delete 
    </button>
    <br>
  @endforeach
<?php } else { ?>
  <p>There is no history</p>
<?php } ?>