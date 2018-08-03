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
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <form class="edit-section" method="POST" action="{{ route("seatmapEditHandler") }}">
        {{ csrf_field() }}
        <input type="hidden" name="seatmap_id" value="{{ $map->id}}" required>
        <input type="hidden" name="seat_data" id="seat_data" required>
        <div class="control-panel-container">
            <div class="container">
                <div class="form-group">
                    <input type="text" name="seatmap_name" id="seatmap_name" placeholder="Seat map name (required)"
                            value="{{ $map->name }}">
                </div>
                <div class="control-panel">
                    <div class="settings">
                        <div class="form-group">
                            <input type="checkbox" name="display_name" id="display_name" checked>
                            <label for="display_name">Show name</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="display_group" id="display_group" checked>
                            <label for="display_group">Show group</label>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default zoom-out" type="button"><span
                                        class="glyphicon glyphicon-zoom-out"></span></button>
                            <button class="btn btn-default zoom-in" type="button"><span
                                        class="glyphicon glyphicon-zoom-in"></span></button>
                        </div>
                    </div>
                    <div class="user-list">
                        @foreach ($users as $user)
                            <div class="user-select" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                    data-avatar="{{ getUserAvatar($user) }}"
                                    data-group="{{ $user->group->name }}" data-phone="{{ $user->phone }}"
                                    data-email="{{ $user->email }}" draggable="true"
                                    @if (in_array($user->id, $arranged_ids))
                                    hidden
                                    @endif
                            >
                                <div class="avatar">
                                <img src="{{ getUserAvatar($user) }}" alt="" class="img-responsive" onerror="this.src='{{ asset("images/user/mys-man.jpg") }}'">
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
                @include("seat-map.map-viewport", ['users' => $users->whereIn('id', $arranged_ids)])
            </div>
        </div>
        <div class="container form-buttons">
            <div class="row">
                <div class="col-md-1">
                    <a href="{{ route("seatmapDetail", ["id" => $map->id]) }}">
                        <button class="btn btn-default" type="button">Cancel</button>
                    </a>
                </div>
                <div class="col-md-1 right">
                    <button id="save_edit" class="btn btn-success" type="submit">Save</button>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="remove-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Remove user from map</h4>
                </div>
                <div class="modal-body">
                    Do you really want to remove <span class="remove-name"></span> from the seat map?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger remove-confirmed" data-dismiss="modal" data-id="">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
