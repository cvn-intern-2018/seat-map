@extends('layouts.app')
@section('home-active','active')
@section('content')
<link href="{{asset('css/home.css')}}" rel="stylesheet" type="text/css">
<!-- <input name="_token" type="hidden" value="{{ csrf_token() }}"> -->
<div class="container home">

	<div class="row search-box">

				<form role="form" action="/" method="get" class="">

					<!--end of col-->
					<div class=" col-md-offset-2 col-md-7">
						<input onClick="this.select();" class="form-control form-control-lg form-control-borderless" type="search" name="search" placeholder="Search topics or keywords" value="@isset($search)
{{$search}}
@endisset">
					</div>
					<!--end of col-->
					<div class="col-md-1">
					<button class="btn btn-md btn-success" type="submit">Search</button>
			
									</div>
					<!--end of col-->
			</form>
			@auth
					<div class="col-md-offset-1 col-md-1 centered text-center">
					<button onclick="document.getElementById('id01').style.display='block'" class="btn btn-md btn-primary add-map-button" >Add map</button>
									</div>
							
														


					<div id="id01" class="modal">
					
					<form role="form"  class="modal-content animate" action="/seat-map/add" method="post" enctype="multipart/form-data" >
					@csrf
						<div class="imgcontainer">
						<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
						</div>

						<div class="sm-form" >
							
						<label for="name"><b>Tên Seatmap: </b></label>
						<input type="text"  class="form-control sm-name" placeholder="Enter Seatmap's name" name="name" required>
						<label for="pic"><b>Sơ đồ: </b></label>
						<input type="file" name="pic" id="pic" accept="image/*" required>
						
						</div>

						<div class="sm-form" style="background-color:#f1f1f1">
						<button type="button" onclick="document.getElementById('id01').style.display='none'" class=" btn btn-md btn-danger ">Cancel</button>
						<button class="addbtn btn btn-md btn-success " type="submit"> Add Seatmap</button>
						</div>
					</form>
					</div>

					<script>
					// Get the modal
					var modal = document.getElementById('id01');

					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
						if (event.target == modal) {
							modal.style.display = "none";
						}
					}
					</script>





									
					@endauth
		<!--end of col-->
	</div>
	<div class="row">
@isset($maps)	
@if($maps->count()==0)
<div class="row">
<div class="centered text-center text big-notify">
<h1> No SeatMap </h1>
</div>
</div>
@else		
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


</div>
<div class="row">
<div class="centered text-center">
{{$maps->links()}}
</div>
</div>
@endif	
@else
<div class="row">
<div class="centered text-center text big-notify">
<h1> No SeatMap </h1>
</div>
</div>
@endisset


   </div>
</div>
@endsection


