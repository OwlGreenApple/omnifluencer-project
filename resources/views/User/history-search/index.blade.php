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

        $('.tooltipstered').tooltipster({
          contentAsHTML: true,
          trigger: 'ontouchstart' in window || navigator.maxTouchPoints ? 'click' : 'hover',
        });
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
    <div class="col-md-11">

      <h2><b>History</b></h2>  
      
      <div class="row">
        <div class="col-md-5 col-12 mb-10">
          <h5>
            Select bulk action, save or add it to group
          </h5>    
        </div>

        <div class="col-md-7 col-12" align="right">
          <button class="btn btn-primary mb-10" id="btn-compare">
            <i class="fas fa-chart-bar"></i>
            Compare
          </button>
          <button class="btn btn-primary mb-10" id="btn-save">
            <i class="fas fa-folder-plus"></i> 
            Add to group
          </button>
          <button class="btn btn-primary mb-10" id="btn-save-global">
            <i class="fas fa-save"></i> 
            Save
          </button>
          <button class="btn btn-danger mb-10">
            <i class="far fa-trash-alt"></i> Delete
          </button>     
        </div>
      </div>
      
      <div class="card col-md-12" style="display: none;">
        <div class="card-body row">
          <div class="col-md-1" align="center">  
            <i class="fas fa-exclamation-circle icon-exclamation" style="font-size:30px;color:#FF8717;"></i>
          </div>
          <div class="col-md-11"> 
            <h4><b>Info for Free Member</b></h4>  
            * <b>Free Member</b> hanya dapat menampilkan 10 history pencarian terakhir<br>  
            * <b>Free Member</b> tidak dapat mengelompokkan ke dalam suatu grup dari hasil pencarian <br>  
            * <b>Free Member</b> hanya mendapatkan file .CSV sesuai dengan 10 history pencarian terakhir <br> 
            <br>  
            ** <b>UPGRADE</b> akun Anda untuk mendapatkan banyak kelebihan. Info lebih lanjut, silahkan klik tombol berikut. <button class="btn btn-primary"><i class="fas fa-star"></i> Upgrade To Pro</button>
          </div>
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

          <label class="sr-only" for="keywords">
            Search
          </label>
          <input id="keywords" type="text" class="form-control mb-2 mr-sm-2" name="keywords" placeholder="username...">
              
          <button class="btn btn-primary mb-2">
            Search
          </button>
        </div>

        <div class="check-mobile">
          <input class="checkAll" type="checkbox" name="checkAll"> Check All
        </div>

        <table class="table">
          <thead>
            <th>
              <input class="checkAll" type="checkbox" name="checkAll">
            </th>
            <th class="header" action="username">
              Instagram
            </th>
            <th class="header" action="eng_rate">
              Eng. Rate
            </th>
            <th class="header" action="jml_followers">
              Followers
            </th>
            <th class="header" action="jml_post">
              Posts
            </th>
            <th>Groups</th>
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
        Apakah Anda yakin untuk menghapus histori ini?
      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-danger" id="btn-delete-ok" data-dismiss="modal">
          Delete
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