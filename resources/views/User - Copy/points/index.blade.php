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
    border-radius: 50%;
  }
</style>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">

      <h2><b>Points</b></h2>  
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
        <div class="col-md-7 h-40">
          <div class="card">  
            <div class="card-body">
              <div class="row"> 
                <div class="col-md-2 col-12" align="center">  
                  <img class="profpic" src="<?php echo $profpic ?>" altSrc="{{asset('/design/profpic-user.png')}}" onerror="this.src = $(this).attr('altSrc')">
                </div>

                <div class="col-md-6 col-12 center-mobile"> 
                  <h4><b>{{Auth::user()->name}}</b></h4>
                  <i>{{ucfirst(Auth::user()->membership)}} Membership</i> <br>
                  <i>
                    @if(Auth::user()->membership=='free')
                      No Expired
                    @else 
                      Expire on : 
                      {{date('d-m-Y',strtotime(Auth::user()->valid_until))}}
                    @endif
                  </i>
                </div>

                <div class="col-md-4 col-12 center-mobile" align="right">
                  <span><b>Total points :</b></span> <br>
                  <p>
                    <i class="fas fa-coins"></i>
                    <span style="font-size: 28px;margin-left: 5px;">{{Auth::user()->point}}</span>
                  </p>
                </div>
              </div>
              <br>  
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

        <div class="col-md-5 h-60">
          <div class="card">  
            <!--<div class="card-header membership" align="center">
              <h3>PRO MEMBER</h3>
            </div>-->
            <div class="card-body" align="center">
              <p>
                Upgrade to <b>Pro Membership?</b> <br>
                Click button below
              </p>
              <button class="btn btn-primary btn-upgrade-poin" data-upgrade="pro">
                <i class="fas fa-star"></i> 
                Upgrade To Pro
              </button>
                <!--Importance <br> 
                Design <br> 
                Group <br>  
                Save as .PDF<br> 
                Save as .CSV-->
            </div>
          </div>
        </div>
      </div>

      <div class="card col-md-12">
        <div class="card-body row">
          <div class="col-md-1" align="center">  
            <i class="fas fa-exclamation-circle icon-exclamation" style="font-size:30px;color:#FF8717;"></i>
          </div>
          <div class="col-md-11"> 
            <h4><b>What is PRO MEMBER?</b></h4>  
            * <b>PRO Member</b> dapat menampilkan seluruh history pencarian <br>  
            * <b>PRO Member</b> dapat mengelompokkan ke dalam suatu grup dari hasil pencarian <br>  
            * <b>PRO Member</b> mendapatkan file .PDF dan .CSV dari seluruh history pencarian 
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

  $( "body" ).on( "click", ".btn-upgrade-poin", function(e){
    $('.nav-tabs a[href="#nav-redeem"]').tab('show');

    var targetSec = $(this).attr('data-upgrade');
    $('html, body').animate({
      scrollTop: $('#' + targetSec).offset().top
    }, 1000);
  });

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