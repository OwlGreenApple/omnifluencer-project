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
      currentPage = "<?php echo url('/groups/load-list-group') ?>";
    } 

    $.ajax({
      type : 'GET',
      url : currentPage,
      data : {
        id:{{$id_group}},
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

  function send_email_bulk(){
    if($('#sendemail').val()==''){
      $('#pesan').html('Silahkan isi email terlebih dahulu');
      $('#pesan').removeClass('alert-success');
      $('#pesan').addClass('alert-warning');
      $('#pesan').show();
    } else {
      var myObject = { 
        email: $('#sendemail').val(),
        type: $('#email-type').val(),
      };

      $.ajax({
        type : 'GET',
        url : "<?php echo url('/send-email-bulk') ?>",
        data: $('form').serialize()+'&'+$.param(myObject),
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

  function delete_member(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/groups/delete-member') ?>",
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

  function delete_member_bulk(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/groups/delete-member-bulk') ?>",
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
</script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">

      <h2><b>Group - {{$group_name}}</b></h2>  
      
      <div class="row">
        <div class="col-md-5">
          <h5>
            Manage your saved group
          </h5>    
        </div>

        <div class="col-md-7" align="right">
          <button class="btn btn-primary btn-pdf" data-toggle="modal" data-target="#send-file">
            <i class="fas fa-file-pdf"></i> PDF
          </button>
          <button class="btn btn-primary btn-csv" data-toggle="modal" data-target="#send-file">
            <i class="fas fa-file-excel"></i> Excel
          </button>
          <button class="btn btn-danger btn-delete-bulk" data-toggle="modal" data-target="#confirm-delete">
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

        <table class="table">
          <thead align="center">
            <th>
              <input type="checkbox" name="checkAll" class="checkAll"\>
            </th>
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
        <input type="hidden" name="send-type" id="send-type">
        <input type="hidden" name="id-profile" id="id-profile">

        <div class="container">
          <div class="send-pdf mb-4">
            <i class="fas fa-file-pdf"></i>
            PDF Download 

            <a id="link-pdf" href="#" target="_blank">
              <button class="btn btn-primary float-right"> 
                Download
              </button>
            </a>
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
    $('#send-type').val('one');
    $('#id-profile').val(id);

    if(type=='pdf'){
      $("#link-pdf").prop("href", "<?php echo url('print-pdf')?>"+'/'+id);
      $('.send-pdf').show();
      $('.send-csv').hide();
    } else {
      $("#link-csv").prop("href", "<?php echo url('print-csv')?>"+'/'+id);
      $('.send-csv').show();
      $('.send-pdf').hide();
    }
  });

  $( "body" ).on( "click", ".btn-pdf", function() {
    $('#email-type').val('pdf');
    $('#send-type').val('bulk');

    $("#link-pdf").prop("href", "<?php echo url('print-pdf-bulk')?>"+'?'+$('form').serialize());
    $('.send-pdf').show();
    $('.send-csv').hide();
  });

  $( "body" ).on( "click", ".btn-csv", function() {
    $('#email-type').val('csv');
    $('#send-type').val('bulk');

    $("#link-csv").prop("href", "<?php echo url('print-csv-bulk')?>"+'?'+$('form').serialize());
    $('.send-csv').show();
    $('.send-pdf').hide();
  });

  $( "body" ).on( "click", "#btn-send", function() {
    if($('#send-type').val()=='one'){
      send_email();
    } else {
      send_email_bulk();
    }
  });
  
  $( "body" ).on( "click", ".btn-delete", function() {
    $('#id_delete').val($(this).attr('data-id'));
    $('#delete_type').val('one');
  });

  $( "body" ).on( "click", ".btn-delete-bulk", function()
  {
    $('#delete_type').val('bulk');
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    if($('#delete_type').val()=='bulk'){
      delete_member_bulk();
    } else {
      delete_member();
    }
  });

  $(document).on('click', '.checkAll', function (e) {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

  $(document).on( "change", ".checkaccid", function() {
    var id = $(this).attr('data-id');
    $(".checksaveid-"+id).prop('checked',this.checked);
  });

  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    currentPage = $(this).attr('href');
    refresh_page();
  });
</script>
@endsection