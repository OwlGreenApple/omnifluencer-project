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

  $( "body" ).on( "click", ".btn-search", function() {
    refresh_page();
  });

  $( "body" ).on( "click", ".btn-delete", function() {
    $('#id_delete').val($(this).attr('data-id'));
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    delete_history();
  });

  $( "body" ).on( "click", ".btn-compare", function(e) {
    <?php if(!Auth::check()) { ?>
      e.preventDefault();
      $('#info-kuota').modal('show');
    <?php } ?>
  });

  function load_search(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/search/load-search') ?>",
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

  function load_history(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/search/load-history') ?>",
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
        $('#content-history').html(data.view);
        console.log(data.count);
        if(data.count>=2){
          $('.boxcompare').show();
          $('.btn-compare').show();
        }

        if(data.count>5){
          $('#link-show').show();
        }
      }
    });
  }

  function refresh_page(){
    load_search();
  }

  function delete_history(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/search/delete-history') ?>",
      data: {
        id : $('#id_delete').val(),
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

        if(data.status=='success'){
          refresh_page();
        } else {
          if(data.message=='kuota habis'){
            $('#info-kuota').modal('show');
          }
        }
      }
    });
  }

</script>

<input type="hidden" name="id_delete" id="id_delete">

<div class="container">

  <div class="alert" id="pesan"></div>

  <div class="row justify-content-center">
    <div class="col-md-6" align="center">
      <p>Enter Instagram username and tap Enter!</p>
      <form>
        @csrf         
        <div class="form-group row" style="margin-left: 1px;">
          <input id="keywords" class="form-control col-md-4 col-xs-12" name="search" placeholder="username">
          <button type="button" class="btn btn-primary btn-search" style="margin-left: 13px; margin-right: 13px;"> Calculate! </button>
        </div>
      </form> 

      <div id="content-history" align="left"></div>   

    </div>

    <div class="col-md-6" id="content-akun">
      
    </div>
  </div>
</div>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="confirm-delete" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Delete Confirmation
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete?
      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-primary" id="btn-delete-ok" data-dismiss="modal">
          Yes
        </button>
        <button class="btn" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
      
  </div>
</div>

<!-- Modal Info Kuota -->
<div class="modal fade" id="info-kuota" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Kuota telah habis. <br>
        Silahkan Sign up untuk melanjutkan.
      </div>
      <div class="modal-footer" id="foot">
        <a class="mr-auto" href="{{url('login')}}">
          <button class="btn btn-primary">
            LOG IN
          </button>
        </a>
  
        <a href="{{url('register')}}">
          <button class="btn btn-primary">
            SIGN UP
          </button>
        </a>
      </div>
    </div>
      
  </div>
</div>
@endsection