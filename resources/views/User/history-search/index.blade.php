@extends('layouts.app')

@section('content')
<script type="text/javascript">
  var currentPage = '';

  $(document).ready(function() {
    //function saat klik pagination
    refresh_page();
    $(document).on('click', '.pagination a', function (e) {
      e.preventDefault();
      currentPage = $(this).attr('href');
      refresh_page();
    });
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

  function refresh_page(){
    if(currentPage==''){
      currentPage = "<?php echo url('/history-search/load-history-search') ?>";
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
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">History</div>

        <div class="card-body">
          <!--<form>
            @csrf       
            <div class="form-group row" style="margin-left: 1px;">
              <input id="keywords" class="form-control col-md-4 col-xs-12" name="search" placeholder="Masukkan nama/email...">
              <button type="button" class="btn btn-primary btn-search" style="margin-left: 13px; margin-right: 13px;"> Search </button>
            </div>
          </form>-->

          <table class="table table-bordered table-striped">
            <thead>
              <th class="header" action="username">
                Instagram
              </th>
              <th class="header" action="created_at">
                Date
              </th>
              <th>Action</th>
            </thead>

            <tbody id="content"></tbody>

          </table>

          <div id="pager"></div>

        </div>
      </div>
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
@endsection