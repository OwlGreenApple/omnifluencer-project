<?php use App\Helpers\Helper; ?>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

<style type="text/css">
  .info-box { border:1px solid black;}  

  .info { background-color: #fff;}

  .logo { padding-top: 40px; padding-bottom: 30px; }

  #bg-page { position: fixed; z-index:-20;}

  .saved-on { right: 0; }
</style>

<div id="bg-page">
  <img src="{{asset('design/new-bg.jpg')}}">
</div>

<div class="col-xs-12 logo" align="center">
  <img src="{{asset('design/logobrand.png')}}">
</div>
<br>
<?php if(is_array($account)) { 
        foreach ($account as $acc) {
?>
  <div class="col-md-12" align="center">
    <img src="{{$acc->prof_pic}}" style="max-width: 150px"><br>
    <?php echo '@'.$acc->username ?> <br>
    {{$acc->username}}

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
  <div class="col-xs-12" align="center">
    <img src="{{$account->prof_pic}}" style="max-width: 180px;border-radius: 50%"><br>
  </div>
  <div class="col-xs-12 info" align="center">
    <span class="saved-on">
      saved on : {{ date("d F Y") }}
    </span>
    <h2><?php echo '@'.$account->username ?></h2>
    <h1>{{$account->username}}</h1>
    <div class="row">
      <div class="col-xs-6">
        {{$account->eng_rate}} <br>
        Engagement Rate
      </div>
      <div class="col-xs-6">
        <?php echo $account->eng_rate*$account->jml_followers ?><br>
        Total Influenced
      </div>
    </div>

    <div class="row">
      <div class="col-xs-4 info-box">
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_post,2); ?></b>
        </h4>
        <h5>Total Posts</h5>
      </div>

      <div class="col-xs-4 info-box">
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_followers,2); ?></b>
        </h4>
        <h5>Followers</h5>
      </div>

      <div class="col-xs-4 info-box">
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_following,2); ?></b>
        </h4>
        <h5>Following</h5>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-4 info-box">
        <h4>
          <b>{{ date("M d Y", strtotime($account->lastpost))  }}</b>
        </h4>
        <h5>Last Post</h5>
      </div>

      <div class="col-xs-4 info-box">
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_likes,2); ?></b>
        </h4>
        <h5>Avg Like Per Post</h5>
      </div>

      <div class="col-xs-4 info-box">
        <h4>
          <b><?php echo Helper::abbreviate_number($account->jml_comments,2); ?></b>
        </h4>
        <h5>Avg Comment Per Post</h5>
      </div>
    </div>
  </div>
<?php } ?>
