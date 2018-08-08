var zindex = 2;
var seatmap = document.querySelector(".seatmap-container");
var mapWidth = seatmap.clientWidth;
var mapHeight = seatmap.clientHeight;
var waiterSetTimeOut = 0;
var arrangedUserSeat = document.getElementsByClassName("user-seat");
/**
 *Bind listener for "Click on arranged user" to view info-box
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
        var infoBox = $(this).find(".info-box");
        setInfoBox(infoBox, top, left)
        ';'
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
    if (top < 210) {
        infoBox.css("bottom", "auto");
        change = 1;
    }
    if (mapHeight - top < 210) {
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
 * Bind listener for "filter user name" input
 */
document.querySelector("#filter-name").addEventListener("keyup", function () {
    clearTimeout(waiterSetTimeOut);
    var _this = this;
    waiterSetTimeOut = setTimeout(function () {
        var key = _this.value;
        if (key !== "") {
            Array.from(arrangedUserSeat).forEach(function (el) {
                el.style.display = "none";
            });
            Array.from(arrangedUserSeat).filter(function (el) {
                var name = $(el.querySelector(".name")).html();
                name = name.toLowerCase();
                key = key.toLowerCase();
                if (name.indexOf(key) !== -1) {
                    return true;
                }
                return false;
            }).forEach(function (el) {
                el.style.display = "";
            })
        } else {
            Array.from(arrangedUserSeat).forEach(function (el) {
                el.style.display = "";
            });
        }
    }, 500);
})


/**
 * Bind listener for zoom button
 */
document.querySelector("button.zoom-in").addEventListener("click", function () {
    try {
        var zoom = parseInt(seatmap.dataset.zoom);
        if (zoom < 4) {
            seatmap.dataset.zoom = zoom + 1;
        }
    }
    catch (e) {
        seatmap.dataset.zoom = 1
    }
    mapWidth = seatmap.clientWidth;
    mapHeight = seatmap.clientHeight;
});
document.querySelector("button.zoom-out").addEventListener("click", function () {
    try {
        var zoom = parseInt(seatmap.dataset.zoom);
        if (zoom > 1) {
            seatmap.dataset.zoom = zoom - 1;
        }
    }
    catch (e) {
        seatmap.dataset.zoom = 1;
    }

    mapWidth = seatmap.clientWidth;
    mapHeight = seatmap.clientHeight;
});