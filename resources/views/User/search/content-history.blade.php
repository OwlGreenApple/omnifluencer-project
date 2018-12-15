<?php if(!is_null($accounts) && count($accounts)) { ?>
  
    <button class="btn btn-primary btn-compare" style="display: none">
      Compare
    </button>  
  
  <br>

  @foreach($accounts as $account)
    <input type="checkbox" name="boxcompare" value="{{$account->id}}" class="boxcompare" style="display: none">
    <img src="{{$account->prof_pic}}" style="max-width:50px">
    <?php echo '@'.$account->username ?>
    <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}"> 
      Delete 
    </button>
    <br>
  @endforeach

  <a id="link-show" href="{{url('history-search')}}" style="display: none">
    Show more
  </a>
<?php } else { ?>
  <p>There is no history</p>
<?php } ?>