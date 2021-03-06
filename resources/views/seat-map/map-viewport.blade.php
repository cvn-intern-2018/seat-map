@php
    /**
     *
     * Display map and users on their corresponding position
     *
     * @param App\Map $map The map object
     * @param array $users Array of App\User eager loaded with $map
     * @param array $avatars Array of user's avatar URLs keyed by user ID
     * @param string $map_image URL of seat map image
     */
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 filter">
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <input onclick="this.select();" autocomplete="off" placeholder="Input username to filter on map"
                           class="form-control form-control-sm form-control-borderless"
                           type="text" name="filter" id="filter-name">
                </div>
                <div class="btn-group col-md-2 col-lg-1">
                    <button class="btn btn-default zoom-out col-md-6" type="button" disabled="disabled"><span
                                class="glyphicon glyphicon-zoom-out"></span></button>
                    <button class="btn btn-default zoom-in col-md-6" type="button"><span
                                class="glyphicon glyphicon-zoom-in"></span></button>
                </div>
                @if(!isset($edit_mode))
                    @auth
                        {{--Delete and edit button--}}
                        <div class="btn-admin col-md-offset-5  col-lg-offset-6 col-lg-2 col-md-2 pull-right">

                            <img data-id="{{$map->id}}" data-name="{{$map->name}}"
                                 class="seatmap-button delete-seatmap pull-right" data-toggle="modal"
                                 data-target="#delete-map-modal"
                                 src="{{asset('images/remove.png')}}">
                            <a href="/seat-map/edit/{{$map->id}}"> <img class="seatmap-button pull-right"
                                                                        src="{{asset('images/edit.png')}}">
                            </a>
                        </div>

                        {{--"Delete seat map"Hidden form --}}
                        <form role="form" id="frmDeleteSM" action="/seat-map/delete" method="post">
                            @csrf
                            <input type="hidden" name="returnHome" value="1">
                            <input type="hidden" name="SeatmapID" id="deleteID">
                            <input type="hidden" name="SeatmapName" id="deleteName">
                        </form>
                        {{---------------------------------}}
                        {{--Add map modal form--}}
                        <div class="modal fade" id="delete-map-modal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Delete seat map</h4>
                                    </div>
                                    <div class="modal-body">
                                        Do you really want to delete "<span id="delete-name"></span>"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" id="delete-confirm" class=" btn btn-danger "
                                                data-dismiss="modal"
                                                data-id="" data-name="">
                                            Delete
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{----------------------}}

                    @endauth
                @endisset
            </div>
        </div>


        @isset($edit_mode)
            @auth



            @endauth
        @endisset

        <div class="seat-map col-md-12">
            <link rel="stylesheet" href="{{ asset("css/map-viewport.css") }}">
            <div class="  panel panel-default">
                <div class="panel-heading">
                    <div class="map-name">
                        {{$map->name}}
                    </div>
                </div>
                <div class="panel-body">
                    <div id="seatmap-viewport-{{ $map->id }}" class="dragscroll seatmap-viewport">


                        <div class=" seatmap-container" data-zoom="1">

                            <img src="{{ getSeatmapImages($map) }}" alt="{{ $map->name }}" class="  seatmap-image">
                            @foreach($users as $user)
                                <div class="user-seat" id="user-seat-{{ $user->id }}"
                                     style="top:{{ $user->pivot->Y / 100 }}%;left:{{ $user->pivot->X / 100 }}%"
                                     @isset($edit_mode)
                                     draggable="true"
                                        @endisset
                                >
                                    <div class="seat-display">
                                        <div class="avatar-container">
                                            <img src="{{ getUserAvatar($user) }}" alt="" class="avatar"
                                                 onerror="this.src='{{ asset("images/user/mys-man.jpg") }}'">
                                        </div>

                                        <div class="name">{{ $user->short_name }}</div>
                                        <div class="info-box container">
                                            <div class="row">
                                                <div class="info-avatar col-xs-4">
                                                    <img src="{{ getUserAvatar($user) }}" alt="" class="img-responsive"
                                                         onerror="this.src='{{ asset("images/user/mys-man.jpg") }}'">
                                                </div>
                                                <div class="info-user col-xs-8">
                                                    <p class="name-line"><label>Name:</label> <span
                                                                class="name">{{ $user->name }}</span></p>
                                                    <p class="group-line"><label>Group:</label> <span
                                                                class="group">{{ $user->group->name }}</span></p>
                                                    <p class="phone-line"><label>Phone:</label> <span
                                                                class="phone">{{ $user->phone }}</span></p>
                                                    <p class="email-line"><label>Email:</label> <span
                                                                class="email">{{ $user->email }}</span></p>
                                                </div>
                                            </div>
                                            @isset($edit_mode)
                                                <div class="row">
                                                    <div class="arranged-user-action col-xs-12">
                                                        <button class="btn btn-danger remove-arranged-user"
                                                                type="button"
                                                                data-toggle="modal"
                                                                data-target="#remove-confirm" data-id="{{ $user->id }}"
                                                                data-name="{{ $user->name }}">
                                                            Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @isset($edit_mode)

                                <div class="user-seat-template" id="" style="top:0;left:0" draggable="true" hidden>
                                    <div class="seat-display">
                                        <div class="avatar-container">
                                            <img src="" alt="" class="avatar"
                                                 onerror="this.src='{{ asset("images/user/mys-man.jpg") }}'">
                                        </div>
                                        <div class="name"></div>
                                        <div class="group-name"></div>
                                        <div class="info-box container">
                                            <div class="row">
                                                <div class="info-avatar col-xs-4">
                                                    <img src="" alt="" class="img-responsive"
                                                         onerror="this.src='{{ asset("images/user/mys-man.jpg") }}'">
                                                </div>
                                                <div class="info-user col-xs-8">
                                                    <p class="name-line"><label>Name:</label><span class="name"></span></p>
                                                    <p class="group-line"><label>Group:</label><span class="group"></span></p>
                                                    <p class="phone-line"><label>Phone:</label><span class="phone"></span></p>
                                                    <p class="email-line"><label>Email:</label><span class="email"></span></p>
                                                </div>
                                                <div class="arranged-user-action col-xs-12">
                                                    <button class="btn btn-danger remove-arranged-user" type="button"
                                                            data-toggle="modal"
                                                            data-target="#remove-confirm" data-id="" data-name="">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/deleteSeatmap.js') }}"></script>
<script src="{{ asset("/js/drag-to-scroll.js") }}"></script>
@if(!isset($edit_mode))
    <script src="{{ asset("/js/map-viewport.js") }}"></script>
@endif
