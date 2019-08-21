@extends('layouts.dashboard')

@section('content')
<script type="text/javascript">
  //var table;

  $(document).ready(function() {
    /*table = $('#myTable').DataTable({
      destroy: true,
      "order": [],
    });
    $.fn.dataTable.moment( 'ddd, DD MMM YYYY' );
    */

    //refresh_page();
    datePicker();
    addCoupon();
    getDiscount();
  });

  function refresh_page(){
    table.destroy();
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/list-order/load-order') ?>",
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

  function datePicker(){
     $(".datepicker").datepicker({
       dateFormat : 'yy-mm-dd',
    })
  }

  function delete_order(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/list-order/delete') ?>",
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

 /* Insert coupon data into database */
 function addCoupon() {
    $("#add_coupon").on("submit",function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        type : 'POST',
        url : "{{route('addcoupon')}}",
        data: data,
        dataType : "json",
        beforeSend: function()
        {
          $('#loader').show();
          $('.div-loading').addClass('background-load');
        },
        success: function(result){
          if(result.success == true){
            $('#loader').hide();
            $('.div-loading').removeClass('background-load');
            alert(result.message);
            $("input, textarea").val('');
            $("select[name='coupon_discount']>option:eq(0)").prop('selected', true);
          } else {
            $(".coupon_code").html(result.coupon_code);
            $(".coupon_discount").html(result.coupon_discount);
            $(".coupon_value").html(result.coupon_value);
            $(".valid_until").html(result.valid_until);
            $(".coupon_description").html(result.coupon_description);
          }
        },
        error: function(jqXHR) {
          console.log(jqXHR);
        }
      });
      /* end ajax */  
    });
  };

  /* Display discount type input form */
  function getDiscount()
  {
    $('.discount-percent').hide();
    $('.discount-cash').hide();

    $("input[name='discount']").on('change',function(){
       var get_radio_value = $(this).val();
       if(get_radio_value == 0)
       {
          $('.discount-percent').show();
          $('.discount-cash').hide();
       } else {
          $('.discount-percent').hide();
          $('.discount-cash').show();
       }
    });
  }


</script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">

      <h2><b>Coupons</b></h2>  
      
      <h5>
        Show and add new coupon
      </h5>
      
      <hr>

      <a class="btn btn-warning" data-toggle="modal" data-target="#add-coupon">Add Coupon</a>

      <br/>

      <div id="pesan" class="alert"></div>

      <br>  

      <form>
        <table class="table" id="myTable">
          <thead align="center">
            <th>No Order</th>
            <th>Coupon Name</th>
            <th>Coupon Code</th>
            <th>Discount (%)</th>
            <th>Value</th>
            <th>Valid Until</th>
            <th>Created At</th>
            <th>Updated At</th>
          </thead>
          <tbody id="content"></tbody>
        </table>

        <div id="pager"></div>    
      </form>
    </div>
  </div>
</div>

<!-- Modal Add Coupons -->
<div class="modal fade" id="add-coupon" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Create Coupon
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">

         <form role="form" id="add_coupon">
             <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Kode Kupon:</label>
                <input type="text" class="form-control" name="coupon_code"/>
                <span class="error coupon_code"></span>
              </div>
            </div> 

            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Pilih Tipe Diskon:</label>
               <div class="radio">
                 <label><input type="radio" name="discount" value="0" /> Diskon %</label>
               </div>
               <div class="radio">
                 <label><input type="radio" name="discount" value="1" /> Diskon Harga</label>
               </div>
              </div>
            </div> 

            <div class="row discount-percent">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Diskon:</label>
                <select class="form-control" name="coupon_discount">
                   <option value="0">Pilih Diskon</option>
                   @php
                   for($x=1;$x<=100;$x++)
                   {
                   @endphp
                      <option value="{{$x}}">{{$x}}%</option>
                   @php
                   }
                   @endphp
                </select>
                <span class="error coupon_discount"></span>
              </div>
            </div> 
            <div class="row discount-cash">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Harga:</label>
                <input type="text" class="form-control" name="coupon_value" />
                <span class="error coupon_value"></span>
              </div>
            </div>  
            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Tanggal Berlaku:</label>
                <input type="text" autocomplete="off" class="form-control datepicker" name="valid_until" />
                <span class="error valid_until"></span>
              </div>
            </div>  
            <div class="row">
              <div class="form-group col-md-12">
                <label for="Name">Kupon Deskripsi:</label>
                <textarea class="form-control" name="coupon_description"></textarea>
                <span class="error coupon_description"></span>
              </div>
            </div> 
      <!-- end modal body -->      
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Confirm</button>
        <button class="btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>

    </form>
      
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
        Are you sure you want to delete?

        <input type="hidden" name="id_delete" id="id_delete">
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

<!-- Modal Confirm Order -->
<div class="modal fade" id="confirm-order" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">
          Confirm Order
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Confirm this order? 

        <input type="hidden" name="id_confirm" id="id_confirm">
      </div>
      <div class="modal-footer" id="foot">
        <button class="btn btn-primary" id="btn-confirm-ok" data-dismiss="modal">
          Confirm
        </button>
        <button class="btn" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
      
  </div>
</div>


<script type="text/javascript">

  /*
  $( "body" ).on( "click", ".btn-search", function() {
    currentPage = '';
    refresh_page();
  });

  $( "body" ).on( "click", ".btn-confirm", function() {
    $('#id_confirm').val($(this).attr('data-id'));
  });

  $( "body" ).on( "click", "#btn-confirm-ok", function() 
  {
    confirm_order();
  });

  $( "body" ).on( "click", ".popup-newWindow", function()
  {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
  });

  $( "body" ).on( "click", ".btn-delete", function() {
    $('#id_delete').val($(this).attr('data-id'));
  });

  $( "body" ).on( "click", "#btn-delete-ok", function() {
    delete_order();
  });

  $(document).on('click', '.checkAll', function (e) {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    currentPage = $(this).attr('href');
    refresh_page();
  });

  */
</script>
@endsection