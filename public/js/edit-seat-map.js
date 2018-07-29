document.addEventListener("DOMContentLoaded", function(e){
    /**
     * Initial data
     */
    var avatarSize = 80;
    var mapWidth = 0;
    var mapHeight = 0;
    var seatmap = document.querySelector(".seatmap-container");
    window.onload = function(){
        mapWidth = seatmap.clientWidth;
        mapHeight = seatmap.clientHeight;
    }
    var arrangedUserSeat = document.getElementsByClassName("user-seat");
    var userList = document.querySelectorAll(".user-list .user-select");

    /**
     * Add event listener for arranged users
     */
    for (i = 0; i < arrangedUserSeat.length; i++){
        arrangedUserSeat[i].addEventListener("dragstart", function(e){
            e.dataTransfer.setData("object_id", this.id);
            e.dataTransfer.setData("pointer_x", e.layerX);
            e.dataTransfer.setData("pointer_y", e.layerY);
        });
        arrangedUserSeat[i].addEventListener("click", function(){
            if (this.classList.contains("active")) {
                this.classList.remove("active");
            }
            else {
                this.classList.add("active");
            }
        });
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
            e.dataTransfer.setData("object_id", this.id);
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
            var newSeat = document.querySelector(".user-seat-template").cloneNode(true);
            newSeat.classList.remove("user-seat-template");
            newSeat.classList.add("user-seat");
            newSeat.removeAttribute("hidden");
            newSeat.id = "user-seat-" + e.dataTransfer.getData("object_id");

            newSeat.style.top = (e.layerY / mapHeight * 100 ) + "%" ;
            newSeat.style.left = (e.layerX / mapWidth * 100 ) + "%";

            newSeat.querySelector(".avatar").setAttribute("src", e.dataTransfer.getData("avatar"));
            newSeat.querySelector("div.name").innerHTML = e.dataTransfer.getData("name");
            newSeat.querySelector(".info-avatar img").setAttribute("src", e.dataTransfer.getData("avatar"));
            newSeat.querySelector(".info-user .name").innerHTML = e.dataTransfer.getData("name");
            newSeat.querySelector(".info-user .group").innerHTML = e.dataTransfer.getData("group");
            newSeat.querySelector(".info-user .phone").innerHTML = e.dataTransfer.getData("phone");
            newSeat.querySelector(".info-user .email").innerHTML = e.dataTransfer.getData("email");

            seatmap.appendChild(newSeat);

        }
        else {
            if (e.dataTransfer.getData("object_id")) {
                var obj = document.getElementById(e.dataTransfer.getData("object_id"));
                var pointerX = e.dataTransfer.getData("pointer_x")
                var pointerY = e.dataTransfer.getData("pointer_y")
                obj.style.top = ((e.layerY + avatarSize / 2 - pointerY) / mapHeight * 100 ) + "%" ;
                obj.style.left = ((e.layerX + avatarSize / 2 - pointerX ) / mapWidth * 100 ) + "%";
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
})