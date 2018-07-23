@extends('admin.dashboard')
@section('title')
Arrange seat
@endsection
@section('assets')
<link rel="stylesheet" href="{{ asset("/css/set-seat.css") }}">
<script src="{{ asset("/js/set-seat.js") }}"></script>
@endsection
@section('main')
<header>
	<div class="container">
		<h1>Arrange position for seat map</h1>
	</div>
</header>
<section class="control-panel">
	<div class="container setting">
		<div class="seatmap-option">
			<div class="group-option">
				<input type="checkbox" name="display_name" id="display_name">
				<label for="display_name">Show name</label>
			</div>
			<div class="group-option">
				<input type="checkbox" name="display_group" id="display_group">
				<label for="display_group">Show group</label>
			</div>
			<div class="group-option">
				<label for="avatar_width">Width: </label>
				<input type="text" name="avatar_width" id="avatar_width" value="50">
				<span>px</span>
			</div>
			<div class="group-option">
				<label for="avatar_height">Height: </label>
				<input type="text" name="avatar_height" id="avatar_height" value="50">
				<span>px</span>
			</div>
		</div>
		<div class="user-select">
			<div class="user-item">
				<div class="user-avatar">
					<img src="{{ asset("user-avatar/mys-man.jpg")}}" alt="">
				</div>
				<div class="user-name">John Doe</div>
			</div>
			<div class="user-item">
				<div class="user-avatar">
					<img src="{{ asset("user-avatar/mys-lady.jpg")}}" alt="">
				</div>
				<div class="user-name">Jane Doe</div>
			</div>
		</div>
		<div class="user-search">
			<div class="user-item">
				<div class="user-avatar">
					<img src="{{ asset("user-avatar/mys-lady.jpg")}}" alt="">
				</div>
				<div class="user-name">
					<input type="text" name="search_user" id="search_user">
				</div>
			</div>
		</div>
	</div>
</section>
<section class="seatmap">
	<div class="container">
		<div class="seatmap-img">
			<img src="/seatmap/81480s.gif" alt="">
		</div>
	</div>
</section>
@endsection