@extends('layouts.dashboard')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <h2><b>Transfer</b></h2>  
      <h5>Show all transfers from users</h5>
        
      <hr>

      <p><a class="btn btn-warning" data-toggle="modal" data-target="#add-coupon">Add Coupon</a></p>
        <table class="table table-responsive" id="coupon_table">
          <thead align="center">
            <th>No</th>
            <th>No Rekening</th>
            <th>Proses</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
          </thead>
          <tbody id="data-content"></tbody>
        </table>
    </div>
  </div>

<!-- end container -->  
</div>

<!-- Modal Add Coupons -->
<div class="modal fade" id="details" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Detail Transfer
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
         <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Nama Bank:</label>
              <b><span class="service_name"></span></b>
            </div>
          </div> 
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Kode Bank:</label>
              <b><span class="service_code"></span></b>
            </div>
          </div> 
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">No Rekening:</label>
              <b><span class="account_number"></span></b>
            </div>
          </div>  
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Pemilik Akun:</label>
              <b><span class="account_name"></span></b>
            </div>
          </div> 
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Waktu Transaksi:</label>
              <b><span class="data_time"></span></b>
            </div>
          </div> 
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Tipe Transfer:</label>
              <b><span class="data_type"></span></b>
            </div>
          </div> 
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Jumlah Transfer:</label>
              <b><span class="data_amount"></span></b>
            </div>
          </div> 
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Jumlah Balance:</label>
              <b><span class="data_balance"></span></b>
            </div>
          </div>  
          <div class="row">
            <div class="form-group col-md-12">
              <label for="Name">Deskripsi:</label>
              <b><span class="data_desc"></span></b>
            </div>
          </div> 
        
      <!-- end modal body -->      
      </div>

      <div class="modal-footer">
        <button class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
      
  </div>
</div>
<!-- end modal -->

<script type="text/javascript">
  var table;
  $(document).ready(function() {
    getData();
    getDetail();
  });

 /* Convert regular table to dataTable */
 function getData()
  {
    $.ajax({
      type : "GET",
      url : "{{route('getdatatransfer')}}",
      dataType : "html",
      success : function(data){
           $("#data-content").html(data);
           var table = $('#coupon_table').DataTable({
            "pageLength":5,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "fixedColumns": true
          });
      }
    });
    /* end ajax */
  }

  /* Get Detail Transfer */
  function getDetail()
  {
    $(document).on("click",".detail",function(){
        var id = $(this).attr('id'); // get id transfer / autoconfirm
           $.ajax({
              type : 'GET',
              url : "{{route('getdetail')}}",
              data : {'id_transfer':id},
              dataType : "json",
              success : function(result){
                $(".service_name").text(result.service_name);
                $(".service_code").text(result.service_code);
                $(".account_number").text(result.account_number);
                $(".account_name").text(result.account_name);
                $(".data_time").text(result.data_time);
                $(".data_type").text(result.data_type);
                $(".data_amount").text("Rp "+result.data_amount);
                $(".data_balance").text(result.data_balance);
                $(".data_desc").text(result.data_desc);
              }
            });
           /* end ajax */
    });
  }

</script>

@endsection
