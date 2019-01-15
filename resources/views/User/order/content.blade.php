@foreach($orders as $order)
  <tr>
    <td data-label="No Order">
      {{$order->no_order}}
    </td>
    <td data-label="Package">
      {{$order->package}}
    </td> 
    <td data-label="Total">
      Rp. <?php echo number_format($order->total) ?>
    </td>
    <td data-label="Discount">
      Rp. <?php echo number_format($order->discount) ?>
    </td>
    <td data-label="Date">
      {{$order->created_at}}
    </td>
    <td data-label="Bukti Bayar">
      @if($order->buktibayar=='' or $order->buktibayar==null)
        -
      @else
        <a class="popup-newWindow" href="<?php echo Storage::url($order->buktibayar) ?>">
          View
        </a>
      @endif
    </td>
    <td data-label="Keterangan">
      @if($order->keterangan=='' or $order->keterangan==null)
        -
      @else
        $order->keterangan
      @endif
    </td>
    <td data-label="Status">
      @if($order->status==0)
        <button type="button" class="btn btn-primary btn-confirm" data-toggle="modal" data-target="#confirm-payment" data-id="{{$order->id}}" data-no-order="{{$order->no_order}}" data-package="{{$order->package}}" data-total="{{$order->total}}" data-discount="{{$order->discount}}" data-date="{{$order->created_at}}" data-keterangan="{{$order->keterangan}}">
          Confirm Payment
        </button>
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
@endforeach