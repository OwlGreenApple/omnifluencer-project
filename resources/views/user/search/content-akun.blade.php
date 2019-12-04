<?php use App\Helpers\Helper; ?>

<div class="photos">
  <img class="mx-auto d-block" src="{{$account->prof_pic}}" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
</div>
<div class="names">
  <h3><?php echo '@'.$account->username ?></h3>
  <p>{{$account->fullname}}</p>
</div>

<div class="col-md-12 names">
  <div class="row">
      <div class="col-md-6">
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
            </div>
          </div>
          <h5 class="mt-3">Engagement Rate</h5>

          <div class="status">
              <p class="top-stat">
                 <?php echo Helper::abbreviate_number(round($account->total_influenced),2) ?>
              </p>
              <p class="desc-stat">Total Influenced</p>
            <div class="row">
              <div class="col-md-6">
                  <p class="number-stat">
                    <?php echo Helper::abbreviate_number($account->jml_followers,2); ?>
                  </p>
                  <p class="desc-stat">Followers</p>
              </div>
              <div class="col-md-6">
                  <p class="number-stat">
                    @if(is_null($account->lastpost))
                      -
                    @else 
                      {{ date("M d Y", strtotime($account->lastpost))  }}
                    @endif
                  </p>
                  <p class="desc-stat">Last Posts</p>
              </div> 
              <div class="col-md-6">
                  <p class="number-stat">
                    <?php echo Helper::abbreviate_number($account->jml_post,2); ?>
                  </p>
                  <p class="desc-stat">Posts</p>
              </div> 
              <div class="col-md-6">
                  <p class="number-stat">
                    <?php echo Helper::abbreviate_number($account->jml_likes,2); ?>
                  </p>
                  <p class="desc-stat">Avg Like Per Post</p>
              </div> 
              <div class="col-md-6">
                  <p class="number-stat">
                    <?php echo Helper::abbreviate_number($account->jml_following,2); ?>
                  </p>
                  <p class="desc-stat">Following</p>
              </div> 
              <div class="col-md-6">
                  <p class="number-stat">
                    <?php echo Helper::abbreviate_number($account->jml_comments,2); ?>
                  </p>
                  <p class="desc-stat">Avg Comment Per Post</p>
              </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="progress blue">
            <span class="progress-left">
              <span class="progress-bar"></span>
            </span>
            <span class="progress-right">
              <span class="progress-bar"></span>
            </span>
            <div class="progress-value">
              <span class="counter">
                <?php echo round($account->video_view_rate) ?>
              </span>% <br>
            </div>
          </div>
          <h5 class="mt-3">Video View Rate</h5>

          <div class="status">
            <p class="number-stat">
              <?php echo Helper::abbreviate_number($account->jmlvideoview,2); ?>
            </p>
            <p class="desc-stat">Total Video Views</p> 

            <p class="number-stat">
              <?php $avgvideoview = $account->jmlvideoview/12; echo Helper::abbreviate_number($avgvideoview,2); ?>
            </p>
            <p class="desc-stat">Avg Video Views</p>
          </div>
      </div>

  </div>
</div>

<!--
<div class="top-stats">
  <h3><php echo Helper::abbreviate_number(round($account->total_influenced),2) ?></h3>
  <p>Total Influenced</p>
</div>
-->

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




