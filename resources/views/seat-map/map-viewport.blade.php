<link rel="stylesheet" href="{{ asset("css/seatmap-viewport.css") }}">
<div id="seatmap-viewport-{{ $map->id }}" class="seatmap-viewport">
    <div class="seatmap-container">
    <img src="{{ asset("images/seat-map/" . $map->id . ".gif") }}" alt="{{ $map->name }}" class="seatmap-image">
    @foreach($map->users as $user)
    <div class="user-seat" style="top:{{ $user->pivot->Y }}%;left:{{ $user->pivot->X }}%">
        <div class="seat-display">
            <div class="avatar-container">
                <img src="{{ $avatars[$user->id] }}" alt="" class="avatar">
            </div>
            <div class="name">{{ $user->name }}</div>
        </div>
        
    </div>
    @endforeach
    </div>
</div>