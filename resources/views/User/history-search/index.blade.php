@extends('layouts.app')

@section('content')
<link href="{{ asset('css/history-search.css') }}" rel="stylesheet">

<script type="text/javascript">
  var currentPage = '';

  $(document).ready(function() {
    //function saat klik pagination
    refresh_page();
    
    $('#save-group').on('hidden.bs.modal', function () {
      $('#input-group').val('');
      $('#input-group').hide();
    });
  });

  function get_groups(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('history-search/get-groups') ?>",
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
        $('#list-group').html(data.view);

        $('#save-group').modal('show');
      }
    });
  }

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

  function add_groups(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/history-search/add-groups') ?>",
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
        } 
      }
    });
  }

  function create_groups(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/history-search/create-groups') ?>",
      data: { 
        groupname:$('#input-group').val() 
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
          $('#input-group').val('');
          $('#input-group').hide();
          get_groups();
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
          <div align="right"> 
            <button class="btn btn-primary" id="btn-compare">
              Compare
            </button>
            <button class="btn btn-primary" id="btn-save">
              Add to group
            </button>
            <button class="btn btn-primary" id="btn-save-global">
              Save
            </button>
            <button class="btn btn-danger">
              Delete
            </button>  
          </div>
          <br>  

          <form>
            <table class="table table-bordered table-striped">
              <thead>
                <th>
                  <input type="checkbox" name="checkAll" id="checkAll">
                </th>
                <th class="header" action="username">
                  Instagram
                </th>
                <th class="header" action="created_at">
                  Date
                </th>
                <th>Groups</th>
                <th>Action</th>
              </thead>

              <tbody id="content"></tbody>

            </table>

            <div id="pager"></div>    
          </form>
      
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

<!-- Modal Save Group -->
<div class="modal fade" id="save-group" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Save to group
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <button class="col-md-12" id="btn-create-group">
          + Create new group
        </button>
        
        <input class="col-md-12 form-control" type="text" name="input-group" id="input-group">

        <form id="form-groups">
          <div id="list-group"></div>
        </form>

      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-primary" id="btn-add-group" data-dismiss="modal">
          Add
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