@extends('layouts.dashboard')

@section('content')
<link href="{{ asset('css/history-search.css') }}" rel="stylesheet">

<script type="text/javascript">
  var currentPage = '';

  $(document).ready(function() {
    //function saat klik pagination
    refresh_page();

    $('.formatted-date').datepicker({
      dateFormat: 'yy/mm/dd',
    });
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
        from : $('#from').val(),
        to : $('#to').val(),
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

  function delete_compare(){
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
          $('#pesan').html(data.message);
          $('#pesan').removeClass('alert-success');
          $('#pesan').addClass('alert-warning');
          $('#pesan').show();
        }
      }
    });
  }

  function delete_compare_bulk(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/compare-history/delete-bulk') ?>",
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

  function send_email (){
    if($('#sendemail').val()==''){
      $('#pesan').html('Silahkan isi email terlebih dahulu');
      $('#pesan').removeClass('alert-success');
      $('#pesan').addClass('alert-warning');
      $('#pesan').show();
    } else {
      $.ajax({
        type : 'GET',
        url : "<?php echo url('/send-email-compare') ?>",
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
    if ($(".checkcompareid:checked").length > 0){
      return true;
    } else {
      return false;
    }
  }
</script>

<style type="text/css">
  .icon-arrow{
    color: #2089F6;
  }
</style>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="row">
        <div class="col-md-8 col-6">
          <h2><b>Compare History</b></h2>      
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
            Show you previous history comparison
          </h5>    
        </div>

        <div class="col-12 menu-mobile" align="left">
          <button class="btn btn-sm btn-danger btn-delete-bulk" data-toggle="modal" data-target="#confirm-delete">
            <i class="far fa-trash-alt"></i> Delete
          </button>
        </div>
      </div>
      
      <hr>

      <div id="pesan" class="alert"></div>

      <br>  

      <form>
        <div class="row">
          <div class="form-inline col-md-7 mb-2">
            <label class="center-mobile mr-sm-2 pb-md-2" for="from">
              Dari
            </label>
            <input id="from" type="text" class="form-control form-control-sm mb-2 mr-sm-2 col-md-2 formatted-date" name="from">

            <label class="center-mobile mr-sm-2 pb-md-2" for="to">
              hingga
            </label>
            <input id="to" type="text" class="form-control form-control-sm mb-2 mr-sm-2 col-md-2 formatted-date" name="to">

            <label class="sr-only" for="keywords">
              Search
            </label>
            <input id="keywords" type="text" class="form-control form-control-sm col-md-3 mb-2 mr-sm-2" name="keywords" placeholder="username...">
                  
            <button type="button" class="btn btn-sm btn-sm-search btn-primary mb-2 btn-search">
              Search
            </button>
          </div>

          <div class="col-md-5 menu-nomobile" align="right">
            <button class="btn btn-sm btn-danger btn-delete-bulk" data-toggle="modal" data-target="#confirm-delete">
              <i class="far fa-trash-alt"></i> Delete
            </button>
          </div>    
        </div>
      
        <div class="check-mobile">
          <input class="checkAll" type="checkbox" name="checkAll"> Check All
        </div>

        <table class="table responsive">
          <thead>
            <th>
              <input class="checkAll" type="checkbox" name="checkAll">
            </th>
            <th class="header" action="username">
              Instagram
            </th>
            <th class="header" action="updated_at">
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
  $( "body" ).on( "click", ".btn-profile", function() {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    $('#email-type').val(type);
    $('#id-profile').val(id);

    if(type=='pdf'){
      $("#link-pdf").prop("href", "<?php echo url('print-pdf-compare')?>"+'/'+id+'/colorful');
      $('.send-pdf').show();
      $('.send-csv').hide();
    } else {
      $("#link-csv").prop("href", "<?php echo url('print-csv-compare')?>"+'/'+id);
      $('.send-csv').show();
      $('.send-pdf').hide();
    }
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
  
  $( "body" ).on( "click", "#btn-send", function() {
    send_email();
  });

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
    $('#delete_type').val('one'); 
  });

  $( "body" ).on( "click", ".btn-delete-bulk", function(e)
  {
    if(check_id()){
      $('#delete_type').val('bulk');
    } else {
      e.stopPropagation();
      $('#pesan').html('Pilih history terlebih dahulu');
      $('#pesan').removeClass('alert-success');
      $('#pesan').addClass('alert-warning');
      $('#pesan').show();   
    }
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    if($('#delete_type').val()=='bulk'){
      delete_compare_bulk();
    } else {
      delete_compare();
    }
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