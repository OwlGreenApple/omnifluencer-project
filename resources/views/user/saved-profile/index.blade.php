@extends('layouts.dashboard')

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
      currentPage = "<?php echo url('/saved-profile/load-accounts') ?>";
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

        $('.tooltipstered').tooltipster({
          contentAsHTML: true,
          trigger: 'ontouchstart' in window || navigator.maxTouchPoints ? 'click' : 'hover',
        });
      }
    });
  }

  function delete_profile(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/saved-profile/delete') ?>",
      headers: {
        'X-CSRFToken': $('meta[name="token"]').attr('content')
      },
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
          $('#pesan').html(data.message);
          $('#pesan').removeClass('alert-success');
          $('#pesan').addClass('alert-warning');
          $('#pesan').show();
        }
      }
    });
  }

  function delete_profile_bulk(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/saved-profile/delete-bulk') ?>",
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
        } else {
          $('#pesan').html(data.message);
          $('#pesan').removeClass('alert-success');
          $('#pesan').addClass('alert-warning');
          $('#pesan').show();
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

          $('#pesan').html(data.message);
          $('#pesan').removeClass('alert-warning');
          $('#pesan').addClass('alert-success');
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

  function send_email (){
    if($('#sendemail').val()==''){
      $('#pesan').html('Silahkan isi email terlebih dahulu');
      $('#pesan').removeClass('alert-success');
      $('#pesan').addClass('alert-warning');
      $('#pesan').show();
    } else {
      $.ajax({
        type : 'GET',
        url : "<?php echo url('/send_email') ?>",
        data: { 
          email: $('#sendemail').val(),
          id: $('#id-profile').val(),
          type: $('#email-type').val(),
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
            $('#pesan').html(data.message);
            $('#pesan').removeClass('alert-warning');
            $('#pesan').addClass('alert-success');
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
  }

  function check_id(){
    if ($(".checkaccid:checked").length > 0){
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
          <h2><b>Saved Profile</b></h2>  
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
            Select bulk action, save or add it to group
          </h5>    
        </div>

        <div <div class="col-12 menu-mobile" align="left">
          <button class="btn btn-sm btn-primary btn-save">
            <i class="fas fa-folder-plus"></i> 
            Add to group
          </button>
          <button class="btn btn-sm btn-danger btn-delete-bulk" data-toggle="modal" data-target="#confirm-delete">
            <i class="far fa-trash-alt"></i> Delete
          </button>     
        </div>
      </div>
    
      <hr>

      <div id="pesan" class="alert"></div>

      <br>  

      <form>
        <div class="check-mobile">
          <input class="checkAll" type="checkbox" name="checkAll"> Check All
        </div>

        <div class="row">
          <div class="col-md-12 mb-2 menu-nomobile" align="right">
            <button class="btn btn-sm btn-primary btn-save">
              <i class="fas fa-folder-plus"></i> 
              Add to group
            </button>
            <button class="btn btn-sm btn-danger btn-delete-bulk" data-toggle="modal" data-target="#confirm-delete">
              <i class="far fa-trash-alt"></i> Delete
            </button>  
          </div>
        </div>

        <table class="table responsive">
          <thead>
            <th>
              <input class="checkAll" type="checkbox" name="checkAll">
            </th>
            <th class="header" action="username">
              Instagram
            </th>
            <th class="header" action="created_at">
              Saved Date
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

        <input type="hidden" name="id_delete" id="id_delete">
        <input type="hidden" name="delete_type" id="delete_type">
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

<!-- Modal Send File -->
<div class="modal fade" id="send-file" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Download or Send to
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="email-type" id="email-type">
        <input type="hidden" name="id-profile" id="id-profile">

        <div class="container">
          <div class="send-pdf mb-4">
            <i class="fas fa-file-pdf"></i>
            PDF Download 

            <form class="row" id="formPDF">
              <div class="col-md-9 col-8">
                <select name="type" class="form-control">
                  <option value="colorful">
                    Colorful
                  </option>
                  <option value="plain">
                    Plain
                  </option>
                </select>  
              </div>
              
              <div class="col-md-3 col-4">
                <a id="link-pdf" href="#" target="_blank">
                  <button type="button" class="btn btn-primary float-right"> 
                    Download
                  </button>
                </a>  
              </div>
            </form>
          </div>

          <div class="send-csv mb-4" style="display: none;">
            <i class="fas fa-file-excel"></i>
            Excel Download 

            <a id="link-csv" href="#" target="_blank">
              <button class="btn btn-primary float-right"> 
                Download
              </button>
            </a>
          </div>
        
          <hr>

          <label>Send to</label>
          <input type="text" name="sendemail" class="form-control mb-2" placeholder="email address..." id="sendemail">
          <button class="btn btn-primary" id="btn-send" data-dismiss="modal">
            Send
          </button>
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

  $( "body" ).on( "click", ".btn-delete", function() {
    $('#id_delete').val($(this).attr('data-id'));
    $('#delete_type').val('one');
  });

  $( "body" ).on( "click", ".btn-delete-bulk", function(e)
  {
    if(check_id()){
      $('#delete_type').val('bulk');
    } else {
      e.stopPropagation();
      $('#pesan').html('Pilih akun terlebih dahulu');
      $('#pesan').addClass('alert-warning');
      $('#pesan').removeClass('alert-success');
      $('#pesan').show();
    }
  });

  $(document).on( "change", ".checkaccid", function() {
    var id = $(this).attr('data-id');
    $(".checksaveid-"+id).prop('checked',this.checked);
  });

  $( "body" ).on( "click", ".btn-profile", function() {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    $('#email-type').val(type);
    $('#id-profile').val(id);

    if(type=='pdf'){
      $("#link-pdf").prop("href", "<?php echo url('print-pdf')?>"+'/'+id+'/colorful');
      $('.send-pdf').show();
      $('.send-csv').hide();
    } else {
      $("#link-csv").prop("href", "<?php echo url('print-csv')?>"+'/'+id);
      $('.send-csv').show();
      $('.send-pdf').hide();
    }
  });

  $( "body" ).on( "click", "#btn-send", function() {
    send_email();
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    if($('#delete_type').val()=='bulk'){
      delete_profile_bulk();
    } else {
      delete_profile();
    }
  });

  $( "body" ).on( "click", ".btn-save", function() {
    get_groups();
  });

  $( "body" ).on( "click", "#btn-add-group", function() {
    if(check_id()){
      add_groups();
    } else {
      $('#save_group').modal('hide');
      $('#pesan').html('Pilih akun terlebih dahulu');
      $('#pesan').addClass('alert-warning');
      $('#pesan').removeClass('alert-success');
      $('#pesan').show();
    }
  });

  $( "body" ).on( "click", "#btn-create-group", function() {
    $('#input-group').show();
    $("#input-group").focus();
  });

  $( "body" ).on( "change", "select", function()
  {
    var text = $("#link-pdf").attr('href');
    var parts = text.split('/');
    var loc = parts.pop();
    var new_text = parts.join('/');

    $("#link-pdf").prop("href", new_text+'/'+ this.value);
    //alert( this.value );
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