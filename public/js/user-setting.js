function changeAva(event) {

    var output = document.getElementById("avatar");
        output.src = URL.createObjectURL(event.target.files[0]);
    // document.querySelector("input[name=checkAvatar]").value = 0;
};

function deleteAva() {
    document.getElementById('avatar').src = "";
    document.querySelector("input[id=changeAvar]").value = "";
    document.querySelector("input[name=checkAvatar]").value = 1;

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
    if(document.getElementById("list-of-users").dataset.old.length <= 2){
        var items = document.querySelectorAll("#right p[name=Error]");
        items.forEach(function(item){
            item.parentNode.removeChild(item);
        })
    }
    document.querySelector("#list-of-users").dataset.info = JSON.parse(infor).id;
    displayUserInfor(infor);

}

function displayUserInfor(infor) {
    //reset backgroundColor
    if(document.getElementById("list-of-users").dataset.old.length > 2){
        infor = document.getElementById("list-of-users").dataset.old;
    }
    // console.log(infor.length <=2);
    // console.log(infor.length);
    // if(infor.length <= 2){
    //     infor = infor;
    // }
    infor = JSON.parse(infor);
    // console.log(infor);
    document.querySelector("form[name=infor] img[id=avatar]").src = "images/user/" + infor.username + infor.avatar;
    document.querySelector("form[name=infor] input[name=short_name]").value = infor.shortname;
    document.querySelector("form[name=infor] input[name=fullname]").value = infor.fullname;
    document.querySelector("form[name=infor] input[name=email]").value = infor.email;
    document.querySelector("form[name=infor] input[name=phone]").value = infor.phone;
    document.querySelector("form[name=infor] input[name=user_id]").value = infor.id;
    document.querySelector("form[name=infor] input[name=username]").value = infor.username;
    document.querySelector("form[name=infor] input[name=password]").value = infor.password;
    // console.log(document.querySelector("form[name=infor] input[name=user_id]").value);
    // document.querySelector("form[name=infor] select[name=group_id]").selectedIndex = infor.group_id;
    var sel = document.querySelector("form[name=infor] select[name=group_id]");
    for(var i = 0, j = sel.options.length; i < j; ++i) {
        if(sel.options[i].innerHTML === infor.group) {
            sel.selectedIndex = i;
            break;
        }
    }
    document.querySelector("form[name=infor] input[name=user_id]").value = infor.id;
    document.getElementById("list-of-users").dataset.old = "";
    
};

function discardChanges(){
    var infor;
    var items = document.querySelectorAll("p");
    items.forEach(function(element){
        if(element.classList.contains("active")){
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
            console.log(this.responseText);
        }
        xmlhttp.open("POST", "/users/edit", true);
        xmlhttp.send(formData);
    } 
};

function hidePopup(){
    document.getElementById('id01').style.display='none'
};

//function to add a user to the list
function addUser(event){
    event.preventDefault();
    var form = document.querySelector("form[name=inforPopup]");
    var formData = new FormData(form);
    //confirm
            var child = document.querySelectorAll("form[name=inforPopup] p[name=Error]");
            for(var i = 0; i < child.length; i++){
                child[i].parentNode.removeChild(child[i]);
            }
            var response = "";
            // var nodeP = document.createElement("p");
            // nodeP.setAttribute('name', "Error");            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // var abc = JSON.parse(this.responseText);
                response = JSON.parse(this.responseText);
            if(response.status == "Error"){
                    var userInforErr = response.userInforErr;
                    var child = "";
                    var item = "";
                    // child = document.querySelectorAll("form[name=inforPopup] p[name=Error]");
                    if(userInforErr.fullnameErr){
                        var nodeP = document.createElement("p");
                        nodeP.setAttribute('name', "Error");
                        child = document.querySelector("form[name=inforPopup] input[name=fullname]");                    
                        nodeP.innerHTML = JSON.stringify(userInforErr.fullnameErr);
                        item = child.parentNode;
                        item.insertBefore(nodeP, child.nextSibling);
                        console.log("2");
                    }
                    if(userInforErr.usernameErr){
                        var nodeP = document.createElement("p");
                        nodeP.setAttribute('name', "Error");
                        child = document.querySelector("form[name=inforPopup] input[name=username]");
                        nodeP.innerHTML = JSON.stringify(userInforErr.usernameErr);
                        item = child.parentNode;
                        item.insertBefore(nodeP, child.nextSibling);
                        console.log("1");
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
                    console.log(this.responseText);
                    var _result = JSON.parse( this.responseText); 
                    // add on the screen
                    var nodeLi = document.createElement("li");
                    nodeLi.className += "flex-container";
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "name");
                    nodeP.onclick = function(){displayUser(this)};
                    nodeP.dataset.info = JSON.stringify(response.userInfor);
                    console.log(_result.userInfor);
                    // nodeP.appendChild(document.createTextNode(JSON.parse(this.responseText).fullname);
                    nodeP.innerHTML = response.userInfor.fullname;
                    var nodeBtn = document.createElement("button");
                    nodeBtn.setAttribute('name', JSON.stringify(response.userInfor.fullname));
                    nodeBtn.onclick=function(){deleteUser(this)};
                    nodeBtn.appendChild(document.createTextNode("Delete"));
                    nodeLi.appendChild(nodeP);
                    nodeLi.appendChild(nodeBtn);
                    var items = document.querySelector("ul[id=list-of-users]");
                    items.insertBefore(nodeLi, items.childNodes[4]);
                    document.getElementById('id01').style.display='none';
                    document.querySelector("form[name=infor] input[name=user_id]").value = JSON.stringify(response.userInfor.id);             
            }




                    //alert(JSON.stringify(userInfor, null, 4));
                }
            console.log(this.responseText);
        }
        xmlhttp.open("POST", "/users/add", true);
        xmlhttp.send(formData); 
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
                // alert("Successful");
                // alert("successful");
            }
        }
        xmlhttp.open("GET", "/users/delete/{name}?name=" + currentItem.name, true);
        xmlhttp.send();
      
        } 
    }else{

    }
};

(function(){

    $(document).ready(function(){

    var infor = document.getElementById("list-of-users").dataset.info;
    var items = document.querySelectorAll("p[name=name]");
    // console.log(mark == 0);
    for(i = 0; i < items.length; i++){
        if(infor == JSON.parse(items[i].dataset.info).id){
            displayUser(items[i]);
            return;
        }
    }

    displayUser(items[0]); 
    })

})($)

// add event
