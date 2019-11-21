@php
$no = 1;
@endphp
@foreach($coupons as $row)
  <tr>
    <td>{{$no}}</td>
    <td>{{$row->coupon_code}}</td>
    <td>{{$row->discount}}%</td>
    <td>{{number_format($row->value,2)}}</td>
    <td>{{$row->valid_until}}</td>
    <td>{{$row->created_at}}</td>
    <td>{{$row->updated_at}}</td>
    <td>{{$row->coupon_description}}</td>
    <td><a class="btn btn-warning btn-sm edit" data-toggle="modal" data-target="#edit-coupon" id="{{$row->id}}">Edit coupon</a></td>
    <td><a class="btn btn-danger btn-sm del" id="{{$row->id}}">Delete</a></td>
  </tr>   
@php
$no++
@endphp
@endforeach