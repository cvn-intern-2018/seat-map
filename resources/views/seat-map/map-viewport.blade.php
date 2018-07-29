<link rel="stylesheet" href="{{ asset("css/seatmap-viewport.css") }}">
<div id="seatmap-viewport-{{ $map->id }}" class="seatmap-viewport">
    <div class="seatmap-container" data-zoom="1">
    <img src="{{ $mapImage }}" alt="{{ $map->name }}" class="seatmap-image">
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
            </div>
        </div>
    </div>
    @endforeach
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>