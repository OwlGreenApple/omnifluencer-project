<?php use App\Helpers\Helper; 
$count= count($accounts);
?>

@foreach($accounts as $account)
  <div class="col-md-3" align="center">
    <img src="{{$account->prof_pic}}" class="" >
    <br>
    <p class="p1"><?php echo '@'.$account->username ?></p>
    <h5 >{{$account->username}}</h5>
    <p>
      <span class="counter">
        <?php 
          $eng_rate = $account->eng_rate*100;
          echo $eng_rate;
        ?>    
      </span>
      %
    </p>

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
@endforeach
<?php for($i=$count;$i<=4;$i++){ ?>
<div class="col-md-3" align="center">
&nbsp
</div>
<?php } ?>