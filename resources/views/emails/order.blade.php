Terima kasih, anda telah melakukan pemesanan Omnifluencer service.<br>
Info Order anda adalah sebagai berikut <br>
<br>
<strong>No Order :</strong> {{$no_order}} <br>
<strong>Nama :</strong> {{$user->fullname}} <br>
<strong>Status Order :</strong> Pending <br>
Anda telah memesan paket 

{{$nama_paket}} <strong>Rp. {{number_format($order->total - $order->discount,0,'','.')}} </strong><br>

<br>
	Harap SEGERA melakukan pembayaran,<br> 
	<strong>TRANSFER Melalui :</strong><br>
	<br>
	<strong>Bank BCA</strong><br>
  	4800-227-122<br>
  	Sugiarto Lasjim<br>
	<br>
	
	
	dan setelah selesai membayar<br>
	silahkan KLIK <a href="{{url('confirm-payment')}}"> --> KONFIRMASI PEMBAYARAN <-- </a> disini. <br>

<br> Salam hangat, 
<br>
Omnifluencer