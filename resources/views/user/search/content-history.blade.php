<?php if(!is_null($accounts) && count($accounts)) { ?>

    <div class="col">
      <div class="rowcom">
        <button type="submit" class="btn btn-default btn-compare grads" data-toggle="modal" data-target="#compareModal" data-whatever="compare" style="display: none">
          <span>Compare</span>
        </button>
        <h3>Here is your search history</h3>
      </div>
    </div>

    @foreach($accounts as $account)
      <div class="rowprops d-flex align-items-center">
        <div class="col-1">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="boxcompare" value="{{$account->id}}" class="boxcompare" style="display: none">
            </label>
          </div>
        </div>
        <div class="col-2">
          <img class="float-left" src="{{$account->prof_pic}}">
        </div>
        <div class="col-7 colmarg">
          <span>
            <?php echo '@'.$account->username ?>    
          </span>
        </div>
        <div class="col-2 colmargbtn">
          <button type="submit" class="btn btn-sm btn-link btn-delete" data-id="{{$account->id}}" data-toggle="modal" data-target="#confirm-delete" data-whatever="delete">
            <i class="icon ion-md-close"></i>
          </button>
        </div>
      </div>
    @endforeach     

    <div class="row sub-title-btm">
      <div class="col">
        <a id="link-show" href="{{url('history-search')}}" style="display: none">
          <h4>Show More&nbsp;
          <i class="fas fa-chevron-down fa-xs"></i></h4>
        </a>
      </div>
    </div>

    <!--<button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}"> 
      Delete 
    </button>-->
    
<?php } else { ?>
  <p>There is no history</p>
<?php } ?>