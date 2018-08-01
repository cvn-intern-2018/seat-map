<?php
function getUserAvatar($user) {
    if (is_null($user->img)) {
        return asset('images/user/' . "mys-man.jpg");
    }
    return asset('images/user/' . $user->id . $user->img);
}

function getSeatmapImages($seatmap) {
    return asset('images/seat-map/' . $seatmap->id . $seatmap->img);
}