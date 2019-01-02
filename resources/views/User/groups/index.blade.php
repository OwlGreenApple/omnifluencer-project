@extends('layouts.dashboard')

@section('content')
<link href="{{ asset('css/history-search.css') }}" rel="stylesheet">

<script type="text/javascript">
  var currentPage = '';

  $(document).ready(function() {
    //function saat klik pagination
    refresh_page();
    
  });

  function refresh_page(){
    if(currentPage==''){
      currentPage = "<?php echo url('/groups/load-groups') ?>";
    } 

    $.ajax({
      type : 'GET',
      url : currentPage,
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

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <h2><b>Group</b></h2>

      <div class="row">
        <div class="col-md-5">
          <h5>
            Manage your saved group
          </h5>    
        </div>

        <div class="col-md-7" align="right">
          <button class="btn btn-danger">
            <i class="far fa-trash-alt"></i> Delete
          </button>
        </div>
      </div>
    
      <hr>
      
      <br>

      <div id="content"></div>

    </div>
  </div>
</div>

<script type="text/javascript">
  $( "body" ).on( "dblclick", ".div-group", function() {
    var idgroup = $(this).attr('data-id');
    var groupname = $(this).attr('data-name');

    window.location.href = "<?php echo url('groups') ?>"+'/'+idgroup+'/'+groupname;
  });
</script>
@endsection