document.addEventListener("DOMContentLoaded", function (e) {
    // ================= Initial data =========================
    var zindex = 2;
    var avatarSize = 65;
    var mapWidth = 0;
    var mapHeight = 0;
    var waiterSetTimeOut = 0;
    var seatmap = document.querySelector(".seatmap-container");
    var arrangedUserSeat = document.getElementsByClassName("user-seat");
    var userList = document.querySelectorAll(".user-list .user-select");
    var userBox = document.querySelector(".user-list");
    var controlPanel = document.querySelector(".control-panel-container");
    var scrollThreshold = 0;
    /**
     * Bind listener for window when resizing.
     */
    $(window).on('resize', function () {
        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;

    });
    // ================= Initial procedure =========================
    window.onload = function () {
        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;

    }
    document.getElementById("seat_data").value = JSON.stringify(gatherSeatmapSetting());

    // ================= Function event handler =========================
    /**
     * Handle event start draging arranged users
     */
    function dragArrangedUser(e) {
        this.style.zIndex = zindex;
        zindex++;
        e.dataTransfer.setData("object_id", this.id.slice(this.id.lastIndexOf("-") + 1));
        var [offsetX, offsetY] = getOffsets(e);
        e.dataTransfer.setData("pointer_x", offsetX - avatarSize / 2);
        e.dataTransfer.setData("pointer_y", offsetY - avatarSize / 2);

    }

    /**
     * Handle event clicking on arranged users
     */
    function clickArrangedUser() {
        this.style.zIndex = zindex;
        zindex++;
        if (this.classList.contains("active")) {
            this.classList.remove("active");
        }
        else {
            var top = parseFloat(this.style.top) * mapHeight / 100;
            var left = parseFloat(this.style.left) * mapWidth / 100;
            var infoBox = $(this).find(".info-box");
            setInfoBox(infoBox, top, left);
            this.classList.add("active");
        }
    }

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
     * Handle event clicking on remove button of arranged users
     */
    function removeArrangedUser() {
        document.querySelector("#remove-confirm .remove-confirmed").dataset.id = this.dataset.id;
        document.querySelector("#remove-confirm .remove-name").innerHTML = this.dataset.name;
    }

    // ================= Bind event handler =========================
    /**
     * Bind listener for arranged users
     */
    for (i = 0; i < arrangedUserSeat.length; i++) {
        arrangedUserSeat[i].addEventListener("dragstart", dragArrangedUser);
        arrangedUserSeat[i].addEventListener("click", clickArrangedUser);
        arrangedUserSeat[i].querySelector(".remove-arranged-user").addEventListener("click", removeArrangedUser);
    }

    /**
     * Bind listener dragging over of seat map
     */
    seatmap.addEventListener("dragover", function (e) {
        e.preventDefault();
    });

    /**
     * Bind listener for start dragging user on user list
     */
    for (i = 0; i < userList.length; i++) {
        userList[i].addEventListener("dragstart", function (e) {
            e.dataTransfer.setData("type", "new");
            e.dataTransfer.setData("object_id", this.dataset.id);
            e.dataTransfer.setData("name", this.dataset.name);
            e.dataTransfer.setData("avatar", this.dataset.avatar);
            e.dataTransfer.setData("group", this.dataset.group);
            e.dataTransfer.setData("phone", this.dataset.phone);
            e.dataTransfer.setData("email", this.dataset.email);
        });
    }

    /**
     * Bind listener for dropping on seat map
     */
    seatmap.addEventListener("drop", function (e) {

        e.preventDefault();

        var [realX, realY] = getOffsets(e);
        if (e.target !== this) {

            var parent = e.target.closest(".user-seat");
            realX += parseFloat(parent.style.left) * mapWidth / 100 - avatarSize / 2;
            realY += parseFloat(parent.style.top) * mapHeight / 100 - avatarSize / 2;

        }
        if (e.dataTransfer.getData("type") === "new") {

            // Clone object
            var newSeat = document.querySelector(".user-seat-template").cloneNode(true);
            setAttributesNewSeat(newSeat, e);

            // Add styles
            newSeat.style.top = (realY / mapHeight * 100) + "%";
            newSeat.style.left = (realX / mapWidth * 100) + "%";

            // Add events
            newSeat.addEventListener("dragstart", dragArrangedUser);
            newSeat.addEventListener("click", clickArrangedUser);
            newSeat.querySelector(".remove-arranged-user").addEventListener("click", removeArrangedUser)

            // Set in position
            seatmap.appendChild(newSeat);

            // Remove in user list
            document.querySelector(".user-list .user-select[data-id=\"" + e.dataTransfer.getData("object_id") + "\"]")
                .setAttribute("hidden", "");

        }
        else {
            if (e.dataTransfer.getData("object_id")) {
                var obj = document.getElementById("user-seat-" + e.dataTransfer.getData("object_id"));
                var pointerX = parseFloat(e.dataTransfer.getData("pointer_x"));
                var pointerY = parseFloat(e.dataTransfer.getData("pointer_y"));
                var left = realX - pointerX;
                var top = realY - pointerY;
                console.log("OK");
                if (left < 45) left = 45;
                if (top < 32) top = 32;
                if (left > mapWidth - 45) left = mapWidth - 45;
                if (top > mapHeight - 45) left = mapHeight - 45;
                obj.style.left = (left / mapWidth * 100) + "%";
                obj.style.top = (top / mapHeight * 100) + "%";

                var infoBox = $(obj).find(".info-box");
                setInfoBox(infoBox, top, left);


            }
        }
    });

    /**
     * Bind listener for the user select box when dropping an user on it
     */
    userBox.addEventListener("drop", function (e) {
        event.preventDefault();
        var btnRemove = $("#user-seat-" + e.dataTransfer.getData("object_id") + " .remove-arranged-user");
        btnRemove.click();
    });

    /**
     * Bind listener for the user select box
     */
    userBox.addEventListener("dragover", function (e) {
        event.preventDefault();
    });

    /**
     * Bind listener for zoom button
     */
    document.querySelector("button.zoom-in").addEventListener("click", function () {
        try {
            var zoom = parseInt(seatmap.dataset.zoom);
            if (zoom < 4) {
                zoom += 1
                seatmap.dataset.zoom = zoom;
            }
            if (zoom >= 4) {
                this.setAttribute("disabled", "disabled");
            }
            
            if ( zoom > 1) {
                document.querySelector("button.zoom-out").removeAttribute("disabled", "disabled");
            }
        }
        catch (e) {
            seatmap.dataset.zoom = 1;
        }
        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;
    });
    document.querySelector("button.zoom-out").addEventListener("click", function () {
        try {
            var zoom = parseInt(seatmap.dataset.zoom);
            if (zoom > 1) {
                zoom -= 1
                seatmap.dataset.zoom = zoom;
            }
            if (zoom <= 1) {
                this.setAttribute("disabled", "disabled");
            }
            
            if (zoom < 4) {
                document.querySelector("button.zoom-in").removeAttribute("disabled", "disabled");
            }
        }
        catch (e) {
            seatmap.dataset.zoom = 1;
        }

        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;
    });

    /**
     * Bind listener for clicking "confirm of removing user" button
     */
    document.querySelector("#remove-confirm .remove-confirmed").addEventListener("click", function () {
        var user_seat = document.querySelector(".seatmap-container #user-seat-" + this.dataset.id);
        user_seat.parentNode.removeChild(user_seat);
        document.querySelector(".user-list .user-select[data-id=\"" + this.dataset.id + "\"]").removeAttribute("hidden");
    });

    /**
     * Bind listener for "search user" input
     */
    document.querySelector("#keyword").addEventListener("keyup", function () {
        clearTimeout(waiterSetTimeOut);
        var _this = this;
        waiterSetTimeOut = setTimeout(function () {
            var key = _this.value.toLowerCase();
            if (key !== "") {
                Array.from(userList).forEach(function (el) {
                    el.style.display = "none";
                });
                Array.from(userList).filter(function (el) {
                    var name = el.dataset.name.toLowerCase();
                    var short_name = el.dataset.short_name.toLowerCase();
                    if (name.indexOf(key) !== -1 || short_name.indexOf(key) !== -1) {
                        return true;
                    }
                    return false;
                }).forEach(function (el) {
                    el.style.display = "";
                })
            } else {
                Array.from(userList).forEach(function (el) {
                    el.style.display = "";
                });
            }
        }, 100);
    })

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
     * Bind listener for clicking save button
     */
    document.getElementById("save_edit").addEventListener("click", function (e) {
        e.preventDefault();
        var seatField = document.getElementById("seat_data")
        var name = document.getElementById("seatmap_name_holder").value;
        var name_real = document.getElementById("seatmap_name").value = name;
        var seatField = document.getElementById("seat_data")
        var newData = JSON.stringify(gatherSeatmapSetting());
        if (newData !== seatField.value) {
            seatField.value = newData;
        } else {
            seatField.value = "";
        }

        document.querySelector(".edit-section").submit();
    });

    /**
     * Bind listener for toggling checkbox option
     */
    document.getElementById("display_name").addEventListener("click", function (e) {
        if (this.checked == true) {
            if (seatmap.classList.contains("hide-name")) {
                seatmap.classList.remove("hide-name");
            }
        } else {
            if (!seatmap.classList.contains("hide-name")) {
                seatmap.classList.add("hide-name");
            }
        }
    });
    document.getElementById("display_group").addEventListener("click", function (e) {
        if (this.checked == true) {
            if (seatmap.classList.contains("hide-group")) {
                seatmap.classList.remove("hide-group");
            }
        } else {
            if (!seatmap.classList.contains("hide-group")) {
                seatmap.classList.add("hide-group");
            }
        }
    });

    /**
     * Bind listener for scrolling the screen
     */
    window.onscroll = function (e) {
        if (window.pageYOffset >= scrollThreshold) {
            controlPanel.classList.add("fix-bar");
        }
        else {
            controlPanel.classList.remove("fix-bar");
        }

    };

    // =================== Support function =============================
    /**
     * Gathering seat map setting.
     * @return {Array} seatData
     */
    function gatherSeatmapSetting() {
        var seatData = [];
        if (arrangedUserSeat.length !== 0) {
            Array.from(arrangedUserSeat).forEach(function (el) {
                seatData.push({
                    user_id: parseFloat(el.id.slice(el.id.lastIndexOf("-") + 1)),
                    x: parseFloat(el.style.left),
                    y: parseFloat(el.style.top)
                });
            });
        }
        return seatData;
    }

    /**
     * Get offsets by browser
     *
     * @param {Event} event
     * @returns [offsetX, offsetY]
     */
    function getOffsets(event) {
        if (event.offsetX || event.offsetY) {
            return [event.offsetX, event.offsetY];
        }
        else {
            return [event.layerX, event.layerY];
        }
    }

    /**
     * Set attribute for new item
     */
    function setAttributesNewSeat(seat, event) {
        seat.classList.remove("user-seat-template");
        seat.classList.add("user-seat");
        seat.removeAttribute("hidden");
        seat.id = "user-seat-" + event.dataTransfer.getData("object_id");
        seat.querySelector(".avatar").setAttribute("src", event.dataTransfer.getData("avatar"));
        seat.querySelector("div.name").innerHTML = event.dataTransfer.getData("name");
        seat.querySelector(".info-avatar img").setAttribute("src", event.dataTransfer.getData("avatar"));
        seat.querySelector(".info-user .name").innerHTML = event.dataTransfer.getData("name");
        seat.querySelector(".info-user .group").innerHTML = event.dataTransfer.getData("group");
        seat.querySelector(".info-user .phone").innerHTML = event.dataTransfer.getData("phone");
        seat.querySelector(".info-user .email").innerHTML = event.dataTransfer.getData("email");
        seat.querySelector(".info-user .email").innerHTML = event.dataTransfer.getData("email");
        seat.querySelector(".remove-arranged-user").dataset.id = event.dataTransfer.getData("object_id");
        seat.querySelector(".remove-arranged-user").dataset.name = event.dataTransfer.getData("name");
    }
});

