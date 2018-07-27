@extends('layouts.app')
@section('home-active','active')
@section('content')
<div class="container">
<div class="row">
<<<<<<< HEAD
@foreach ($maps as $map)
<div class="col-md-3">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h4 class="panel-title">{{$map->name}} </h4>
				</div>
				<div class="panel-body">Panel content</div>
			</div>
			</div>	

@endforeach
	
=======

        <div class="col-md-3">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a alt="CC" class="panel-title">Panel 3 Panel 3Panel 3Pane 3Panel 3Pane 3Panel 3Pane 3Panel 3Pane 3Panel 3Pane 3Panel 3Pane 3Panel 3Panel Panel 3 Paanel 3Panel 3Panel </h3>
				</div>
				<div class="panel-body">Panel content</div>
			</div>
        </div>

>>>>>>> fc4837972d9fe743a92185da4c50856945c16393
    </div>
</div>
@endsection

