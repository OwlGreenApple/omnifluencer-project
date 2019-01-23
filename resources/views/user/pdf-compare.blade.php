<?php use App\Helpers\Helper; ?>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

<style type="text/css">
 
</style>

<div id="bg-page">
  <img src="{{asset('design/new-bg.jpg')}}">
</div>

@if(Auth::user()->logo==null)
  <div class="col-xs-12 logo-rotate" align="center">
    <img src="{{asset('design/logobrand.png')}}" style="height:50px;">
  </div>
@else 
  <div class="col-xs-12 logo-rotate" align="center">
    <img src="{{asset('design/logodummy.png')}}" style="height:50px;">
  </div>
@endif

<div style="padding:30px;"></div>

<div class="col-md-12 info-compare" align="center">

  @foreach($data as $account)
    <?php 
      if(is_null($account)) {
        continue;
      }  
    ?>
    <div class="col-md-3 inline div-compare">
      <div class="info-box-compare">
        <img class="profpic-compare" src="{{$account->prof_pic}}"><br>
        <?php echo '@'.$account->username ?> <br>
        <span class="username-compare">
          <b>{{$account->username}}</b>
        </span>
      </div>

      <div class="col-xs-6 inline engrate-compare">
        <img class="engrate-circle-compare" src="{{asset('design/engrate-circle.png')}}" style="width: 100%;">
        <div class="engrate-txt-compare">
          <span>
            <?php $engrate = $account->eng_rate*100 ?>
            <b>{{round($engrate,2)}}</b>%
          </span><br>
          <span>Engagement<br>Rate</span>
        </div>
      </div>
        
      <div class="info-box-compare">
        <span>
          <b>
            <?php echo Helper::abbreviate_number(round($account->total_influenced),2) ?>  
          </b>
        </span><br>
        <span>
          Total Influenced
        </span>
      </div>

      <div class="info-box-compare">
        <span>
          <b><?php echo Helper::abbreviate_number($account->jml_post,2); ?></b>
        </span><br>
        <span>Post</span>
      </div>
        
      <div class="info-box-compare">
        <span>
          <b><?php echo Helper::abbreviate_number($account->jml_followers,2); ?></b>
        </span><br>
        <span>Followers</span>
      </div>
        
      <div class="info-box-compare">
        <span>
          <b><?php echo Helper::abbreviate_number($account->jml_following,2); ?></b>
        </span><br>
        <span>Following</span>
      </div>
          
      <div class="info-box-compare">
        <span>
          <b>{{ date("M d Y", strtotime($account->lastpost))  }}</b>
        </span><br>
        <span>Last Post</span>
      </div>
        
      <div class="info-box-compare">
        <span>
          <b><?php echo Helper::abbreviate_number($account->jml_likes,2); ?></b>
        </span><br>
        <span>Avg Like Per Post</span>
      </div>
        
      <div class="info-box-compare">
        <span>
          <b><?php echo Helper::abbreviate_number($account->jml_comments,2); ?></b>
        </span><br>
        <span>Avg Comment Per Post</span>
      </div>  
    </div>
  @endforeach
  
  @if(Auth::user()->logo!=null)
    <img src="{{asset('design/logobrand.png')}}" class="logo-footer">
  @endif
  
  <span class="saved-on-footer">
    <!--{{url('/')}} | calculated on {{ date("d F Y") }}-->
    www.omnifluencer.com | calculated on {{ date("d F Y") }}
  </span>

</div>

