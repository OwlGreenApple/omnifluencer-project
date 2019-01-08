<?php use App\Helpers\Helper; ?>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

<div id="bg-page">
  <img src="{{asset('design/new-bg.jpg')}}">
</div>


<div class="col-md-12 info compare" align="center">

  @foreach($data as $account)
    <?php 
      if(is_null($account)) {
        continue;
      }  
    ?>
    <div class="col-md-3 inline">
      <img class="profpic" src="{{$account->prof_pic}}" style="max-width: 150px"><br>
      <?php echo '@'.$account->username ?> <br>

      <div class="row">
        <div class="col-md-4">
          <span class="info-value">
            <b>
              <?php echo Helper::abbreviate_number(round($account->eng_rate*$account->jml_followers),2) ?>  
            </b>
          </span><br>
          <span class="info-label">
            Total Influenced
          </span>

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
  @endforeach
  
</div>

