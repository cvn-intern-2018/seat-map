@php
/**
 * 
 * Display map and users on their corresponding position
 * 
 * @param App\Map $map The map object
 * @param array $arranged_users Array of App\User eager loaded with $map
 * @param array $avatars Array of user's avatar URLs keyed by user ID
 * @param string $map_image URL of seat map image
 */
@endphp

<link rel="stylesheet" href="{{ asset("css/seatmap-viewport.css") }}">
<div id="seatmap-viewport-{{ $map->id }}" class="seatmap-viewport">
    <div class="seatmap-container" data-zoom="1">
        <img src="{{ $map_image }}" alt="{{ $map->name }}" class="seatmap-image">
        @foreach($arranged_users as $user)
        <div class="user-seat" id="user-seat-{{ $user->id }}" style="top:{{ $user->pivot->Y }}%;left:{{ $user->pivot->X }}%" draggable="true">
            <div class="seat-display">
                <div class="avatar-container">
                    <img src="{{ $avatars[$user->id] }}" alt="" class="avatar">
                </div>
                <div class="name">{{ $user->name }}</div>
                <div class="info-box container">
                    <div class="row">
                        <div class="info-avatar col-xs-4">
                            <img src="{{ $avatars[$user->id] }}" alt="" class="img-responsive">
                        </div>
                        <div class="info-user col-xs-8">
                            <p><label>Name:</label> <span class="name">{{ $user->name }}</span></p>
                            <p><label>Group:</label> <span class="group">{{ $user->group->name }}</span></p>
                            <p><label>Phone:</label> <span class="phone">{{ $user->phone }}</span></p>
                            <p><label>Email:</label> <span class="email">{{ $user->email }}</span></p>
                        </div>
                    </div>
                    @isset($edit_mode)
                    <div class="row">
                        <div class="arranged-user-action col-xs-12">
                            <button class="btn btn-danger remove-arranged-user" type="button" data-toggle="modal" 
                            data-target="#remove-confirm" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
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
                    <img src="" alt="" class="avatar">
                </div>
                <div class="name"></div>
                <div class="info-box container">
                    <div class="row">
                        <div class="info-avatar col-xs-4">
                            <img src="" alt="" class="img-responsive">
                        </div>
                        <div class="info-user col-xs-8">
                            <p><label>Name:</label><span class="name"></span> </p>
                            <p><label>Group:</label><span class="group"></span></p>
                            <p><label>Phone:</label><span class="phone"></span></p>
                            <p><label>Email:</label><span class="email"></span></p>
                        </div>
                        <div class="arranged-user-action col-xs-12">
                            <button class="btn btn-danger remove-arranged-user" type="button" data-toggle="modal" 
                            data-target="#remove-confirm" data-id="">
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