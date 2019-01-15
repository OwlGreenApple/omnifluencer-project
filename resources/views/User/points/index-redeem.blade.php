@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  $(document).ready(function(){
    //get it if Status key found
    if(localStorage.getItem("success"))
    {
      $('#pesan').html('Redeem point berhasil');
      $('#pesan').removeClass('alert-warning');
      $('#pesan').addClass('alert-success');
      $('#pesan').show();

      localStorage.clear();
    }
});

  function redeem_point(){
    $.ajax({
        type : 'GET',
        url : "<?php echo url('/redeem-point') ?>",
        data: { 
          id: {{$idpoint}},
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
            localStorage.setItem("success",data.message)
            window.location.reload(); 
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
      <div id="pesan" class="alert"></div>  
      @if (session('success') )
        <div class="col-md-12 alert alert-success">
          <strong>Success!</strong> {{session('success')}}
        </div>
      @endif
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-point">
          <img src="https://via.placeholder.com/700x225">
          
          <div class="info-point">
            <h4><b>{{$namapaket}}</b></h4> 
            Description :
            <hr>

            @switch($idpoint)
              @case(1)
                1. Masa Berlaku 1 bulan <br>
                2. Dapat menampilkan 25 history search terakhir <br>
                3. Dapat melakukan save profile sebanyak 25 kali <br>
                4. Dapat melakukan compare untuk 2 akun <br>
                5. Dapat melakukan grouping <br>
                6. Dapat menyimpan dan mengirim report .pdf via email 
              @break
              @case(2)
                1. Masa berlaku 1 tahun <br>
                2. Dapat menampilkan 25 history search terakhir <br>
                3. Dapat melakukan save profile sebanyak 25 kali <br>
                4. Dapat melakukan compare untuk 2 akun <br>
                5. Dapat melakukan grouping <br>
                6. Dapat menyimpan dan mengirim report .pdf via email 
              @break
              @case(3)
                1. Masa berlaku 1 bulan <br>
                2. Dapat menampilkan history search tanpa batas (unlimited)<br>
                3. Dapat melakukan save profile tanpa batas (unlimited)<br>
                4. Dapat melakukan compare untuk 4 akun <br>
                5. Dapat melakukan grouping <br>
                6. Dapat menyimpan dan mengirim report .pdf via email <br>
                7. Dapat menyimpan dan mengirim report .xlsx via email 
              @break
              @case(4)
                1. Masa berlaku 1 tahun <br>
                2. Dapat menampilkan history search tanpa batas (unlimited)<br>
                3. Dapat melakukan save profile tanpa batas (unlimited)<br>
                4. Dapat melakukan compare untuk 4 akun <br>
                5. Dapat melakukan grouping <br>
                6. Dapat menyimpan dan mengirim report .pdf via email <br>
                7. Dapat menyimpan dan mengirim report .xlsx via email 
              @break
            @endswitch

          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <h4><b>Detail Kupon</b></h4>

      <div class="card">
        <div class="card-body">
          <h5><b>{{$point}} Points</b></h5>
          Point saya : <span class="sisapoin">{{Auth::user()->point}}</span>
          <br>
          <button class="btn btn-primary btn-block btn-redeem" data-toggle="modal" data-target="#confirm-redeem">
            Redeem
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $( "body" ).on( "click", "#btn-redeem-ok", function() {
    redeem_point();
  });
</script>

<!-- Modal Confirm Redeem -->
<div class="modal fade" id="confirm-redeem" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Redeem Point
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Redeem point?
      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-danger" id="btn-redeem-ok" data-dismiss="modal">
          Yes
        </button>
        <button class="btn" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
      
  </div>
</div>
@endsection