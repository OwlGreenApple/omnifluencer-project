@extends('layouts.dashboard')

@section('content')
<style type="text/css">
  .card-header.membership {
    background-image: linear-gradient(-225deg, #13A5F5 0%, #4ABAF1 45%, #13A5F5 100%);
  }
</style>
<script type="text/javascript">
  var currentPage = '';

  $(document).ready(function() {
    //function saat klik pagination
    refresh_page();
    
  });

  function refresh_page(){
    if(currentPage==''){
      currentPage = "<?php echo url('/points/load-points') ?>";
    } 

    $.ajax({
      type : 'GET',
      url : currentPage,
      data: {
        keywords : $('#keywords').val(),
      },
      dataType: 'text',
      beforeSend: function()
      {
        $('#loader').show();
        $('.div-loading').addClass('background-load');
      },
      success: function(result) {
        $('#loader').hide();
        $('.div-loading').removeClass('background-load');

        var data = jQuery.parseJSON(result);
        $('#content').html(data.view);
        $('#pager').html(data.pager);
      }
    });
  }

</script>

<style type="text/css">
  .profpic {
    width: 75px;
    height: 75px;
    object-fit: cover;
    border-radius: 50%;
  }
</style>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <!--<div class="row">
        <form class="form-inline col-md-12 mb-2" action="{{url('search')}}" method="POST">
          @csrf
          
          <label class="mr-sm-2 pb-md-2 label-calculate" for="calculate">
            Calculate More
          </label>

          <input id="calculate" type="text" class="form-control form-control-sm mb-2 mr-sm-2 mr-2 col-md-3 col-9" name="keywords" placeholder="Enter Instagram Username">

          <button type="submit" class="btn btn-sm btn-primary mb-2">
            Calculate
          </button>
        </form>
      </div>

      <hr>-->

      <div class="row">
        <div class="col-md-8 col-6">
          <h2><b>Reward Points</b></h2>  
        </div>  
      </div>
      
      <h5>
        Your point history
      </h5>    
      <hr>

      <br>  

      <?php  
        $profpic = null;

        if(Auth::user()->prof_pic!=null){
          $profpic = Storage::url(Auth::user()->prof_pic);
        }
      ?>
      <div class="row">
        <div class="col-md-7">
          <div class="card">  
            <div class="card-body point-card">
              <div class="row"> 
                <div class="col-lg-3 col-md-3 col-12" align="center">  
                  <img class="profpic" id="profpic-point" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
                </div>

                <div class="col-lg-5 col-md-5 col-12 center-mobile">
                  <h4 class="point-name">
                    <b>{{Auth::user()->name}}</b>
                  </h4>
                  <span class="point-member">
                    <i>
                      {{ucfirst(Auth::user()->membership)}} Membership
                    </i><br>
                    <i>
                      @if(Auth::user()->membership=='free')
                        No Expired
                      @else 
                        Expire on : 
                        {{date('d-m-Y',strtotime(Auth::user()->valid_until))}}
                      @endif
                    </i>  
                  </span>
                  
                </div>

                <div class="col-lg-4 col-md-4 col-12 center-mobile" align="right">
                  <span><b>Total points :</b></span> <br>
                  <p>
                    <i class="fas fa-coins"></i>
                    <span class="point-total">
                      {{Auth::user()->point}}
                    </span>
                  </p>
                </div>
              </div>
              
              <!--<div class="col-md-12"> 
                <p style="padding:0;margin:0;" align="right">2500 pts</p>

                <?php $percent = (Auth::user()->point/2500)*100 ?>
                <div class="progress" style="height: 25px;margin-bottom: 9px;">
                  <div class="progress-bar bg-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent ?>%">
                    {{Auth::user()->point}} pts
                  </div>
                </div>

                <h5>
                  <b>FREE PRO MEMBER : 2000 PTS to go</b>
                </h5>
              </div>-->            
            </div>
          </div>
        </div>  

        <div class="col-md-5">
          <div class="card">  
            <!--<div class="card-header membership" align="center">
              <h3>PRO MEMBER</h3>
            </div>-->
            <div class="card-body" align="center">
              <?php  
                $member = 'Premium';
                if(Auth::user()->membership=='free'){
                  $member = 'Pro';
                }
              ?>
              <p>
                Upgrade to <b>{{$member}} Membership?</b> <br>
                Click button below
              </p>

              <a href="{{url('upgrade-account')}}">
                <button class="btn btn-primary btn-upgrade-poin" data-upgrade="pro">
                  UPGRADE NOW
                </button>
              </a>
                <!--Importance <br> 
                Design <br> 
                Group <br>  
                Save as .PDF<br> 
                Save as .CSV-->
            </div>
          </div>
        </div>
      </div>

      <div class="card col-md-12 <?php if(Auth::user()->membership=='premium') echo 'd-none' ?>">
        <div class="card-body row">
          <div class="col-md-1" align="center">  
            <i class="fas fa-exclamation-circle icon-exclamation" style="font-size:30px;color:#FF8717;"></i>
          </div>
          <div class="col-md-11"> 
            <div class="<?php if(Auth::user()->membership=='pro') echo 'd-none' ?>">
              <h4><b>What is PRO MEMBER?</b></h4>  
              * <b>Pro Member</b> dapat menampilkan 25 history pencarian terakhir<br>  
              * <b>Pro Member</b> dapat mengelompokkan ke dalam suatu grup dari hasil pencarian <br>  
              * <b>Pro Member</b> dapat melakukan compare dari 2 hasil pencarian <br> 
              <br>    
            </div>
            
            <div class="<?php if(Auth::user()->membership=='free') echo 'd-none' ?>">
              <h4><b>What is PREMIUM MEMBER?</b></h4>  
              * <b>Premium Member</b> dapat menampilkan history pencarian tanpa batas<br>  
              * <b>Premium Member</b> dapat melakukan Save & Send Influencers Report .PDF dan List .XLSX <br>  
              * <b>Premium Member</b> dapat melakukan compare dari 4 hasil pencarian <br>   
            </div>
          </div>
        </div>
      </div>

      <br>

      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-redeem-tab" data-toggle="tab" href="#nav-redeem" role="tab" aria-controls="nav-redeem" aria-selected="true">
            <b>Redeem Points</b>
          </a>
          <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">
            <b>Point History</b>
          </a>
        </div>
      </nav>

      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-redeem" role="tabpanel" aria-labelledby="nav-redeem-tab">
          <br>

          @include('user.points.content-redeem')

        </div>

        <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
          <br>
        
          <table class="table">
            <thead align="center">
              <th class="header" action="created_at">
                Date
              </th>
              <th class="header" action="keterangan">
                Description
              </th>
              <th class="header" action="jml_point">
                Points
              </th>
            </thead>
            <tbody id="content"></tbody>
          </table>

          <div id="pager"></div>    
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  $( "body" ).on( "keypress", "#input-group", function(e)
  {
      if(e.which == 13)
      {
        create_groups();
      }
  });  

  $( "body" ).on( "click", ".btn-search", function() {
    currentPage = '';
    refresh_page();
  });

  $( "body" ).on( "click", ".btn-delete", function() {
    $('#id_delete').val($(this).attr('data-id'));
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    delete_history();
  });

  $( "body" ).on( "click", "#btn-save", function() {
    get_groups();
  });

  $( "body" ).on( "click", "#btn-add-group", function() {
    add_groups();
  });

  $( "body" ).on( "click", "#btn-create-group", function() {
    $('#input-group').show();
    $("#input-group").focus();
  });

  /*$( "body" ).on( "click", ".btn-upgrade-poin", function(e){
    $('.nav-tabs a[href="#nav-redeem"]').tab('show');

    var targetSec = $(this).attr('data-upgrade');
    $('html, body').animate({
      scrollTop: $('#' + targetSec).offset().top
    }, 1000);
  });*/

  $(document).on('click', '#checkAll', function (e) {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    currentPage = $(this).attr('href');
    refresh_page();
  });
</script>
@endsection