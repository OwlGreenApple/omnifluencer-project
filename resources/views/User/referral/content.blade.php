@foreach($user_takers as $user_taker)
  <tr>
    <td>{{ $user_taker->name }}</td>
    <td>{{ $user_taker->email }}</td>  
  </tr>
@endforeach