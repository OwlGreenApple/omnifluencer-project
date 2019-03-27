@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  var table;
  var tablePoin;
  var tableRefer;
  var tableLog;

  $(document).ready(function() {
    //function saat klik pagination
    table = $('#myTable').DataTable({
      destroy: true,
      "order": [],
    });
    $.fn.dataTable.moment( 'ddd, DD MMM YYYY' );

    tablePoin = $('#tablePoin').DataTable({
      destroy: true,
      "order": [],
    });
    $.fn.dataTable.moment( 'ddd, DD MMM YYYY' );

    tableRefer = $('#tableRefer').DataTable({
      destroy: true,
      "order": [],
    });
    $.fn.dataTable.moment( 'ddd, DD MMM YYYY' );    

    tableLog = $('#tableLog').DataTable({
      destroy: true,
      "order": [],
    });
    $.fn.dataTable.moment( 'ddd, DD MMM YYYY' );

    refresh_page();

    $('.formatted-date').datepicker({
      dateFormat: 'yy/mm/dd',
    });
  });

  function refresh_page(){
    table.destroy();

    $.ajax({
      type : 'GET',
      url : "<?php echo url('/list-user/load-user') ?>",
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

        table = $('#myTable').DataTable({
                destroy: true,
                "order": [],
            });

      }
    });
  }

  function get_point_log(){
    tablePoin.destroy();

    $.ajax({
      type : 'GET',
      url : "<?php echo url('/list-user/point-log') ?>",
      data : { id : $('#idpoin').val() },
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
        $('#content-poin').html(data.view);

        tablePoin = $('#tablePoin').DataTable({
                      destroy: true,
                      "order": [],
                  });
      }
    });
  }

  function get_referral_log(){
    tableRefer.destroy();
    
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/list-user/referral-log') ?>",
      data : { id:$('#idrefer').val() },
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
        $('#content-referral').html(data.view);

        tableRefer = $('#tableRefer').DataTable({
                      destroy: true,
                      "order": [],
                  });
      }
    });  
  }

  function get_log(){
    tableLog.destroy();

    $.ajax({
      type : 'GET',
      url : "<?php echo url('/list-user/view-log') ?>",
      data : { id : $('#idlog').val() },
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
        $('#content-log').html(data.view);

        tableLog = $('#tableLog').DataTable({
                      destroy: true,
                      "order": [],
                  });
      }
    });
  }
</script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">

      <h2><b>Users</b></h2>  
      
      <h5>
        Show you all users
      </h5>
      
      <hr>

      <div id="pesan" class="alert"></div>

      <br>  

      <form>
        <table class="table" id="myTable">
          <thead align="center">
            <th class="header" action="name">
              Nama
            </th>
            <th class="header" action="email">
              Email
            </th>
            <th class="header" action="username">
              Username
            </th>
            <th class="header" action="point">
              Total Poin
            </th>
            <th class="header" action="membership">
              Membership
            </th>
            <th class="header" action="valid_until">
              Valid Until
            </th>
            <th>
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

<!-- Modal Point Log -->
<div class="modal fade" id="point-log" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Point Log
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="idpoin" id="idpoin">

        <table class="table" id="tablePoin">
          <thead align="center">
            <th>Poin Before</th>
            <th>Poin After</th>
            <th>Jumlah Poin</th>
            <th>Keterangan</th>
            <th>Created_at</th>
          </thead>
          <tbody id="content-poin"></tbody>
        </table>
      </div>
    </div>
      
  </div>
</div>

<!-- Modal Referral -->
<div class="modal fade" id="referral-log" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Referral
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table" id="tableRefer">

          <input type="hidden" name="idrefer" id="idrefer">

          <thead align="center">
            <th>Name</th>
            <th>Email</th>
            <th>Created_at</th>
          </thead>
          <tbody id="content-referral"></tbody>
        </table>
      </div>
    </div>
      
  </div>
</div>

<!-- Modal View Log -->
<div class="modal fade" id="view-log" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Log
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table" id="tableLog">

          <input type="hidden" name="idlog" id="idlog">

          <thead align="center">
            <th>Type</th>
            <th>Value</th>
            <th>Keterangan</th>
            <th>Created_at</th>
          </thead>
          <tbody id="content-log"></tbody>
        </table>
      </div>
    </div>
      
  </div>
</div>

<script type="text/javascript">
  $( "body" ).on( "click", ".btn-poin", function() {
    $('#idpoin').val($(this).attr('data-id'));
    get_point_log();
  });

  $( "body" ).on( "click", ".btn-referral", function() {
    $('#idrefer').val($(this).attr('data-id'));
    get_referral_log();
  });  

  $( "body" ).on( "click", ".btn-log", function() {
    $('#idlog').val($(this).attr('data-id'));
    get_log();
  });  
</script>
@endsection