<?php use App\Helpers\Helper; ?>
<div align="center">
  <img src="{{$account->prof_pic}}" style="max-width:180px"><br>
  <p><?php echo '@'.$account->username ?></p>
  <p>{{$account->username}}</p>
  <p>
    <span class="counter">
      <?php 
        $eng_rate = $account->eng_rate*100;
        echo $eng_rate;
      ?>    
    </span>
    %
  </p>

</div>

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

<div>
  <?php echo session()->get('account_search') ?>
</div>