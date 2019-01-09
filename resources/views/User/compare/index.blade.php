@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-compare.css') }}" rel="stylesheet">
<script type="text/javascript">
  $(document).ready(function() {
    refresh_page();
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
  });

  $( "body" ).on( "click", ".btn-search", function() {
    // refresh_page();
    $.ajax({
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
          $('#pesan').hide();
          $('#content-akun').html(data.view);
          
          // load_history();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          } else {
            $('#pesan').html(data.message);
            $('#pesan').removeClass('alert-success');
            $('#pesan').addClass('alert-warning');
            $('#pesan').show();
          }
        }
      }
    });
  });
  
  $( "body" ).on( "click", ".btn-delete", function() {
    $('#id_delete').val($(this).attr('data-id'));
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
          $('#pesan').hide();
          $('#content-akun').html(data.view);
          // console.log(data.view);
          // load_history();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          } else {
            $('#pesan').html(data.message);
            $('#pesan').removeClass('alert-success');
            $('#pesan').addClass('alert-warning');
            $('#pesan').show();
          }
        }
      }
    });
  }
</script>

<div class="container-fluid">

  <div class="alert" id="pesan"></div>

  <div class="col-md-12" align="center">
    <h3>Comparison Influencer</h3>
  </div>

  <div class="row">
    <div class="col-md-2 col-md-offset-5" style="margin:0 auto;">
      <hr class="hr-1">
    </div>
  </div>

  <div class="col-md-12" align="center">
    <p class="description-compare">
      if you are in the market for a computer, there are a <br>
      number of factors to consider. Will it be used for your <br>
      home, your office or perhaps even your home office <br>
      combo?
    </p>
  </div>

  <div class="row" align="center">
    <div class="col-md-12">
      <hr class="hr-2">
    </div>
  </div>

  <div class="row" align="center">
    <div class="col-md-2">
      <a href="{{url('home')}}"><button class="btn back-to-home">back to home</button></a>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-3" align="center">
      <p class="enter-username">Enter Instagram username and tap Enter!</p>
      <form>
        @csrf
        <div class="form-group row search-bar">
          <div class="col-md-9 col-xs-12">
            <input id="keywords1" class="form-control " name="search" placeholder="username" value="{{$username1}}">
          </div>
          <div class="col-md-3 col-xs-12">
            <button type="button" class="btn btn-primary btn-search" data-part="1"> Search </button>
          </div>
        </div>
      </form> 
    </div>

    <div class="col-md-3" align="center">
      <p class="enter-username">Enter Instagram username and tap Enter!</p>
      <form>
        @csrf
        <div class="form-group row search-bar">
          <div class="col-md-9 col-xs-12">
            <input id="keywords2" class="form-control" name="search" placeholder="username" value="{{$username2}}">
          </div>
          <div class="col-md-3 col-xs-12">
            <button type="button" class="btn btn-primary btn-search" data-part="2"> Search </button>
          </div>
        </div>
      </form> 
    </div>

    <div class="col-md-3" align="center">
      <p class="enter-username">Enter Instagram username and tap Enter!</p>
      <form>
        @csrf
        <div class="form-group row search-bar">
          <div class="col-md-9 col-xs-12">
            <input id="keywords3" class="form-control" name="search" placeholder="username" value="{{$username3}}">
          </div>
          <div class="col-md-3 col-xs-12">
            <button type="button" class="btn btn-primary btn-search" data-part="3"> Search </button>
          </div>
        </div>
      </form> 
    </div>

    <div class="col-md-3" align="center">
      <p class="enter-username">Enter Instagram username and tap Enter!</p>
      <form>
        @csrf
        <div class="form-group row search-bar">
          <div class="col-md-9 col-xs-12">
            <input id="keywords4" class="form-control" name="search" placeholder="username" value="{{$username4}}">
          </div>
          <div class="col-md-3 col-xs-12">
            <button type="button" class="btn btn-primary btn-search" data-part="4"> Search </button>
          </div>
        </div>
      </form> 
    </div>
  </div>

  <div class="row justify-content-center search-content" id="content-akun">
  </div>


  <div class="col-md-12" align="center">
    <button class="btn btn-download-result"> Download Result </button>
  </div>

</div>
@endsection