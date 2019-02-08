<?php use App\Helpers\Helper; ?>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

<?php  
  $logo = null;

  if(Auth::user()->logo!=null and Auth::user()->membership=='premium'){
    $logo = Storage::url(Auth::user()->logo);
  }
?>

<?php if(is_array($account)) { 
        foreach ($account as $acc) {
?>
  <div class="page">
    @if(Auth::user()->logo!=null and Auth::user()->membership=='premium')
      <div class="col-xs-12 logo" align="center">
        <img src="<?php echo $logo ?>" class="logouser">
      </div>
    @else 
      <div class="col-xs-12 logo" align="center">
        <img src="{{asset('design/logobrand.png')}}" class="logouser">
      </div>
    @endif

    <br>

    <div class="inline col-akun" align="center">
      <div class="col-xs-12">
        <img class="profpic-plain" src="{{$acc->prof_pic}}">
        <br>
      </div>

      <div class="div-username" align="center">
        <span class="username-plain">
          <?php echo '@'.$acc->username ?>
        </span> <br>
        <span class="name">
          {{$acc->username}}
        </span> <br>
      </div>

      <div class="col-xs-6 inline engrate" align="center">
        <img class="engrate-circle" src="{{asset('design/engrate-circle.png')}}" style="width: 100%;">
        <div class="engrate-txt">
          <span class="info-value">
            <?php $engrate = $acc->eng_rate*100 ?>
            <b>{{round($engrate,2)}}</b>%
          </span><br>
          <span class="info-label">
            Engagement<br>Rate
          </span>
        </div>
      </div>
    </div>

    <div class="inline col-info" align="center">
      <div class="col-xs-6 div-influenced" align="center">  
        <span class="info-value-plain">
          <b>
            <?php echo Helper::abbreviate_number(round($acc->total_influenced),2) ?>  
          </b>
        </span><br>
        <span class="info-label-plain">
          Total Influenced
        </span>  
      </div>

      <div class="info-1">
        <div class="col-xs-4 infobox-plain inline" align="center">
          <span class="info-value-plain">
            <b><?php echo Helper::abbreviate_number($acc->jml_post,2); ?></b>
          </span><br>
          <span class="info-labelsm-plain">Total Posts</span>
        </div>

        <div class="col-xs-4 infobox-plain inline" align="center">
          <span class="info-value-plain">
            <b><?php echo Helper::abbreviate_number($acc->jml_followers,2); ?></b>
          </span><br>
          <span class="info-labelsm-plain">Followers</span>
        </div>

        <div class="col-xs-4 infobox-plain inline" align="center">
          <span class="info-value-plain">
            <b><?php echo Helper::abbreviate_number($acc->jml_following,2); ?></b>
          </span><br>
          <span class="info-labelsm-plain">Following</span>
        </div>  
      </div>

      <div>
        <div class="col-xs-4 infobox-plain inline" align="center">
          <span class="info-value-plain">
            <b><?php echo Helper::abbreviate_number($acc->jml_likes,2); ?></b>
          </span><br>
          <span class="info-labelsm-plain">
            Avg Like<br>Per Post
          </span>
        </div>

        <div class="col-xs-4 infobox-plain inline" align="center">
          <span class="info-value-plain">
            <b><?php echo Helper::abbreviate_number($acc->jml_comments,2); ?></b>
          </span><br>
          <span class="info-labelsm-plain">
            Avg Comment<br>Per Post
          </span>
        </div>

        <div class="col-xs-4 infobox-plain inline" align="center">
          <span class="info-value-plain">
            <b>{{ date("M d 'y", strtotime($acc->lastpost))  }}</b>
          </span><br>
          <span class="info-labelsm-plain">Last Post</span>
        </div> 
      </div>
    </div>

    @if(Auth::user()->logo!=null and Auth::user()->membership=='premium')
      <img src="{{asset('design/logobrand.png')}}" class="logo-footer" style="bottom:-230px">
    @endif  

    <span class="saved-on-footer" style="bottom:-230px">
      <!--{{url('/')}} | calculated on {{ date("d F Y") }}-->
      www.omnifluencer.com | calculated on {{ date("d F Y") }}
    </span>
  </div>
<?php } 
    } else { ?>
  
  @if(Auth::user()->logo!=null and Auth::user()->membership=='premium')
    <div class="col-xs-12 logo" align="center">
      <img src="<?php echo $logo ?>" class="logouser">
    </div>
  @else 
    <div class="col-xs-12 logo" align="center">
      <img src="{{asset('design/logobrand.png')}}" class="logouser">
    </div>
  @endif

  <br>

  <div class="inline col-akun" align="center">
    <div class="col-xs-12">
      <img class="profpic-plain" src="{{$account->prof_pic}}">
      <br>
    </div>

    <div class="div-username" align="center">
      <span class="username-plain">
        <?php echo '@'.$account->username ?>
      </span> <br>
      <span class="name">
        {{$account->username}}
      </span> <br>
    </div>

    <div class="col-xs-6 inline engrate" align="center">
      <img class="engrate-circle" src="{{asset('design/engrate-circle.png')}}" style="width: 100%;">
      <div class="engrate-txt">
        <span class="info-value">
          <?php $engrate = $account->eng_rate*100 ?>
          <b>{{round($engrate,2)}}</b>%
        </span><br>
        <span class="info-label">
          Engagement<br>Rate
        </span>
      </div>
    </div>
  </div>

  <div class="inline col-info" align="center">
    <div class="col-xs-6 div-influenced" align="center">  
      <span class="info-value-plain">
        <b>
          <?php echo Helper::abbreviate_number(round($account->total_influenced),2) ?>  
        </b>
      </span><br>
      <span class="info-label-plain">
        Total Influenced
      </span>  
    </div>

    <div class="info-1">
      <div class="col-xs-4 infobox-plain inline" align="center">
        <span class="info-value-plain">
          <b><?php echo Helper::abbreviate_number($account->jml_post,2); ?></b>
        </span><br>
        <span class="info-labelsm-plain">Total Posts</span>
      </div>

      <div class="col-xs-4 infobox-plain inline" align="center">
        <span class="info-value-plain">
          <b><?php echo Helper::abbreviate_number($account->jml_followers,2); ?></b>
        </span><br>
        <span class="info-labelsm-plain">Followers</span>
      </div>

      <div class="col-xs-4 infobox-plain inline" align="center">
        <span class="info-value-plain">
          <b><?php echo Helper::abbreviate_number($account->jml_following,2); ?></b>
        </span><br>
        <span class="info-labelsm-plain">Following</span>
      </div>  
    </div>

    <div>
      <div class="col-xs-4 infobox-plain inline" align="center">
        <span class="info-value-plain">
          <b><?php echo Helper::abbreviate_number($account->jml_likes,2); ?></b>
        </span><br>
        <span class="info-labelsm-plain">
          Avg Like<br>Per Post
        </span>
      </div>

      <div class="col-xs-4 infobox-plain inline" align="center">
        <span class="info-value-plain">
          <b><?php echo Helper::abbreviate_number($account->jml_comments,2); ?></b>
        </span><br>
        <span class="info-labelsm-plain">
          Avg Comment<br>Per Post
        </span>
      </div>

      <div class="col-xs-4 infobox-plain inline" align="center">
        <span class="info-value-plain">
          <b>{{ date("M d 'y", strtotime($account->lastpost))  }}</b>
        </span><br>
        <span class="info-labelsm-plain">Last Post</span>
      </div> 
    </div>
  </div>

  @if(Auth::user()->logo!=null and Auth::user()->membership=='premium')
    <img src="{{asset('design/logobrand.png')}}" class="logo-footer">
  @endif  

  <span class="saved-on-footer">
    <!--{{url('/')}} | calculated on {{ date("d F Y") }}-->
    www.omnifluencer.com | calculated on {{ date("d F Y") }}
  </span>
<?php } ?>
