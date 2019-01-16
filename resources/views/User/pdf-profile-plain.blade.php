<?php use App\Helpers\Helper; ?>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

<?php if(is_array($account)) { 
        foreach ($account as $acc) {
?>
  <div class="page">
    <div id="bg-page">
      <img src="{{asset('design/new-bg.jpg')}}">
    </div>

    <div class="col-xs-12 logo" align="center">
      <img src="{{asset('design/logobrand.png')}}">
    </div>
    <br>

    <div class="col-xs-12" align="center">
      <img class="profpic" src="{{$acc->prof_pic}}">
      <br>
    </div>
    
    <div class="col-xs-12 info" align="center">
      <span class="saved-on">
        saved on : {{ date("d F Y") }}
      </span>
      <span class="username">
        <?php echo '@'.$acc->username ?>
      </span> <br>
      <span class="name">
        {{$acc->username}}
      </span> <br>
      
      <div style="margin-top:50px; margin-bottom: 50px;">
        <div class="col-xs-6 inline engrate">
          <img class="engrate-circle" src="{{asset('design/engrate-circle.png')}}" style="width: 100%;">
          <div class="engrate-txt">
            <span class="info-value">
              <?php $engrate = $acc->eng_rate*100 ?>
              <b>{{round($engrate,2)}}</b>%
            </span><br>
            <span class="info-label">Engagement<br>Rate</span>
          </div>
        </div>

        <div class="col-xs-6 inline engrate">
          <div class="engrate-txt">
            <span class="info-value">
              <b>
                <?php echo Helper::abbreviate_number(round($acc->eng_rate*$acc->jml_followers),2) ?>  
              </b>
            </span><br>
            <span class="info-label">
              Total Influenced
            </span>
          </div>
        </div>
      </div>

      <div>
        <div class="col-xs-4 info-box inline">
          <span class="info-value">
            <b><?php echo Helper::abbreviate_number($acc->jml_post,2); ?></b>
          </span><br>
          <span class="info-label">Total Posts</span>
        </div>

        <div class="col-xs-4 info-box inline">
          <span class="info-value">
            <b><?php echo Helper::abbreviate_number($acc->jml_followers,2); ?></b>
          </span><br>
          <span class="info-label">Followers</span>
        </div>

        <div class="col-xs-4 info-box inline">
          <span class="info-value">
            <b><?php echo Helper::abbreviate_number($acc->jml_following,2); ?></b>
          </span><br>
          <span class="info-label">Following</span>
        </div>
      </div>

      <div>
        <div class="col-xs-4 info-box inline">
          <span class="info-value">
            <b>{{ date("M d Y", strtotime($acc->lastpost))  }}</b>
          </span><br>
          <span class="info-label">Last Post</span>
        </div>

        <div class="col-xs-4 info-box inline">
          <span class="info-value">
            <b><?php echo Helper::abbreviate_number($acc->jml_likes,2); ?></b>
          </span><br>
          <span class="info-label">Avg Like Per Post</span>
        </div>

        <div class="col-xs-4 info-box inline">
          <span class="info-value">
            <b><?php echo Helper::abbreviate_number($acc->jml_comments,2); ?></b>
          </span><br>
          <span class="info-label">
            Avg Comment Per Post
          </span>
        </div>
      </div>
    </div>
  </div>
<?php } 
    } else { ?>
  <div id="bg-page">
    <img src="{{asset('design/new-bg.jpg')}}">
  </div>

  <div class="col-xs-12 logo" align="center">
    <img src="{{asset('design/logobrand.png')}}">
  </div>
  <br>

  <div class="col-xs-12" align="center">
    <img class="profpic" src="{{$account->prof_pic}}">
    <br>
  </div>
  <div class="col-xs-12 info" align="center">
    <span class="saved-on">
      saved on : {{ date("d F Y") }}
    </span>
    <span class="username">
      <?php echo '@'.$account->username ?>
    </span> <br>
    <span class="name">
      {{$account->username}}
    </span> <br>
    
    <div style="margin-top:50px; margin-bottom: 50px;">
      <div class="col-xs-6 inline engrate">
        <img class="engrate-circle" src="{{asset('design/engrate-circle.png')}}" style="width: 100%;">
        <div class="engrate-txt">
          <span class="info-value">
            <?php $engrate = $account->eng_rate*100 ?>
            <b>{{round($engrate,2)}}</b>%
          </span><br>
          <span class="info-label">Engagement<br>Rate</span>
        </div>
      </div>

      <div class="col-xs-6 inline engrate">
        <div class="engrate-txt">
          <span class="info-value">
            <b>
              <?php echo Helper::abbreviate_number(round($account->eng_rate*$account->jml_followers),2) ?>  
            </b>
          </span><br>
          <span class="info-label">
            Total Influenced
          </span>
        </div>
      </div>
    </div>

    <div>
      <div class="col-xs-4 info-box inline">
        <span class="info-value">
          <b><?php echo Helper::abbreviate_number($account->jml_post,2); ?></b>
        </span><br>
        <span class="info-label">Total Posts</span>
      </div>

      <div class="col-xs-4 info-box inline">
        <span class="info-value">
          <b><?php echo Helper::abbreviate_number($account->jml_followers,2); ?></b>
        </span><br>
        <span class="info-label">Followers</span>
      </div>

      <div class="col-xs-4 info-box inline">
        <span class="info-value">
          <b><?php echo Helper::abbreviate_number($account->jml_following,2); ?></b>
        </span><br>
        <span class="info-label">Following</span>
      </div>
    </div>

    <div>
      <div class="col-xs-4 info-box inline">
        <span class="info-value">
          <b>{{ date("M d Y", strtotime($account->lastpost))  }}</b>
        </span><br>
        <span class="info-label">Last Post</span>
      </div>

      <div class="col-xs-4 info-box inline">
        <span class="info-value">
          <b><?php echo Helper::abbreviate_number($account->jml_likes,2); ?></b>
        </span><br>
        <span class="info-label">Avg Like Per Post</span>
      </div>

      <div class="col-xs-4 info-box inline">
        <span class="info-value">
          <b><?php echo Helper::abbreviate_number($account->jml_comments,2); ?></b>
        </span><br>
        <span class="info-label">
          Avg Comment Per Post
        </span>
      </div>
    </div>
  </div>
<?php } ?>
