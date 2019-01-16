@foreach($referrals as $refer)
  <tr>
    <td data-label="Nama">
      {{$refer->name}}
    </td>
    <td data-label="Email">
      {{$refer->email}}
    </td>
    <td data-label="Created At">
      {{$refer->created_at}}
    </td>
  </tr>
@endforeach