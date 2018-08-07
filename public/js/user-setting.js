//function to change avatar
function changeAvatar(event) {
    var output = document.querySelector("#avatar");
    output.src = URL.createObjectURL(event.target.files[0]);
    document.querySelector("input[name=checkAvatar]").value = 0;
};

function deleteAvatar() {
    document.querySelector("#avatar").src = "";
    document.querySelector("input[id=changeAvar]").value = "";
    document.querySelector("input[name=checkAvatar]").value = 1;

};

// function to display information of a user
function displayUser(currentItem) {
    var infor = currentItem.dataset.info;
    var items = document.querySelectorAll("p[name=name]");
    // reset
    for(i = 0; i < items.length; i++){
        items[i].classList.remove("active");
    }
    // change backgroundColor
    currentItem.classList.add("active");
    if(document.getElementById("list-of-users").dataset.prv_data.length <= 2){
        var items = document.querySelectorAll("#right p[name=Error]");
        items.forEach(function (item) {
            item.parentNode.removeChild(item);
        })
    }
    document.querySelector("input[id=changeAvar]").value = "";
    document.querySelector("input[name=checkAvatar]").value = 0;
    document.querySelector("#list-of-users").dataset.info = JSON.parse(infor).id;
    // display information
    displayUserInfor(infor);
}

// display information
function displayUserInfor(infor) {
    if(document.getElementById("list-of-users").dataset.prv_data.length > 2){
        infor = document.getElementById("list-of-users").dataset.prv_data;
    }
    infor = JSON.parse(infor);
    document.querySelector("form[name=infor] img[id=avatar]").src = "images/user/" + infor.id + infor.avatar;
    document.querySelector("form[name=infor] input[name=short_name]").value = infor.shortname;
    document.querySelector("form[name=infor] input[name=fullname]").value = infor.fullname;
    document.querySelector("form[name=infor] input[name=email]").value = infor.email;
    document.querySelector("form[name=infor] input[name=phone]").value = infor.phone;
    document.querySelector("form[name=infor] input[name=user_id]").value = infor.id;
    document.querySelector("form[name=infor] input[name=username]").value = infor.username;
    document.querySelector("form[name=infor] input[name=password]").value = infor.password;
    var sel = document.querySelector("form[name=infor] select[name=group_id]");
    for (var i = 0, j = sel.options.length; i < j; ++i) {
        if (sel.options[i].innerHTML === infor.group) {
            sel.selectedIndex = i;
            break;
        }
    }
    document.querySelector("form[name=infor] input[name=user_id]").value = infor.id;
    document.getElementById("list-of-users").dataset.prv_data = "";
};

// discard changes after clicking on button cancel
function discardChanges(){
    var infor;
    var items = document.querySelectorAll("p");
    items.forEach(function (element) {
        if (element.classList.contains("active")) {
            infor = element.dataset.info;
        }
    });
    items = document.querySelectorAll("p[name=Error]");
    items.forEach(function(item){
        item.parentNode.removeChild(item);
    })
    document.querySelector("input[name=checkAvatar]").value = 0;
    displayUserInfor(infor);
}

// function to hide a pop-up
function hidePopup(){
    document.getElementById('id01').style.display='none';
};

// function to show a pop-up
function showPopup(){
    document.getElementById('id01').style.display='block';
};

