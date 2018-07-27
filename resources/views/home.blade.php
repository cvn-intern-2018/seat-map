@extends('layouts.app')
@section('home-active','active')
@section('content')
<div class="container">
<div class="row">
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
	
    </div>
</div>
@endsection

