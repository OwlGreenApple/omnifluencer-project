<form class="form-compare">
  <?php if(!is_null($accounts) && count($accounts)) { ?>

    <div class="col">
      <div class="rowcom">
        <button type="button" class="btn btn-default btn-compare grads" data-toggle="modal" data-target="#compareModal" data-whatever="compare" style="display: none">
          <span>Compare</span>
        </button>
        <h3>Your History Search Result</h3>
      </div>
    </div>

    @foreach($accounts as $account)
      <div class="rowprops d-flex align-items-center">
        <div class="col-1">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="accountid[]" value="{{$account->accountid}}" class="boxcompare" style="display: none">
            </label>
          </div>
        </div>

        <?php 
            $id = null;
            if(Auth::check()){
              $id = $account->accountid;
            } else {
              $id = $account->id;
            }
          ?>
          
        <div class="col-2">
          <span class="username-history" data-id="{{$id}}" style="cursor: pointer;">
            <img class="float-left" src="{{$account->prof_pic}}">
          </span>
        </div>
        <div class="col-7 colmarg">
          <span class="username-history" data-id="{{$id}}" style="cursor: pointer;">
            <?php echo '@'.$account->username ?>    
          </span>
        </div>
        <div class="col-2 colmargbtn">
          <button type="button" class="btn btn-sm btn-link btn-delete" data-id="{{$account->id}}" data-toggle="modal" data-target="#confirm-delete" data-whatever="delete">
            <i class="icon ion-md-close"></i>
          </button>
        </div>
      </div>
    @endforeach     

    @guest 
    @else 
      <div class="row sub-title-btm">
        <div class="col">
          <a id="link-show" href="{{url('history-search')}}">
            <h4>Show More&nbsp;
            <i class="fas fa-chevron-down fa-xs"></i></h4>
          </a>
        </div>
      </div>
    @endguest

    <!--<button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$account->id}}"> 
      Delete 
    </button>-->
    
<?php } else { ?>
  <p style="padding-top: 20px">
    There is no history search
  </p>
<?php } ?>
</form>