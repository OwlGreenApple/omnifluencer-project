@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  var table;
  var tableLog;

  $(document).ready(function() {
    table = $('#myTable').DataTable({
      responsive : true,
      destroy: true,
      "order": [],
      /*"aoColumnDefs": [
        { "iDataSort": 3, "aTargets": [ 2 ] },
        { "iDataSort": 5, "aTargets": [ 4 ] },
      ],*/
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
                responsive : true,
                destroy: true,
                "order": [],
                /*"aoColumnDefs": [
                  { "iDataSort": 3, "aTargets": [ 2 ] },
                  { "iDataSort": 5, "aTargets": [ 4 ] }
                ],*/
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
            <th data-priority="1" class="header all" action="username">
              Instagram
            </th>
            <th class="header all" action="eng_rate">
              Eng. Rate
            </th>
            <th class="header all" action="total_influenced">
              Total Influenced
            </th>
            <th class="never">
              Total Inf
            </th>
            <th class="header all" action="jml_followers">
              Followers
            </th>
            <th class="never">
              Follower
            </th>
            <th class="header none" action="jml_following">
              Following
            </th>
            <th class="header none" action="jml_post">
              Post
            </th>
            <th class="header none" action="lastpost">
              Last Post
            </th>
            <th class="header none" action="jml_likes">
              Avg Likes
            </th>
            <th class="header none" action="jml_comments">
              Avg Comments
            </th>
            <th class="header all" action="total_calc">
              Total Search
            </th>
            <th class="header all" action="total_compare">
              Total Compare
            </th>
            <th class="header all">
              Total Saved
            </th>
            <th class="header all">
              Total Group
            </th>
            <th class="header none" action="created_at">
              Created_at
            </th>
            <th class="all" data-priority="2">
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