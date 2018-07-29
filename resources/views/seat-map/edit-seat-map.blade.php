@extends("frame")

@section("title")
Edit seat map
@endsection
@section("scripts")
<link rel="stylesheet" href="{{ asset("/css/edit-seat-map.css") }}">
<script src="{{ asset("/js/edit-seat-map.js") }}"></script>
@endsection
@section("main")
<div class="container">
<h1 class="page-title">Edit seat map</h1>
</div>
<form class="edit-section" method="POST" action="{{ route("seatmapEditHandler") }}" >
    <input type="hidden" name="seamap_id" value="{{ $map->id}}">
    <div class="container">
        <div class="form-group">
            <input type="text" name="seatmap_name" id="seatmap_name" placeholder="Seat map name (required)" value="{{ $map->name }}">
        </div>
    </div>
    <div class="control-panel-container">
        <div class="container">
            <div class="control-panel">
                <div class="settings">
                    <div class="form-group">
                        <input type="checkbox" name="display_name" id="display_name">
                        <label for="display_name">Show name</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="display_group" id="display_group">
                        <label for="display_group">Show group</label>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-default zoom-out" type="button"><span class="glyphicon glyphicon-zoom-out"></span></button>
                        <button class="btn btn-default zoom-in" type="button"><span class="glyphicon glyphicon-zoom-in"></span></button>
                    </div>
            
                </div>
                <div class="user-list">
                    @foreach ($users as $user)
                    <div class="user-select" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-avatar="{{ $avatars[ $user->id ] }}" 
                        data-group="{{ $user->group->name }}" data-phone="{{ $user->phone }}" data-email="{{ $user->email }}" draggable="true">
                        <div class="avatar">
                            <img src="{{ $avatars[ $user->id ] }}" alt="" class="img-responsive">
                        </div>
                        <div class="name">{{ $user->name }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="search-user">
                        <div class="user-search-avatar">
                            <div class="avatar">
                                <img src="{{ asset("/images/user/mys-man.jpg") }}" alt="" class="img-responsive">
                            </div>
                            <div class="input-search-user">
                                <input type="text" name="keyword" id="keyword">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="map-area">
            @include("seat-map.map-viewport")
        </div>
    </div>
    <div class="container form-buttons">
        <div class="row">
            <div class="col-md-1">
                <button class="btn btn-default" type="button">Cancel</button>
            </div>
            <div class="col-md-1 right">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
@endsection
