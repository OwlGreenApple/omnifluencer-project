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
      currentPage = "<?php echo url('/groups/load-groups') ?>";
    } 

    $.ajax({
      type : 'GET',
      url : currentPage,
      data : {
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
        $('.pager').html(data.pager);
      }
    });
  }

  function delete_group(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/groups/delete-group') ?>",
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
          $('#pesan').addClass('alert-success');
          $('#pesan').removeClass('alert-warning');
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

  function delete_single_group(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/groups/delete-single-group') ?>",
      data: {
        id:$('#id_delete').val(),
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

          $('#pesan').html(data.message);
          $('#pesan').addClass('alert-success');
          $('#pesan').removeClass('alert-warning');
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

  function edit_group(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/groups/edit-group') ?>",
      data: {
        id:$('#id_edit').val(),
        name:$('#groupname').val(),
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

          $('#pesan').html(data.message);
          $('#pesan').addClass('alert-success');
          $('#pesan').removeClass('alert-warning');
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

  function check_id(){
    if ($(".groupcheckbox:checked").length > 0){
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
        <form class="form-inline col-md-12 mb-2" action="{{url('search')}}" method="POST">
          @csrf
          
          <label class="mr-sm-2 pb-md-2 label-calculate" for="calculate">
            Calculate More
          </label>

          <input id="calculate" type="text" class="form-control form-control-sm mb-2 mr-sm-2 mr-2 col-md-3 col-9" name="keywords" placeholder="Enter Instagram Username">

          <button type="submit" class="btn btn-sm btn-primary mb-2">
            Calculate
          </button>
        </form>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-8 col-12">
          <h2><b>Influencer Group</b></h2>    
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-5 col-12">
          <h5>
            Manage your saved groups
          </h5>      
        </div>
      </div>

      <hr>
      
      <div id="pesan" class="alert"></div>

      <br>

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
        <div class="col-md-6 menu-nomobile">
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

      <form>
        <table class="table responsive">
          <thead>
            <th>
              <input class="checkAll" type="checkbox" name="checkAll">
            </th>
            <th class="menu-mobile">
              Select / De-select All
            </th>
            <th class="menu-nomobile">
              Groups 
            </th>
            <th class="menu-nomobile">
              Date Created 
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
        <input type="hidden" name="id_delete" id="id_delete">
        <input type="hidden" name="type" id="type">
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

<!-- Modal Confirm Payment -->
<div class="modal fade" id="edit-group" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Edit Group
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id_edit" id="id_edit">

        <div class="form-group row">
          <label class="col-md-3 col-12">
            <b>Nama Grup</b>
          </label>
          
          <div class="col-md-6 col-12">
            <input type="text" id="groupname" class="form-control" name="groupname">
          </div> 
        </div>

        <div class="clearfix mb-3"></div>

      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-primary" id="btn-edit-ok" data-dismiss="modal">
          Edit
        </button>
        <button class="btn" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
      
  </div>
</div>

<script type="text/javascript">
  $( "body" ).on( "click", ".btn-edit", function() {
      $('#groupname').val($(this).attr('data-name'));
      $('#id_edit').val($(this).attr('data-id'));
  });

  $( "body" ).on( "click", "#btn-edit-ok", function() {
      edit_group();
  });

  $( "body" ).on( "click", ".btn-search", function() {
    refresh_page();
  });

  $( "body" ).on( "click", ".btn-apply", function() {
    var action = $('.opsi-action1').val();
    switch(action){
      case 'Delete' :
        if(!check_id()){
          $('#pesan').html('Pilih group terlebih dahulu');
          $('#pesan').removeClass('alert-success');
          $('#pesan').addClass('alert-warning');
          $('#pesan').show();
        } else {
          $('#type').val('bulk');
          $('#confirm-delete').modal('show');
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

  $( "body" ).on( "click", ".btn-delete", function(e) {
    $('#type').val('single');
    $('#id_delete').val($(this).attr('data-id'));
  });

  $( "body" ).on( "click", ".btn-delete-bulk", function(e) {
    $('#type').val('bulk');

    if(!check_id()){
      e.stopPropagation();
      $('#pesan').html('Pilih group terlebih dahulu');
      $('#pesan').removeClass('alert-success');
      $('#pesan').addClass('alert-warning');
      $('#pesan').show();
    }
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    if($('#type').val()=='bulk'){
      delete_group();
    } else {
      delete_single_group();
    }
  });

  $(document).on('click', '.checkAll', function (e) {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    currentPage = $(this).attr('href');
    refresh_page();
  });

  /*$( "body" ).on( "dblclick", ".div-group", function() {
    console.log('check');
    $(this).find('.groupcheck').prop('checked', true);

    var idgroup = $(this).attr('data-id');
    var groupname = $(this).attr('data-name');

    window.location.href = "<?php echo url('groups') ?>"+'/'+idgroup+'/'+groupname;
  });*/
</script>
@endsection