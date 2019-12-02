<form class="form-compare">
  <?php if(!is_null($accounts) && count($accounts) > 0) { ?>

  <div class="col">
    <div class="rowcom"><br><br>
      <!--
      <button type="button" class="btn btn-default btn-compare grads" data-toggle="modal" data-target="#compareModal" data-whatever="compare" style="display: none">
        <span>COMPARE</span>
      </button>
      <button type="button" class="btn btn-default btn-compare grads" data-toggle="modal" data-target="#compareModal" data-whatever="compare" style="display: none">
        <span>DASHBOARD</span>
      </button>
-->
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
        <img src="{{$account->prof_pic}}" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
      </span>
    </div>
    <div class="col-7 colmarg pl-4">
      <span class="username-history" data-id="{{$id}}" style="cursor: pointer;">
        <?php echo $account->username ?>
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
      <div class="rowcom">

        <button type="button" class="btn btn-light btn-md btn-compare">
          <i class="fas fa-sync-alt"></i>&nbsp;COMPARE
        </button>

        <a href="{{url('dashboard')}}">
          <button type="button" class="btn btn-light btn-md btn-dashboard">
            <i class="fas fa-tachometer-alt"></i>
            &nbsp;DASHBOARD
          </button>  
        </a>
        

        <!--
      <button type="button" class="btn btn-default btn-compare grads" data-toggle="modal" data-target="#compareModal" data-whatever="compare" style="display: none">
        <span>COMPARE</span>
      </button>
      <button type="button" class="btn btn-default btn-compare grads" data-toggle="modal" data-target="#compareModal" data-whatever="compare" style="display: none">
        <span>DASHBOARD</span>
      </button>
-->
      </div>
      <!--
          <a id="link-show" href="{{url('history-search')}}">
            <h4>Show More&nbsp;
            <i class="fas fa-chevron-down fa-xs"></i></h4>
          </a>
-->
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