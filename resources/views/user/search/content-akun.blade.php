<?php use App\Helpers\Helper; ?>

<div class="photos">
  <img class="mx-auto d-block" src="{{$account->prof_pic}}" />
</div>
<div class="names">
  <h3><?php echo '@'.$account->username ?></h3>
  <p>{{$account->username}}</p>
</div>

<div class="names">
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

<div class="top-stats">
  <h3><?php echo Helper::abbreviate_number(round($account->total_influenced),2) ?></h3>
  <p>Total Influenced</p>
</div>
<div class="status">
  <div class="row">
    <div class="col-6">
      <p class="number-stat">
        <?php echo Helper::abbreviate_number($account->jml_followers,2); ?>
      </p>
      <p class="desc-stat">Followers</p>
    </div>
    <div class="col-6">
      <p class="number-stat">
        {{ date("M d Y", strtotime($account->lastpost))  }}
      </p>
      <p class="desc-stat">Last Posts</p>
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <p class="number-stat">
        <?php echo Helper::abbreviate_number($account->jml_post,2); ?>
      </p>
      <p class="desc-stat">Posts</p>
    </div>
    <div class="col-6">
      <p class="number-stat">
        <?php echo Helper::abbreviate_number($account->jml_likes,2); ?>
      </p>
      <p class="desc-stat">Avg Like Per Post</p>
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <p class="number-stat">
        <?php echo Helper::abbreviate_number($account->jml_following,2); ?>
      </p>
      <p class="desc-stat">Following</p>
    </div>
    <div class="col-6">
      <p class="number-stat">
        <?php echo Helper::abbreviate_number($account->jml_comments,2); ?>
      </p>
      <p class="desc-stat">Avg Comment Per Post</p>
    </div>
  </div>
</div>

<script>
var distance = $('#div-progress').offset().top * 25/100,
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




