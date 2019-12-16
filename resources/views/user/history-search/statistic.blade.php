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
		    <th>&nbsp;</th>
		    <th class="header menu-nomobile" action="jml_following">
		      Following
		    </th>
		    <th>&nbsp;</th>
		    <th class="header menu-nomobile" action="jml_post">
		      Media / Post
		    </th>
		    <th>&nbsp;</th>
		  </thead>
		  <tbody>
		  	@if(count($content) > 0)
		  		@foreach($content as $date=>$val)
		  			<tr>
		  				<td>{{$date}}</td>
		  				<td>{{number_format($val['Total_Followers'])}}</td>
		  				<td>
		  					@if($val['FollowerDeviation'] > 0)
		  						<span style="color:#1dbb0a">+{{number_format($val['FollowerDeviation'])}}</span>
		  					@elseif($val['FollowerDeviation'] < 0)
		  						<span style="color:#f14242">{{number_format($val['FollowerDeviation'])}}</span>
		  					@endif
		  				</td>
		  				<td>{{number_format($val['Total_Following'])}}</td>
		  				<td>
		  					@if($val['FollowingDeviation'] > 0)
		  						<span style="color:#1dbb0a">+{{number_format($val['FollowingDeviation'])}}</span>
		  					@elseif($val['FollowingDeviation'] < 0)
		  						<span style="color:#f14242">{{number_format($val['FollowingDeviation'])}}</span>
		  					@endif
		  				</td>
		  				<td>{{number_format($val['Total_Post'])}}</td>
		  				<td>
		  					@if($val['PostDeviation'] > 0)
		  						<span style="color:#1dbb0a">+{{number_format($val['PostDeviation'])}}</span>
		  					@elseif($val['PostDeviation'] < 0)
		  						<span style="color:#f14242">{{number_format($val['PostDeviation'])}}</span>
		  					@endif
		  				</td>
		  			</tr>
		  		@endforeach
		  	@else
		  		<tr><td colspan="3" class="text-center">No Data</td></tr>
		  	@endif
		  </tbody>
		</table>
		<!-- end table -->

		<!-- Charts -->
		<div id="chartContainer" style="height: 360px"></div>
		<div id="chartContainerFollowing" style="height: 360px"></div>
		<div id="chartContainerPost" style="height: 360px"></div>
		<!-- End Charts -->
    </div>
   </div>
</div>


<script>
	$(function() {
		//Better to construct options first and then pass it as a parameter
		var options = {
			title: {
				text: "Total Daily Follower"
			},
			animationEnabled: true,
			exportEnabled: true,
			data: [
			{
				type: "spline", //change it to line, area, column, pie, etc
				dataPoints: [
					{ x: 10, y: 10 },
					{ x: 20, y: 12 },
					{ x: 30, y: 8 },
					{ x: 40, y: 14 },
					{ x: 50, y: 6 },
					{ x: 60, y: 24 },
					{ x: 70, y: -4 },
					{ x: 80, y: 10 }
				]
			}
			]
		};
		$("#chartContainer").CanvasJSChart(options);
	});

	/* Daily Following */
	$(function() {
		//Better to construct options first and then pass it as a parameter
		var optionFollowing = {
			title: {
				text: "Total Daily Following"
			},
			animationEnabled: true,
			exportEnabled: true,
			data: [
			{
				type: "spline", //change it to line, area, column, pie, etc
				dataPoints: [
					{ x: 10, y: 10 },
					{ x: 20, y: 12 },
					{ x: 30, y: 8 },
					{ x: 40, y: 14 },
					{ x: 50, y: 6 },
					{ x: 60, y: 24 },
					{ x: 70, y: -4 },
					{ x: 80, y: 10 }
				]
			}
			]
		};
		$("#chartContainerFollowing").CanvasJSChart(optionFollowing);
	});

	/* Daily Post */
	$(function() {
		//Better to construct options first and then pass it as a parameter
		var optionPost = {
			title: {
				text: "Total Daily Post"
			},
			animationEnabled: true,
			exportEnabled: true,
			data: [
			{
				type: "spline", //change it to line, area, column, pie, etc
				dataPoints: [
					{ x: 10, y: 10 },
					{ x: 20, y: 12 },
					{ x: 30, y: 8 },
					{ x: 40, y: 14 },
					{ x: 50, y: 6 },
					{ x: 60, y: 24 },
					{ x: 70, y: -4 },
					{ x: 80, y: 10 }
				]
			}
			]
		};
		$("#chartContainerPost").CanvasJSChart(optionPost);
	});
</script>
@endsection