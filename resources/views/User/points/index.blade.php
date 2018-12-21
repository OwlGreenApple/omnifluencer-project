@extends('layouts.dashboard')

@section('content')
<style type="text/css">
  .card-header.membership {
    background-image: linear-gradient(-225deg, #13A5F5 0%, #4ABAF1 45%, #13A5F5 100%);
  }
</style>
<script type="text/javascript">
  var currentPage = '';

  $(document).ready(function() {
    //function saat klik pagination
    refresh_page();
    
  });

  function refresh_page(){
    if(currentPage==''){
      currentPage = "<?php echo url('/points/load-points') ?>";
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

</script>

<style type="text/css">
  .profpic {
    width: 70px;
    border-radius: 50%;
  }
</style>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">

      <div class="row">
        <div class="col-md-7">
          <div class="card">  
            <div class="card-body">
              <img class="profpic" src="<?php echo Auth::user()->prof_pic ?>">
              <span>{{Auth::user()->name}}</span><br>
              
            </div>
          </div>
        </div>  

        <div class="col-md-5">
          <div class="card">  
            <div class="card-header membership" align="center">
              <h3>PRO MEMBER</h3>
            </div>
            <div class="card-body">
              
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="card col-md-12">
        <div class="card-bpdy">
          <i class="fas fa-exclamation-circle"></i>
        </div>
      </div>

      <br>

      <h2><b>Point History</b></h2>  
      <h5>
        Check your earn point activity
      </h5>    
      <hr>

      <br>  

      <table class="table">
        <thead align="center">
          <th class="header" action="created_at">
            Date
          </th>
          <th class="header" action="keterangan">
            Description
          </th>
          <th class="header" action="jml_point">
            Points
          </th>
        </thead>
        <tbody id="content"></tbody>
      </table>

      <div id="pager"></div>    
      
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