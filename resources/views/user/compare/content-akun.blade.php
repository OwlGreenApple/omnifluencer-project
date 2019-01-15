<?php use App\Helpers\Helper; 
$count= count($accounts);
?>

@foreach($accounts as $account)
  <div class="col-md-3 col-6 div-progress" align="center">
    <img src="{{$account->prof_pic}}" class="" >
    <br>
    <p class="p1"><?php echo '@'.$account->username ?></p>
    <h5 class="username">{{$account->username}}</h5>

    <div class="names mb-4">
      <div class="progress blue">
        <span class="progress-left">
          <span class="progress-bar"></span>
        </span>
        <span class="progress-right">
          <span class="progress-bar"></span>
        </span>
        <div class="progress-value">
          <span class="counter">
            <?php echo round($account->eng_rate*100,2) ?>
          </span>% <br>
          Engagement Rate
        </div>
      </div>
    </div>

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
    <br>
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

@if(Auth::user()->membership=='pro')
  <?php for($i=$count;$i<2;$i++){ ?>
    <div class="col-md-3" align="center">
      &nbsp
    </div>
  <?php } ?>
@elseif (Auth::user()->membership=='premium')
  <?php for($i=$count;$i<=4;$i++){ ?>
    <div class="col-md-3" align="center">
      &nbsp
    </div>
  <?php } ?>
@endif

<script>
  var distance = $('.div-progress').offset().top * 25/100,
      $window = $(window);
  function check_loading(){
    // console.log($window.scrollTop());
    // console.log(distance);
      if ( $window.scrollTop() >= distance ) {
        // console.log("www");
              $('.progress.blue .progress-left .progress-bar').css({
                animation: "loading-1 0.6s linear forwards 0.6s",
                opacity: "1"
              });
              $('.progress .progress-right .progress-bar').css({
                animation: "loading-1 0.5s linear forwards",
                opacity: "1"
              });
      }
  }
  check_loading();
  $window.scroll(function() {
    check_loading();
  });
</script>