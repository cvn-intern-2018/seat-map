document.addEventListener("DOMContentLoaded", function(e){
    /**
     * Initial data
     */
    var avatarSize = 80;
    var mapWidth = 0;
    var mapHeight = 0;
    var waiterSetTimeOut = 0;
    var seatmap = document.querySelector(".seatmap-container");
    var seatData = {};
    window.onload = function(){
        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;
    }
    var arrangedUserSeat = document.getElementsByClassName("user-seat");
    var userList = document.querySelectorAll(".user-list .user-select");

    /**
     * Get current seatmap data
     */
    if (arrangedUserSeat.length !== 0) {
        Array.from(arrangedUserSeat).forEach(function(el){
            seatData[parseInt(el.id.slice(el.id.lastIndexOf("-")+1))] =  {       
                x: parseInt(el.style.left),
                y: parseInt(el.style.top)
            }
        });
    }
    document.getElementById("seat_data").value = JSON.stringify(seatData);

    /**
     * Add event listener for arranged users
     */
    function arrangedDragHandler(e) {
        e.dataTransfer.setData("object_id", this.id.slice(this.id.lastIndexOf("-")+1));
        if (e.offsetX || e.offsetY) {
            e.dataTransfer.setData("pointer_x", e.offsetX);
            e.dataTransfer.setData("pointer_y", e.offsetY);
        }
        else {
            e.dataTransfer.setData("pointer_x", e.layerX);
            e.dataTransfer.setData("pointer_y", e.layerY);
        }
    }
    function arrangedClickHandler(){
        if (this.classList.contains("active")) {
            this.classList.remove("active");
        }
        else {
            this.classList.add("active");
        }
    }
    function removeArrangedUser() {
        document.querySelector("#remove-confirm .remove-confirmed").dataset.id = this.dataset.id;
        document.querySelector("#remove-confirm .remove-name").innerHTML = this.dataset.name;
    }

    for (i = 0; i < arrangedUserSeat.length; i++){
        arrangedUserSeat[i].addEventListener("dragstart", arrangedDragHandler);
        arrangedUserSeat[i].addEventListener("click", arrangedClickHandler);
        arrangedUserSeat[i].querySelector(".remove-arranged-user").addEventListener("click", removeArrangedUser);
    }
    seatmap.addEventListener("dragover", function(e){
        e.preventDefault();
    });

    /**
     * Add event listenser for non-arranged user
     */
    for (i = 0; i < userList.length; i++){
        userList[i].addEventListener("dragstart", function(e){
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
     * Add event handler for drop area
     */
    seatmap.addEventListener("drop", function(e){
        e.preventDefault();
        
        if (e.dataTransfer.getData("type") === "new") {
            // Clone object
            var newSeat = document.querySelector(".user-seat-template").cloneNode(true);
            newSeat.classList.remove("user-seat-template");
            newSeat.classList.add("user-seat");
            newSeat.removeAttribute("hidden");

            // Add attributes
            newSeat.id = "user-seat-" + e.dataTransfer.getData("object_id");
            newSeat.querySelector(".avatar").setAttribute("src", e.dataTransfer.getData("avatar"));
            newSeat.querySelector("div.name").innerHTML = e.dataTransfer.getData("name");
            newSeat.querySelector(".info-avatar img").setAttribute("src", e.dataTransfer.getData("avatar"));
            newSeat.querySelector(".info-user .name").innerHTML = e.dataTransfer.getData("name");
            newSeat.querySelector(".info-user .group").innerHTML = e.dataTransfer.getData("group");
            newSeat.querySelector(".info-user .phone").innerHTML = e.dataTransfer.getData("phone");
            newSeat.querySelector(".info-user .email").innerHTML = e.dataTransfer.getData("email");
            newSeat.querySelector(".info-user .email").innerHTML = e.dataTransfer.getData("email");
            newSeat.querySelector(".remove-arranged-user").dataset.id = e.dataTransfer.getData("object_id");

            // Add styles
            newSeat.style.top = (e.layerY / mapHeight * 100 ) + "%" ;
            newSeat.style.left = (e.layerX / mapWidth * 100 ) + "%";
            
            // Add events
            newSeat.addEventListener("dragstart", arrangedDragHandler);
            newSeat.addEventListener("click", arrangedClickHandler);
            newSeat.querySelector(".remove-arranged-user").addEventListener("click", removeArrangedUser)

            // Set in position
            seatmap.appendChild(newSeat);

            // Remove in user list
            document.querySelector(".user-list .user-select[data-id=\"" + e.dataTransfer.getData("object_id") +"\"]").
            setAttribute("hidden", "");

            // Update seatData object
            seatData[e.dataTransfer.getData("object_id")] = {
                x: parseInt(e.layerX / mapWidth * 100 ),
                y: parseInt(e.layerY / mapHeight * 100 )
            }
            document.getElementById("seat_data").value = JSON.stringify(seatData);
        }
        else {
            if (e.dataTransfer.getData("object_id")) {
                var obj = document.getElementById("user-seat-" + e.dataTransfer.getData("object_id"));
                var pointerX = parseInt(e.dataTransfer.getData("pointer_x"));
                var pointerY = parseInt(e.dataTransfer.getData("pointer_y"));
                if (e.offsetX || e.offsetY) {
                    obj.style.top = ((e.offsetY + avatarSize / 2 - pointerY) / mapHeight * 100 ) + "%" ;
                    obj.style.left = ((e.offsetX + avatarSize / 2 - pointerX ) / mapWidth * 100 ) + "%";
                    seatData[e.dataTransfer.getData("object_id")] = {
                        x: parseInt((e.offsetX + avatarSize / 2 - pointerX ) / mapWidth * 100),
                        y: parseInt((e.offsetY + avatarSize / 2 - pointerY) / mapHeight * 100 )
                    }
                }
                else {
                    obj.style.top = ((e.layerY + avatarSize / 2 - pointerY) / mapHeight * 100 ) + "%" ;
                    obj.style.left = ((e.layerX + avatarSize / 2 - pointerX ) / mapWidth * 100 ) + "%";
                    seatData[e.dataTransfer.getData("object_id")] = {
                        x: parseInt((e.layerX + avatarSize / 2 - pointerX ) / mapWidth * 100),
                        y: parseInt((e.layerY + avatarSize / 2 - pointerY) / mapHeight * 100 )
                    }
                }
                document.getElementById("seat_data").value = JSON.stringify(seatData);
            }
        }
    });

    /**
     * Add event listener for zoom button
     */
    document.querySelector("button.zoom-in").addEventListener("click", function(){
        try {
            var zoom = parseInt(seatmap.dataset.zoom);
            if (zoom < 4) {
                seatmap.dataset.zoom = zoom + 1;
            }
        }
        catch(e) {
            seatmap.dataset.zoom = 1
        }
        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;
    });
    document.querySelector("button.zoom-out").addEventListener("click", function(){
        try {
            var zoom = parseInt(seatmap.dataset.zoom);
            if (zoom > 1) {
                seatmap.dataset.zoom = zoom - 1;
            }
        }
        catch(e) {
            seatmap.dataset.zoom = 1
        }

        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;
    });

    /**
     * Add event listener for remove user button
     */
    document.querySelector("#remove-confirm .remove-confirmed").addEventListener("click", function(){
        var user_seat = document.querySelector(".seatmap-container #user-seat-"+this.dataset.id);
        user_seat.parentNode.removeChild(user_seat);
        document.querySelector(".user-list .user-select[data-id=\""+this.dataset.id+"\"]").removeAttribute("hidden");
    });

    /**
     * Add event listener for search user input
     */
    document.querySelector("#keyword").addEventListener("keyup", function(){
        clearTimeout(waiterSetTimeOut);
        var _this = this;
        waiterSetTimeOut = setTimeout(function(){
            var key = _this.value;
            console.log(key.length);
            if (key !== "") {
                Array.from(userList).forEach(function(el){
                    el.style.display="none";
                });
                Array.from(userList).filter(function(el) {
                    if (el.dataset.name.indexOf(key) !== -1) {
                        return true;
                    }
                    return false;
                }).forEach(function(el){
                    el.style.display="";
                })
            }
            else {
                Array.from(userList).forEach(function(el){
                    el.style.display="";
                });
            }
        }, 500);
    })
})