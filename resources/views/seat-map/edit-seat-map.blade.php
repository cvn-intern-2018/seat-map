@extends("layouts.vertical")

@section("title")
    Edit seat map
@endsection
@section("big-title")
    Edit seat map
@endsection
@section("scripts")

    <script src="{{ asset("/js/edit-seat-map.js") }}"></script>
@endsection
@section("vertical")
    <link rel="stylesheet" href="{{ asset("/css/edit-seat-map.css") }}">
    <div class="control-panel">
        <div class="row ">
            <div class="name-form col-md-12">
                <label for="seatmap_name_holder">Seat map name:</label>
                <input maxlength="100" class="form-control form-control-sm form-control-borderless" type="text"
                       name="seatmap_name_holder"
                       id="seatmap_name_holder" required
                       value="{{ $map->name }}">
            </div>
            <div class="settings col-md-12">
                <div class="form-group col-sm-12 col-xs-12 col-md-12 col-lg-6 ">
                    <input type="checkbox" name="display_name" id="display_name" checked>
                    <label for="display_name">Show name</label>
                </div>
                <div class="form-group col-sm-12 col-xs-12  col-md-12 col-lg-6">
                    <input type="checkbox" name="display_group" id="display_group" checked>
                    <label for="display_group">Show group</label>
                </div>
                <div class="btn-group col-md-12">

                    <button class="btn btn-default zoom-out col-md-6" type="button"><span
                                class="glyphicon glyphicon-zoom-out"></span></button>
                    <button class="btn btn-default zoom-in col-md-6" type="button"><span
                                class="glyphicon glyphicon-zoom-in"></span></button>
                </div>
            </div>
            <div class="search-user col-md-12 ">
                <div class="user-search-avatar">
                    <div class="  input-search-user">
                        <input placeholder="Input username" class="form-control form-control-sm form-control-borderless"
                               type="text" name="keyword" id="keyword">
                    </div>
                </div>
            </div>
            <div class="user-list col-sm-offset-2 col-sm-8 col-md-offset-1 col-md-10">
                @foreach ($users as $user)
                    <div class=" col-sm-12 col-md-6 col-xs-12 col-lg-6 ">
                        <div class="user-select" data-id="{{ $user->id }}"
                             data-name="{{ $user->name }}"
                             data-avatar="{{ getUserAvatar($user) }}"
                             data-group="{{ $user->group->name }}" data-phone="{{ $user->phone }}"
                             data-email="{{ $user->email }}" draggable="true"
                             @if (in_array($user->id, $arranged_ids))
                             hidden
                                @endif
                        >
                            <div class="avatar">
                                <img src="{{ getUserAvatar($user) }}" alt="" class="img-responsive"
                                     onerror="this.src='{{ asset("images/user/mys-man.jpg") }}'">
                            </div>
                            <div  class="name col-md-12">{{ $user->short_name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12 ">
                <a href="{{ route("seatmapDetail", ["id" => $map->id]) }}">
                    <button class="btn btn-danger sm-btn" type="button">Cancel</button>
                </a>
            </div>
            <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12">
                <button id="save_edit" class="btn btn-success sm-btn" type="submit">Save</button>
            </div>

        </div>
    </div>

@endsection
@section("content")

    <form class="edit-section" method="POST" action="{{ route("seatmapEditHandler") }}">
        {{ csrf_field() }}
        <input type="hidden" name="seatmap_id" value="{{ $map->id}}" required>
        <input type="hidden" value="test" name="seat_data" id="seat_data" required>
        <input type="hidden" value="test" value="{{$map->name}} " name="seatmap_name" id="seatmap_name" required>
        <div class="map-area">
            @include("seat-map.map-viewport", ['users' => $users->whereIn('id', $arranged_ids)])
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
