@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  var table;
  var tableLog;

  $(document).ready(function() {
    table = $('#myTable').DataTable({
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
      url : "<?php echo url('/list-account/load-account') ?>",
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

  function view_log(){
    tableLog.destroy();

    $.ajax({
      type : 'GET',
      url : "<?php echo url('/list-account/view-log') ?>",
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

      <h2><b>Accounts</b></h2>  
      
      <h5>
        Show you all accounts
      </h5>
      
      <hr>

      <div id="pesan" class="alert"></div>

      <br>  

      <form>
        <table class="table" id="myTable">
          <thead align="center">
            <th class="header" action="username">
              Instagram
            </th>
            <th class="header" action="eng_rate">
              Eng. Rate
            </th>
            <th class="header" action="total_influenced">
              Total Influenced
            </th>
            <th class="header" action="jml_followers">
              Followers
            </th>
            <th class="header" action="jml_following">
              Following
            </th>
            <th class="header" action="jml_post">
              Post
            </th>
            <th class="header" action="lastpost">
              Last Post
            </th>
            <th class="header" action="jml_likes">
              Avg Likes
            </th>
            <th class="header" action="jml_comments">
              Avg Comments
            </th>
            <th class="header" action="created_at">
              Created_at
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

<!-- Modal View Log -->
<div class="modal fade" id="view-log" role="dialog">
  <div class="modal-dialog modal-lg">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Account Log
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="idlog" id="idlog">

        <table class="table" id="tableLog">
          <thead align="center">
            <th>Eng Rate</th>
            <th>Total Influenced</th>
            <th>Followers</th>
            <th>Following</th>
            <th>Post</th>
            <th>Last Post</th>
            <th>Avg Likes</th>
            <th>Avg Comments</th>
            <th>Created_at</th>
          </thead>
          <tbody id="content-log"></tbody>
        </table>
      </div>
    </div>
      
  </div>
</div>

<script type="text/javascript">
  $( "body" ).on( "click", ".btn-search", function() {
    currentPage = '';
    refresh_page();
  });

  $( "body" ).on( "click", ".btn-log", function() {
    $('#idlog').val($(this).attr('data-id'));
    view_log();
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