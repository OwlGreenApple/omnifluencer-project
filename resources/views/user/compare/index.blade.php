@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-compare.css') }}" rel="stylesheet">
<script type="text/javascript">
  $(document).ready(function() {
    refresh_page();
    $('.counter').counterUp();
  });

  $( "body" ).on( "click", ".btn-search", function() {
    var keywords = $("#keywords1").val()+'-'+$("#keywords2").val()+'-'+$("#keywords3").val()+'-'+$("#keywords4").val();
    var url = "{{url('compare')}}"+'/'+keywords;
  
    window.location.replace(url);

    // refresh_page();
    /*$.ajax({
      type : 'GET',
      url : "<?php echo url('/compare/load-search') ?>",
      data: {
        keywords: $(this).parent().find("input").val(),
        part : $(this).attr("data-part")
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

        if(data.status == 'success'){
          $('#content-akun').html(data.view);
          
          $('.counter').counterUp({
            delay: 10,
            time: 1000,
            formatter: function (n) {
              return Math.round(n * 100) / 100;
            }
          });
          
          // load_history();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          } else {
            $('#message').html(data.message);
            $('#modal-pesan').modal('show');
          }
        }
      }
    });*/
  });
  
  $( "body" ).on( "click", ".btn-delete", function() {
    var col = $(this).attr('data-col');
    $('.akun-'+col).hide();
    $('#keywords'+col).val('');
  });

  function refresh_page(col=0){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/compare/load-compare') ?>",
      data: {
        id1:$("#keywords1").val(),
        id2:$("#keywords2").val(),
        id3:$("#keywords3").val(),
        id4:$("#keywords4").val(),
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

        if(data.status == 'success'){
          $('#content-akun').html(data.view);
          $("#link-download").prop("href", "<?php echo url('print-pdf-compare')?>"+'/'+data.id+'/colorful');

          $('.counter').counterUp({
            delay: 10,
            time: 1000,
            formatter: function (n) {
              return Math.round(n * 100) / 100;
            }
          });

          // console.log(data.view);
          // load_history();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          } else {
            $('#message').html(data.message);
            $('#modal-pesan').modal('show');
          }
        }
      }
    });
  }

</script>

<style type="text/css">
  .form-control {
    width: 100% !important;
  }  
</style>

<section class="page-title">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Comparison Influencer</h1>
        <hr class="orn">
        <p class="pg-title">If you are in the market for a computer, there are a number of factors to consider. Will it be used for your home, your office or perhaps even your home office combo? </p>
      </div>
    </div>
  </div>
</section>
  
<hr class="wh">

<div class="container">

  <!--<div class="alert" id="pesan"></div>-->

  <div class="row" align="center">
    <div class="col-md-2">
      <a href="{{url('home')}}">
        <button class="btn back-to-home">
          <i class="fas fa-arrow-left"></i>
          Back To Home
        </button>
      </a>
    </div>
  </div>

  <div class="col-12 pc-none">
    <p class="enter-username">Enter Instagram username and tap Enter!</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-3 col-6" align="center">
      <p class="enter-username mobile-none">Enter Instagram username and tap Enter!</p>
      <form>
        @csrf
        <div class="form-group row search-bar">
          <div class="col-md-9 col-12">
            <input id="keywords1" class="form-control " name="search" placeholder="username" value="{{$username1}}">
          </div>
          <div class="col-md-3 col-12 pl-0 mobile-none">
            <button type="button" class="btn btn-primary btn-search" data-part="1"> Search </button>
          </div>
        </div>
      </form> 
    </div>

    <div class="col-md-3 col-6" align="center">
      <p class="enter-username mobile-none">Enter Instagram username and tap Enter!</p>
      <form>
        @csrf
        <div class="form-group row search-bar">
          <div class="col-md-9 col-12 pl-none">
            <input id="keywords2" class="form-control" name="search" placeholder="username" value="{{$username2}}">
          </div>
          <div class="col-md-3 col-12 pl-0 mobile-none">
            <button type="button" class="btn btn-primary btn-search" data-part="2"> Search </button>
          </div>
        </div>
      </form> 
    </div>

    @if(Auth::user()->membership=='premium')
      <div class="col-md-3 col-6" align="center">
        <p class="enter-username mobile-none">Enter Instagram username and tap Enter!</p>
        <form>
          @csrf
          <div class="form-group row search-bar">
            <div class="col-md-9 col-12">
              <input id="keywords3" class="form-control" name="search" placeholder="username" value="{{$username3}}">
            </div>
            <div class="col-md-3 col-12 pl-0 mobile-none">
              <button type="button" class="btn btn-primary btn-search" data-part="3"> Search </button>
            </div>
          </div>
        </form> 
      </div>

      <div class="col-md-3 col-6" align="center">
        <p class="enter-username mobile-none">Enter Instagram username and tap Enter!</p>
        <form>
          @csrf
          <div class="form-group row search-bar">
            <div class="col-md-9 col-12 pl-none">
              <input id="keywords4" class="form-control" name="search" placeholder="username" value="{{$username4}}">
            </div>
            <div class="col-md-3 col-12 pl-0">
              <button type="button" class="btn btn-primary btn-search mobile-none" data-part="4"> Search </button>
            </div>
          </div>
        </form> 
      </div>
    @endif
  </div>

  <div class="col-12 pc-none search-bar mt-3" align="center">
    <button type="button" class="btn btn-primary btn-search"> Search </button>
  </div>

  <div class="row justify-content-center search-content" id="content-akun">
  </div>


  <div class="col-md-12" align="center">
    <a id="link-download" href="#" target="_blank">
      <button class="btn btn-download-result"> 
        Download Result 
      </button>
    </a>
  </div>

</div>
@endsection