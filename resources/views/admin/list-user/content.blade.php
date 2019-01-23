@foreach($users as $user)
  <tr>
    <td data-label="Nama">
      {{$user->name}}
    </td>
    <td data-label="Email">
      {{$user->email}}
    </td>
    <td data-label="Username">
      {{$user->username}}
    </td> 
    <td data-label="Total Point">
      {{$user->point}}
    </td>
    <td data-label="Membership">
      {{$user->membership}}
    </td>
    <td data-label="Valid Until">
      {{$user->valid_until}}
    </td>
    <td data-label="Action">
      <button type="button" class="btn btn-primary btn-poin" data-toggle="modal" data-target="#point-log" data-id="{{$user->id}}">
        Point Log
      </button>
      <button type="button" class="btn btn-primary btn-log" data-toggle="modal" data-target="#view-log" data-id="{{$user->id}}">
        Log
      </button>
      <button type="button" class="btn btn-primary btn-referral" data-toggle="modal" data-target="#referral-log" data-id="{{$user->id}}">
        Referral
      </button>
    </td>
  </tr>
@endforeach