@extends('layouts.app')

@section('content')
<script type="text/javascript">
  $(document).ready(function() {
    refresh_page();
    $('.counter').counterUp({
        delay: 10,
        time: 1000
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
        id1:'{{$id1}}',
        id2:'{{$id2}}',
        id3:'{{$id3}}',
        id4:'{{$id4}}',
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
          load_history();
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

  <div class="row justify-content-center">
    <div class="col-md-3" align="center">
      <p>Enter Instagram username and tap Enter!</p>
      <form>
        @csrf         
        <div class="form-group row" style="margin-left: 1px;">
          <input id="keywords" class="form-control col-md-6 col-xs-12" name="search" placeholder="username">
          <button type="button" class="btn btn-primary btn-search" style="margin-left: 13px; margin-right: 13px;"> Search </button>
        </div>
      </form> 
    </div>

    <div class="col-md-3" align="center">
      <p>Enter Instagram username and tap Enter!</p>
      <form>
        @csrf         
        <div class="form-group row" style="margin-left: 1px;">
          <input id="keywords" class="form-control col-md-6 col-xs-12" name="search" placeholder="username">
          <button type="button" class="btn btn-primary btn-search" style="margin-left: 13px; margin-right: 13px;"> Search </button>
        </div>
      </form> 
    </div>

    <div class="col-md-3" align="center">
      <p>Enter Instagram username and tap Enter!</p>
      <form>
        @csrf         
        <div class="form-group row" style="margin-left: 1px;">
          <input id="keywords" class="form-control col-md-6 col-xs-12" name="search" placeholder="username">
          <button type="button" class="btn btn-primary btn-search" style="margin-left: 13px; margin-right: 13px;"> Search </button>
        </div>
      </form> 
    </div>

    <div class="col-md-3" align="center">
      <p>Enter Instagram username and tap Enter!</p>
      <form>
        @csrf         
        <div class="form-group row" style="margin-left: 1px;">
          <input id="keywords" class="form-control col-md-6 col-xs-12" name="search" placeholder="username">
          <button type="button" class="btn btn-primary btn-search" style="margin-left: 13px; margin-right: 13px;"> Search </button>
        </div>
      </form> 
    </div>
  </div>

  <div class="row justify-content-center" id="content">
  </div>

</div>
@endsection