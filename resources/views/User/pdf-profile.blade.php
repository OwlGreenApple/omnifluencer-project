<?php use App\Helpers\Helper; ?>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

<?php if(is_array($account)) { 
        foreach ($account as $acc) {
?>
  <div class="col-md-12" align="center">
    <img src="{{$acc->prof_pic}}" style="max-width: 150px"><br>
    <?php echo '@'.$acc->username ?> <br>

    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-4">
        <h4>
          <b><?php echo Helper::abbreviate_number($acc->jml_post,2); ?></b>
        </h4>
        <h5>Post</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($acc->jml_followers,2); ?></b>
        </h4>
        <h5>Followers</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($acc->jml_following,2); ?></b>
        </h4>
        <h5>Following</h5>
      </div>

      <div class="col-md-4">
        <h4>
          <b>{{ date("M d Y", strtotime($acc->lastpost))  }}</b>
        </h4>
        <h5>Last Post</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($acc->jml_likes,2); ?></b>
        </h4>
        <h5>Avg Like Per Post</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($acc->jml_comments,2); ?></b>
        </h4>
        <h5>Avg Comment Per Post</h5>
      </div>
    </div>
  </div>
<?php } 
    } else { ?>
  <div class="col-md-12" align="center">
    <img src="{{$account->prof_pic}}" style="max-width: 150px"><br>
    <?php echo '@'.$account->username ?> <br>

    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-4">
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_post,2); ?></b>
        </h4>
        <h5>Post</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_followers,2); ?></b>
        </h4>
        <h5>Followers</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_following,2); ?></b>
        </h4>
        <h5>Following</h5>
      </div>

      <div class="col-md-4">
        <h4>
          <b>{{ date("M d Y", strtotime($account->lastpost))  }}</b>
        </h4>
        <h5>Last Post</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_likes,2); ?></b>
        </h4>
        <h5>Avg Like Per Post</h5>
        <br>
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_comments,2); ?></b>
        </h4>
        <h5>Avg Comment Per Post</h5>
      </div>
    </div>
  </div>
<?php } ?>
