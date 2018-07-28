@extends('layouts.app')
@section('home-active','active')
@section('content')
<!-- <input name="_token" type="hidden" value="{{ csrf_token() }}"> -->
<div class="container home">

	<div class="row search-box">

				<form role="form" action="{{ action('HomeController@index') }}" method="get" class="">

					<!--end of col-->
					<div class=" col-md-offset-2 col-md-7">
						<input onClick="this.select();" class="form-control form-control-lg form-control-borderless" type="search" name="search" placeholder="Search topics or keywords" value="@if($search)
{{$search}}
@endif">
					</div>
					<!--end of col-->
					<div class="col-md-1">
					<button class="btn btn-md btn-success" type="submit">Search</button>
			
									</div>
					<!--end of col-->
			</form>
			@auth
					<div class="col-md-offset-1 col-md-1 centered text-center">
					<a href="/seat-map/add"class="btn btn-md btn-primary add-map-button" >Add map</a>
									</div>
					
					@endauth
		<!--end of col-->
	</div>
	<div class="row">
					
@foreach ($maps as $map)
<div class="col-md-3">
<a href="/seat-map/{{$map->id}}">
			<div class="panel panel-info">
		
				<div class="panel-heading clearfix">
					<div class="panel-title pull-left">{{$map->name}}  </div>
					</a>
					@auth
					<a href="/seat-map/{{$map->id}}">	<img class="seatmap-button pull-right" src="{{asset('images/remove.png')}}">
					</a>
					<a href="/seat-map/{{$map->id}}">	<img  class="seatmap-button pull-right" src="{{asset('images/edit.png')}}">
					</a>
					
					@endauth
					<a href="/seat-map/{{$map->id}}">
    </div>

				<div class="panel-body">
				
<img alt="{{$map->name}}" class="center-block" src="{{asset('images/seat-map/'.$map->id.'.png')}}">
			
				</div>
			
			</div>
			</a>
			</div>	
	
@endforeach
@if (count($maps)=== 0)
<div class="row">
<div class="centered text-center text big-notify">
<h1> No SeatMap </h1>
</div>
</div>
@endif
</div>
<div class="row">
<div class="centered text-center">
{{$maps->links()}}
</div>
</div>

   </div>
</div>
@endsection

