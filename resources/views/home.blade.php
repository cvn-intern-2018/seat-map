@extends('layouts.app')
@section('home-active','active')
@section('content')
<link href="{{asset('css/home.css')}}" rel="stylesheet" type="text/css">
<!-- <input name="_token" type="hidden" value="{{ csrf_token() }}"> -->
<div class="container home">



<form role="form" id="frmDeleteID"  action="/seat-map/delete" method="post" >
@csrf
<input type="hidden" name="id" id="deleteID">
</form>






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
						<h2>Add Seat map<h2>
						<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
						</div>

						<div class="sm-form" >
							
						<label for="name"><b>Tên Seat map: </b></label>
						<input type="text"  class="form-control sm-name" placeholder="Enter Seatmap's name" name="name" required>
						<label for="pic"><b>Sơ đồ (hỗ trợ định dạng .jpg, .png và .gif) : </b></label>
						<input type="file" name="pic" id="pic" accept=".png, .jpg, .gif" required>
						
						</div>

						<div class="sm-form" >
						<button type="button" onclick="document.getElementById('id01').style.display='none'" class=" btn btn-md btn-danger ">Cancel</button>
						<button class="addbtn btn btn-md btn-success " type="submit"> Add map</button>
						</div>
					</form>
					</div>

									
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
					<img data-id="{{$map->id}}" class="delete-button seatmap-button pull-right" src="{{asset('images/remove.png')}}">

					<a href="/seat-map/{{$map->id}}">	<img   class="seatmap-button pull-right" src="{{asset('images/edit.png')}}">
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
<script src="{{ asset('js/home.js') }}" ></script>
@endsection


