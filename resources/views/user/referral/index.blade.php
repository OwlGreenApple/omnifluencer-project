@extends('layouts.app')

@section('content')
<script type="text/javascript">
  var currentPage = '';

  $(document).ready(function() {
    //function saat klik pagination
    refresh_page();
    $(document).on('click', '.pagination a', function (e) {
      e.preventDefault();
      currentPage = $(this).attr('href');
      refresh_page();
    });
  });

  $( "body" ).on( "click", ".btn-search", function() {
    currentPage = '';
    refresh_page();
  });

  function refresh_page(){
    if(currentPage==''){
      currentPage = "<?php echo url('/referral/load-referral') ?>";
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

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Referral</div>

        <div class="card-body">
          <form>
            @csrf
            <div class="form-group row" style="margin-left: 1px;">
              <p>Your referral link : 
                <a href="{{ url('/ref/'.$user->referral_link) }}" style="word-break: break-all;">{{ url('/ref/'.$user->referral_link) }}</a>
              </p>
            </div>          
            <div class="form-group row" style="margin-left: 1px;">
              <input id="keywords" class="form-control col-md-4 col-xs-12" name="search" placeholder="Masukkan nama/email...">
              <button type="button" class="btn btn-primary btn-search" style="margin-left: 13px; margin-right: 13px;"> Search </button>
            </div>
          </form>

          <table class="table table-bordered table-striped">
            <thead>
              <th class="header" action="name">Full Name</th>
              <th class="header" action="email">Email</th>
            </thead>

            <tbody id="content"></tbody>

          </table>

          <div id="pager"></div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection