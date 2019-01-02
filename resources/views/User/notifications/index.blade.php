@extends('layouts.dashboard')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-11">
      <h2><b>Notifications</b></h2>
      <h5>
        All Notifications
      </h5>   
      <hr>
      
      <br>

      <table class="table">
        <tbody>
          @foreach($notification as $notif)
            <tr>
              <td align="center" width="100">
                @if($notif->type=='point')
                  <i class="fas fa-coins notif notif-point"></i>
                @elseif($notif->type=='promo')
                  <i class="fas fa-star notif notif-promo"></i>
                @endif
              </td>
              <td>
                @if($notif->type=='point')
                  <span class="notif notif-point">
                    {{$notif->notification}}
                  </span>
                @elseif($notif->type=='promo')
                  <span class="notif notif-promo">
                    {{$notif->notification}}
                  </span>
                @endif

                <br>

                {{$notif->keterangan}}
              </td>
              <td align="right">
                {{ date("M d", strtotime($notif->created_at))  }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {!! $notification->render() !!}
    </div>
  </div>
</div>
@endsection