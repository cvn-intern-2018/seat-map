function changeAva() {

            var output = document.getElementById("avatar");
    output.src = URL.createObjectURL(event.target.files[0]);
};
function deleteAva() {
    document.getElementById('avatar').src = "#";
    document.querySelector("input[id=changeAvar]").value = "";    
};
function changeAvaPopup() {
            var output = document.getElementById("imagePopup");
    output.src = URL.createObjectURL(event.target.files[0]);
    // output.src="a";
};


function deleteAvaPopup() {
    document.getElementById('imagePopup').src = "#";
    document.querySelector("input[id=changeAvarPopup]").value = "";    
};

// function to display information of a user
function displayUser(currentItem){
    var infor = currentItem.dataset.info;
    var items = document.querySelectorAll("p[name=name]");
    for(i = 0; i < items.length; i++){
        items[i].classList.remove("active");
    }
    // change backgroundColor
    currentItem.classList.add("active");
    displayUserInfor(infor);

}



function displayUserInfor(infor) {
    //reset backgroundColor
    infor = JSON.parse(infor);
    document.querySelector("form[name=infor] img[id=avatar]").src = "images/user/" + infor.username + infor.avatar;
    document.querySelector("form[name=infor] input[name=shortname]").value = infor.shortname;
    document.querySelector("form[name=infor] input[name=fullname]").value = infor.fullname;
    document.querySelector("form[name=infor] input[name=email]").value = infor.email;
    document.querySelector("form[name=infor] input[name=phone]").value = infor.phone;
    document.querySelector("form[name=infor] input[name=user_id]").value = infor.id;
    // document.querySelector("form[name=infor] select[name=group_id]").selectedIndex = infor.group_id;
    var sel = document.querySelector("form[name=infor] select[name=group_id]");
    for(var i = 0, j = sel.options.length; i < j; ++i) {
        if(sel.options[i].innerHTML === infor.group) {
            sel.selectedIndex = i;
            break;
        }
    }
    document.querySelector("form[name=infor] input[name=user_id]").value = infor.id;
};


function discardChanges(){
    var infor;
    var items = document.querySelectorAll("p");
    items.forEach(function(element){
        if(element.classList.contains("active")){
            infor = element.dataset.info;
        }
    });
    displayUserInfor(infor);


}

// edit user information
function editUser(event){
    event.preventDefault();
    var form = document.querySelector("#right form");
    var formData = new FormData(form);
    //confirm
    if(confirm("Do you want to continue?")){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                 console.log(JSON.parse(this.responseText).userInfor);
                if(JSON.parse(this.responseText).status == "Success"){
                    var items = document.querySelectorAll("p");
                    var _result = JSON.parse( this.responseText);
                    items.forEach(function(element){
                        if(element.classList.contains("active")){
                            console.log(element.dataset.info);
                            console.log(_result);
                            element.dataset.info = JSON.stringify(_result.userInfor);
                        }
                    });
                }
            }
        }
        xmlhttp.open("POST", "/users/edit", true);
        xmlhttp.send(formData);
    } 
};

function hidePopup(){
    document.getElementById('id01').style.display='none'
}


//function to add a user to the list
function addUser(event){
    event.preventDefault();
    var form = document.querySelector("form[name=inforPopup]");
    var formData = new FormData(form);
    //confirm
    if(confirm("Do you want to continue?")){


        // check if existed in the database
        // from the database
        // event.preventDefault();
        // if (currentItem.name.length == 0) {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // var abc = JSON.parse(this.responseText);
                console.log(this.responseText);
                if(JSON.parse(this.responseText).status == "Error"){
                    var userInforErr = JSON.parse(this.responseText).userInforErr;
                    // console.log(userInforErr);
                    alert(JSON.stringify(userInforErr, null, 4));
                    //alert(JSON.stringify(userInfor, null, 4));
                }else{
                    console.log(this.responseText);
                    var _result = JSON.parse( this.responseText); 
                    // add on the screen
                    var nodeLi = document.createElement("li");
                    nodeLi.className += "flex-container";
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "name");
                    nodeP.onclick = function(){displayUser(this)};
                    nodeP.dataset.info = JSON.stringify(_result.userInfor);
                    console.log(_result.userInfor);
                    // nodeP.appendChild(document.createTextNode(JSON.parse(this.responseText).fullname);
                    nodeP.innerHTML = _result.userInfor.fullname;
                    var nodeBtn = document.createElement("button");
                    nodeBtn.setAttribute('name', JSON.stringify(_result.userInfor.fullname));
                    nodeBtn.onclick=function(){deleteUser(this)};
                    nodeBtn.appendChild(document.createTextNode("Delete"));
                    nodeLi.appendChild(nodeP);
                    nodeLi.appendChild(nodeBtn);
                    var items = document.querySelector("ul[id=list-of-users]");
                    items.insertBefore(nodeLi, items.childNodes[1]);
                    document.getElementById('id01').style.display='none';
                    document.querySelector("form[name=infor] input[name=user_id]").value = JSON.stringify(_result.userInfor.id);
                }
    

            }

        }
        xmlhttp.open("POST", "/users/add", true);
        xmlhttp.send(formData);

        } 
};

// function to delete a user
function deleteUser(currentItem){
    //confirm
    // console.log(currentItem);
    if(confirm("Do you want to delete \"" + currentItem.name + "\" ?")){
        // on the screen
        var child = currentItem.parentNode;
        child.parentNode.removeChild(child);
        // check if existed in the database
        // from the database
        // event.preventDefault();
        if (currentItem.name.length == 0) {
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // var abc = JSON.parse(this.responseText);
                //console.log(this.responseText);
                alert("Successful");
                // alert("successful");
            }
        }
        xmlhttp.open("GET", "/users/delete/{name}?name=" + currentItem.name, true);
        xmlhttp.send();
      
        } 
    }else{

    }
};