@foreach($orders as $order)
  <tr>
    <td data-label="No Order">
      <div class="menu-mobile">
        <div class="view-details" data-id="{{$order->id}}">
          <span class="menu-mobile icon-dropdown">
            <i class="fas fa-sort-down"></i>
          </span>  
        </div>
      </div>

      {{$order->no_order}}  
    </td>
    <td class="menu-nomobile" data-label="Package">
      {{$order->package}}
    </td> 
    <td class="menu-nomobile" data-label="Total">
      Rp. <?php echo number_format($order->total) ?>
    </td>
    <td class="menu-nomobile" data-label="Discount">
      Rp. <?php echo number_format($order->discount) ?>
    </td>
    <td class="menu-nomobile" data-label="Grand Total">
      Rp. <?php echo number_format($order->grand_total) ?>
    </td>
    <td class="menu-nomobile" data-label="Date">
      {{ date("H:i", strtotime($order->created_at))  }}
      <br>
      {{ date("Y/m/d", strtotime($order->created_at))  }}
    </td>
    <td class="menu-nomobile" data-label="Bukti Bayar">
      @if($order->buktibayar=='' or $order->buktibayar==null)
        -
      @else
        <a class="popup-newWindow" href="<?php echo Storage::url($order->buktibayar) ?>">
          View
        </a>
      @endif
    </td>
    <td class="menu-nomobile" data-label="Keterangan">
      @if($order->keterangan=='' or $order->keterangan==null)
        -
      @else
        {{$order->keterangan}}
      @endif
    </td>
    <td data-label="Status">
      @if($order->status==0)
        <!--<div class="menu-nomobile">-->
          <button type="button" class="btn btn-primary btn-confirm" data-toggle="modal" data-target="#confirm-payment" data-id="{{$order->id}}" data-no-order="{{$order->no_order}}" data-package="{{$order->package}}" data-total="{{$order->total}}" data-discount="{{$order->discount}}" data-date="{{$order->created_at}}" data-keterangan="{{$order->keterangan}}">
            Confirm Payment
          </button>  
        <!--</div>

        <div class="menu-mobile">
          <span class="menu-savepdf btn-confirm" data-toggle="modal" data-target="#confirm-payment" data-id="{{$order->id}}" data-no-order="{{$order->no_order}}" data-package="{{$order->package}}" data-total="{{$order->total}}" data-discount="{{$order->discount}}" data-date="{{$order->created_at}}" data-keterangan="{{$order->keterangan}}">
            Confirm Payment
          </span>
        </div>-->
      @elseif($order->status==1)
        <span style="color: orange">
          <b>Waiting Admin Confirmation</b>
        </span>
      @else 
        <span style="color: green">
          <b>Confirmed</b>
        </span>
      @endif
    </td>
  </tr>

  <tr class="details-{{$order->id}} d-none">
    <td>
      Package : <b>{{$order->package}}</b><br>
      Harga : <b>
                Rp. <?php echo number_format($order->total) ?>    
              </b><br>
      Discount : <b>
                  Rp. <?php echo number_format($order->discount) ?>
                 </b><br>
      Total : <b>
                Rp. <?php echo number_format($order->grand_total) ?>
              </b><br>
    </td>
    <td>
      Date : <b>{{$order->created_at}}</b><br>
      Bukti Bayar : 
        @if($order->buktibayar=='' or $order->buktibayar==null)
          -
        @else
          <a class="popup-newWindow" href="<?php echo Storage::url($order->buktibayar) ?>">
            View
          </a>
        @endif
        <br>
      Keterangan : 
      <b>
        @if($order->keterangan=='' or $order->keterangan==null)
          -
        @else
          {{$order->keterangan}}
        @endif
      </b>
    </td>
  </tr>
@endforeach