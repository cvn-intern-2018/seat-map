<?php
/**
 * Get user avatar image link
 * 
 * @param App\User $user
 * @return string
 */
function getUserAvatar($user) {
    if (is_null($user->img)) {
        return asset('images/user/' . "mys-man.jpg");
    }
    return asset('images/user/' . $user->id . $user->img);
}

/**
 * Get seat map image link
 * 
 * @param App\SeatMap $user
 * @return string
 */
function getSeatmapImages($seatmap) {
    return asset('images/seat-map/' . $seatmap->id . $seatmap->img);
}

/**
 * Get css asset link
 * 
 * @param $string $user
 * @return string
 */
function cssLink($css_file) {
    return asset('css/'. $css_file.'.css');
}