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

  function delete_group(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/groups/delete-group') ?>",
      data: $('form').serialize(),
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

          $('#pesan').html(data.message);
          $('#pesan').addClass('alert-success');
          $('#pesan').removeClass('alert-warning');
          $('#pesan').show();
        } else {
          $('#pesan').html(data.message);
          $('#pesan').removeClass('alert-success');
          $('#pesan').addClass('alert-warning');
          $('#pesan').show();
        }
      }
    });
  }

  function check_id(){
    if ($(".groupcheck:checked").length > 0){
      return true;
    } else {
      return false;
    }
  }
</script>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="row">
        <div class="col-md-8 col-6">
          <h2><b>Groups</b></h2>    
        </div>

        <div class="col-md-4 col-6" align="right">
          <a href="{{url('/')}}">
            <button class="btn btn-sm btn-primary btn-search-more">
              Search More &raquo;
            </button>
          </a>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-5 col-12">
          <h5>
            Manage your saved groups
          </h5>      
        </div>

        <div class="col-12 menu-mobile" align="left">
          <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete">
            <i class="far fa-trash-alt"></i> Delete
          </button>
        </div>
      </div>

      <hr>
      
      <div id="pesan" class="alert"></div>

      <br>

      <form>
        <div class="row">
          <div class="col-md-12 mb-4 menu-nomobile" align="right">
            <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete">
              <i class="far fa-trash-alt"></i> Delete
            </button>  
          </div>
        </div>
        
        <div id="content"></div>
        
      </form>

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

<script type="text/javascript">
  $( "body" ).on( "click", ".btn-delete", function(e) {
    if(!check_id()){
      e.stopPropagation();
      $('#pesan').html('Pilih group terlebih dahulu');
      $('#pesan').removeClass('alert-success');
      $('#pesan').addClass('alert-warning');
      $('#pesan').show();
    }
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    delete_group();
  });

  $( "body" ).on( "dblclick", ".div-group", function() {
    console.log('check');
    $(this).find('.groupcheck').prop('checked', true);

    var idgroup = $(this).attr('data-id');
    var groupname = $(this).attr('data-name');

    window.location.href = "<?php echo url('groups') ?>"+'/'+idgroup+'/'+groupname;
  });
</script>
@endsection