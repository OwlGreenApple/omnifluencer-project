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
      currentPage = "<?php echo url('/compare-history/load-history-compare') ?>";
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
      url : "<?php echo url('/compare-history/delete') ?>",
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

<style type="text/css">
  .icon-arrow{
    color: #2089F6;
  }
</style>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">

      <h2><b>Compare History</b></h2>  
      
      <div class="row">
        <div class="col-md-5">
          <h5>
            Show you previous history comparison
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

      <form>
        <div class="form-inline mb-2">
          <label class="center-mobile mr-sm-2" for="from">
            <b>Dari</b>
          </label>
          <input id="from" type="text" class="form-control mb-2 mr-sm-2 col-md-2" name="from">

          <label class="center-mobile mr-sm-2" for="to">
            <b>hingga</b>
          </label>
          <input id="to" type="text" class="form-control mb-2 mr-sm-2" name="to">

          <div class="d-flex">
            <label class="sr-only" for="keywords">
              Search
            </label>
            <input id="keywords" type="text" class="form-control mb-2 mr-sm-2" name="keywords" placeholder="username...">
                
            <button class="btn btn-primary mb-2">
              Search
            </button>
          </div>
        </div>

        <div class="check-mobile">
          <input class="checkAll" type="checkbox" name="checkAll"> Check All
        </div>

        <table class="table">
          <thead align="center">
            <th>
              <input class="checkAll" type="checkbox" name="checkAll">
            </th>
            <th class="header" action="username">
              Instagram
            </th>
            <th class="header" action="created_at">
              Date
            </th>
            <th class="header">
              Action
            </th>
          </thead>
          <tbody id="content"></tbody>
        </table>

        <div id="pager"></div>    
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

  $(document).on('click', '.checkAll', function (e) {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    currentPage = $(this).attr('href');
    refresh_page();
  });
</script>
@endsection