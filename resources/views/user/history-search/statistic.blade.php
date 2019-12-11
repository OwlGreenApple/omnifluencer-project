@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-11">
    	<!-- table -->
		<table class="table responsive">
		  <thead>
		    <th class="header menu-nomobile" action="updated_at">
		      Date
		    </th>
		    <th class="header menu-nomobile" action="jml_followers">
		      Followers
		    </th>
		    <th class="header menu-nomobile" action="jml_following">
		      Following
		    </th>
		    <th class="header menu-nomobile" action="jml_post">
		      Media / Post
		    </th>
		    <th>Action</th>
		  </thead>
		  <tbody>
		  	@if(count($content) > 0)
		  		@foreach($content as $date=>$val)
		  			<tr><td>{{$date}}</td></tr>
		  			<tr><td>{{$val['Total_Followers']}}</td></tr>
		  			<tr><td>{{$val['Total_Following']}}</td></tr>
		  			<tr><td>{{$val['Total_Post']}}</td></tr>
		  		@endforeach
		  	@else
		  		<tr><td colspan="3" class="text-center">xaxsax</td></tr>
		  	@endif
		  </tbody>
		</table>
		<!-- end table -->
    </div>
   </div>
</div>
@endsection