//function to add a user
function addUser(event){
    event.preventDefault();
    var form = document.querySelector("form[name=inforPopup]");
    var formData = new FormData(form);
    var child = document.querySelectorAll("form[name=inforPopup] p[name=Error]");
    for(var i = 0; i < child.length; i++){
        child[i].parentNode.removeChild(child[i]);
    }
    var response = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            if(response.status == "Error"){
                var userInforErr = response.userInforErr;
                var child = "";
                var item = "";
                if(userInforErr.fullnameErr){
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "Error");
                    child = document.querySelector("form[name=inforPopup] input[name=fullname]");                    
                    nodeP.innerHTML = JSON.stringify(userInforErr.fullnameErr);
                    item = child.parentNode;
                    item.insertBefore(nodeP, child.nextSibling);
                }
                if(userInforErr.usernameErr){
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "Error");
                    child = document.querySelector("form[name=inforPopup] input[name=username]");
                    nodeP.innerHTML = JSON.stringify(userInforErr.usernameErr);
                    item = child.parentNode;
                    item.insertBefore(nodeP, child.nextSibling);
                }
                if(userInforErr.passwordErr){
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "Error");
                    nodeP.innerHTML = JSON.stringify(userInforErr.passwordErr);
                    child = document.querySelector("form[name=inforPopup] input[name=password]");
                    item = child.parentNode;
                    item.insertBefore(nodeP, child.nextSibling);
                }
                if(userInforErr.shortnameErr){
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "Error");                        
                    child = document.querySelector("form[name=inforPopup] input[name=short_name]");
                    nodeP.innerHTML = JSON.stringify(userInforErr.shortnameErr);
                    item = child.parentNode;
                    item.insertBefore(nodeP, child.nextSibling);
                }
                if(userInforErr.phoneErr){
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "Error");
                    nodeP.innerHTML = JSON.stringify(userInforErr.phoneErr);
                    child = document.querySelector("form[name=inforPopup] input[name=phone]");
                    item = child.parentNode;
                    item.insertBefore(nodeP, child.nextSibling);
                }
                if(userInforErr.emailErr){
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "Error");
                    nodeP.innerHTML = JSON.stringify(userInforErr.emailErr);
                    child = document.querySelector("form[name=inforPopup] input[name=email]");
                    item = child.parentNode;
                    item.insertBefore(nodeP, child.nextSibling);
                }
            }else{
                var _result = JSON.parse( this.responseText); 
                // add on the screen
                var nodeLi = document.createElement("li");
                nodeLi.className = "flex-container_";
                var nodeP = document.createElement("p");
                nodeP.setAttribute('name', "name");
                nodeP.onclick = function(){displayUser(this)};
                nodeP.dataset.info = JSON.stringify(response.userInfor);
                console.log(_result.userInfor);
                nodeP.innerHTML = response.userInfor.fullname;
                var nodeImg = document.createElement("img");
                nodeImg.setAttribute('name', response.userInfor.fullname);
                console.log(response.userInfor.fullname);
                nodeImg.onclick = function(){deleteUser(this)};
                nodeImg.setAttribute('src', "images\/remove.png");
                nodeImg.setAttribute('alt', "delete");
                var nodeDiv = document.createElement("div");
                nodeDiv.appendChild(nodeImg);
                nodeLi.appendChild(nodeP);
                nodeLi.appendChild(nodeDiv);
                var items = document.querySelector("ul[id=list-of-users]");
                items.insertBefore(nodeLi, items.childNodes[4]);
                document.getElementById('id01').style.display='none';
                document.querySelector("form[name=infor] input[name=user_id]").value = JSON.stringify(response.userInfor.id);             
            }
        }
    }
    xmlhttp.open("POST", "/users/add", true);
    xmlhttp.send(formData); 
};

// function to delete a user
function deleteUser(currentItem){
    if(confirm("Do you want to delete \"" + currentItem.name + "\" ?")){

        // delete in the database
        if (currentItem.name.length == 0) {
            return;
        } else {
            //send request
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //get response
                if(JSON.parse(this.responseText).status == "Error"){
                    alert(JSON.parse(this.responseText).status);
                }else{
                    // delete on the screen
                    // currentItem was a button
                    // get parentNode 
                    var node = currentItem.parentNode.parentNode;
                    // delete parentNode
                    node.parentNode.removeChild(node);
                    alert(JSON.parse(this.responseText).status);
                }
            }
        }
        xmlhttp.open("GET", "/users/delete/{name}?name=" + currentItem.name, true);
        xmlhttp.send();
        } 
    }
};

// function to return to the previous displayUser function
// after the page has been reloaded
(function(){
    $(document).ready(function(){
    // get id
    var infor = document.querySelector("#list-of-users").dataset.info;
    // get user
    var items = document.querySelectorAll("p[name=name]");
    for(i = 0; i < items.length; i++){
        if(infor == JSON.parse(items[i].dataset.info).id){
            displayUser(items[i]);
            return;
        }
    }
    displayUser(items[0]); 
    })

})($)


// addEventListener
window.onload = function(){
    // hide pop-up
    document.querySelector("input[name=inptCancelPopup]").addEventListener("click", hidePopup);
    // show pop-up
    document.querySelector("#left p[name=addUser]").addEventListener("click", showPopup);
    // displayUser
    document.querySelectorAll("#left p[name=name]").forEach(function(item){
        item.addEventListener("click", function(){
                displayUser(this);
            });
    });
    // delete a user
    document.querySelectorAll("#left img").forEach(function(item){
        item.addEventListener("click", function(){
                deleteUser(this)
            });
    });
    // change avatar
    document.querySelector("#right input[type=file]").addEventListener("change", function(){
        changeAvatar(event);
    });
    // discard changes
    document.querySelector("#right input[name=cancel]").addEventListener("click", discardChanges);

    // submit pop-up
    document.querySelector("form[name=inforPopup]").addEventListener("submit", function(){
        addUser(event);
    });    
}


