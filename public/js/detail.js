var zindex = 2;
var seatmap = document.querySelector(".seatmap-container");
var mapWidth = seatmap.clientWidth;
var mapHeight = seatmap.clientHeight;
/**
 *
 */
$('.user-seat').click(
    function () {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
        }
        else {
            this.classList.add("active");
            this.style.zIndex = zindex;
            zindex++;
        }
        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;
        var top = parseFloat(this.style.top) * mapHeight / 100;
        var left = parseFloat(this.style.left) * mapWidth / 100;
        if (top < 163) $(this).find(".info-box").css("bottom", "auto");
        if (mapHeight - top < 163) $(this).find(".info-box").css("bottom", "100%");
        if (left < 150) $(this).find(".info-box").css("left", "220%");
        if (mapWidth - left < 150) $(this).find(".info-box").css("left", "-120%");
    }
)

/**
 * Set position for the user's info-box
 * @param infoBox : DOM to that infoBox
 * @param top: position of that user - from top of the map to that user (px)
 * @param left : position of that user - from the left of the map to that user (px)
 */
function setInfoBox(infoBox, top, left) {
    var change = 0;
    if (top < 163) {
        infoBox.css("bottom", "auto");
        change = 1;
    }
    if (mapHeight - top < 163) {
        infoBox.css("bottom", "100%");
        change = 1;
    }
    if (left < 150) {
        infoBox.css("left", "220%");
        change = 1;
    }
    if (mapWidth - left < 150) {
        infoBox.css("left", "-120%")
        change = 1;
    }
    if (change == 0) {
        infoBox.css("bottom", "100%");
        infoBox.css("left", "50%");
    }
}

/**
 *
 */
$('.user-seat').click(
    function () {
        var top = parseFloat(this.style.top) * mapHeight / 100;
        var left = parseFloat(this.style.left) * mapWidth / 100;
        var infoBox = $(this).find(".info-box");
        setInfoBox(infoBox, top, left);
    }
)
