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
        act : act,
        status : status,
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
        $('.pager').html(data.pager);
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
        <!--<form class="form-inline col-md-12 mb-2" action="{{url('search')}}" method="POST">
          @csrf
          
          <label class="mr-sm-2 pb-md-2 label-calculate" for="calculate">
            Calculate More
          </label>

          <input id="calculate" type="text" class="form-control form-control-sm mb-2 mr-sm-2 mr-2 col-md-3 col-9" name="keywords" placeholder="Enter Instagram Username">

          <button type="submit" class="btn btn-sm btn-primary mb-2">
            Calculate
          </button>
        </form>-->

        <form class="form-inline col-md-12 mb-2" action="{{url('click-compare')}}" method="GET">
          @csrf
          <button type="submit" class="btn btn-primary">
            Click to compare
          </button>  
        </form>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-8 col-12">
          <h2><b>Compare History</b></h2>      
        </div>
      </div>
      
      
      <div class="row">
        <div class="col-md-5 col-12">
          <h5>
            Show you previous history comparison
          </h5>    
        </div>
      </div>
      
      <hr>

      <div id="pesan" class="alert"></div>

      <br>  

      <form>
        <div class="row mb-lg-0 mb-3">
          <div class="col-lg-6 col-md-12 mb-2 order-lg-0 order-1">
            <div class="row">
              <label class="col-lg-1 pb-lg-3 text-left col-5 order-0 order-lg-0" for="from">
                Dari
              </label>

              <div class="mb-2 col-lg-3 col-md-5 col-5 order-2 order-lg-1">
                <input id="from" type="text" class="form-control form-control-sm formatted-date" name="from" autocomplete="off">
              </div>
              
              <label class="col-7 col-lg-1 pb-lg-3 pb-sm-none order-1 order-lg-2 text-left pl-lg-0 pr-lg-0" for="to">
                hingga
              </label>

              <div class="mb-2 col-5 col-md-5 col-lg-3 order-3 order-lg-3">
                <input id="to" type="text" class="form-control form-control-sm formatted-date" name="to" autocomplete="off">  
              </div>
              
              <div class="col-2 order-4 order-md-4" style="padding-left:0px;">
                <button type="button" class="btn btn-sm btn-sm-search btn-success btn-search">
                  Filter
                </button>  
              </div>
            </div>
          </div> 

          <div class="col-lg-6 col-md-12 mb-2 order-lg-1 order-0"> 
            <div class="row">
              <div class="col-lg-10 col-md-10 col-10 pr-lg-0">
                <input id="keywords" type="text" class="form-control form-control-sm mb-2 mr-sm-2 col-lg-5 float-lg-right" name="keywords" placeholder="username...">  
              </div>

              <div class="col-lg-2 col-md-2 col-2 pl-0">
                <button type="button" class="btn btn-sm btn-sm-search btn-success mb-2 btn-search">
                  Search
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="col-md-6 menu-nomobile mb-2">
            <button class="btn btn-sm btn-danger btn-delete-bulk" data-toggle="modal" data-target="#confirm-delete">
              <i class="far fa-trash-alt"></i> Delete
            </button>     
          </div>

          <div class="col-lg-6 col-md-12 col-12" align="right">
            <div class="pager"></div>
          </div> 
        </div>

        <div class="mb-3 mt-3 menu-mobile">
          <div class="row">
            <div class="col-6">
              <select class="form-control form-control-sm opsi-action1">
                <option>Delete</option>
              </select>
            </div>

            <div class="col-2 pl-0">
              <button type="button" class="btn btn-primary btn-sm btn-apply">
                Apply
              </button>
            </div>
          </div>
        </div>

        <table class="table responsive">
          <thead>
            <th>
              <input class="checkAll" type="checkbox" name="checkAll">
            </th>
            <th class="menu-mobile">
              Select / De-select All
            </th>
            <th class="menu-nomobile">
              Instagram
            </th>
            <th class="menu-nomobile header" action="updated_at">
              Date
            </th>
            <th>
              Action
            </th>
          </thead>
          <tbody id="content"></tbody>
        </table>
      </form>

      <div class="row"> 
        <div class="col-md-6 menu-nomobile">
          <button class="btn btn-sm btn-danger btn-delete-bulk" data-toggle="modal" data-target="#confirm-delete">
            <i class="far fa-trash-alt"></i> Delete
          </button>  
        </div>

        <div class="col-12 mb-4 menu-mobile">
          <div class="row">
            <div class="col-6">
              <select class="form-control form-control-sm opsi-action2">
                <option>Delete</option>
              </select>
            </div>

            <div class="col-2 pl-0">
              <button type="button" class="btn btn-primary btn-sm btn-apply">
                Apply
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-12 col-12" align="right">
          <div class="pager"></div>
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
        Anda yakin ingin menghapus?

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
  $( "body" ).on( "click", ".btn-apply", function() {
    var action = $('.opsi-action1').val();
    switch(action){
      case 'Delete' :
        if(check_id()){
          $('#delete_type').val('bulk');
          $('#confirm-delete').modal('show');
        } else {
          $('#pesan').html('Pilih history terlebih dahulu');
          $('#pesan').removeClass('alert-success');
          $('#pesan').addClass('alert-warning');
          $('#pesan').show();   
        }
      break;
    }
  });

  $( "body" ).on( "change", ".opsi-action1,.opsi-action2", function() {
    $('.opsi-action1').val($(this).val());
    $('.opsi-action2').val($(this).val());
  });

  $( "body" ).on( "click", ".view-details", function() {
    var id = $(this).attr('data-id');

    $('.details-'+id).toggleClass('d-none');
  });

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