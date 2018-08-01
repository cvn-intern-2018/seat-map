<!DOCTYPE html>
<html>
<head>
    <title>
        User information
    </title>
    <link href="css/user-setting.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="id01" class="modal">
            <form name="inforPopup" class="modal-content animate" action="/users/add" onsubmit="addUser(event)" method="POST" >
                @csrf
                <div class="container">
                      <p><b>Full name:</b></p>
                      <input name="fullname" value="" type="text" placeholder="Enter full name" />
                      <p><b>Username:</b></p>
                      <input name="username" value="" type="text" placeholder="Enter username" />
                      <p><b>Phone number:</b></p>
                      <input name="phone" value="" type="text" placeholder="Enter phone number" />
                      <p><b>Email:</b></p>
                      <input name="email" value="" type="text" placeholder="Enter email" />
                      <p><b>Group:</b></p>
                      <select name="group_id" >
                          <option value="1">Cybozu</option>
                          <option value="2">Cyboz</option>
                          <option value="3">Cybo</option>
                      </select>
                      <p><b>Password:</b></p>
                      <input name="password" value="" type="password" placeholder="Enter password" />
                      <div >
                          <input name="inptSubmitPopup" type="submit" />
                          <input onclick="document.getElementById('id01').style.display='none'" name="inptCancelPopup" value="Cancel"/>
                      </div>
                    </div>
          </form>

    </div>
    <div class="flex-container">
        <!-- display all users -->
        <div id="left">
            <p>Select a user</p>
            <ul id="list-of-users">
                <li class="flex-container">
                    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" name="addUser">Add a new user</button>
                </li>
                <li class="flex-container">
                    <p class="active" name="name" onclick="displayUser(this)" data-info="{{ $admin }}">Admin</p>
                    <button style="visibility: hidden;" name="admin" type="button" >Delete</button>
                </li>
                @foreach($users as $user)
                @if($user->permission == 0)
                <li class="flex-container">
                    <p name="name" onclick="displayUser(this)" data-info="{{ $userj[$user->id] }}">{{ $user->name }}</p>
                    <button name="{{ $user->name }}" onclick="deleteUser(this)" type="button" >Delete</button>
                </li>
                @endif
                @endForeach

            </ul>
        </div>

        <!-- display information of a user -->
        <div id="right" class="flex-container">
            <div class="flex-container">
                <div>
                    <img id="avatar" src="#" alt="avatar" />
                </div>
                <div class=flex-container>
                    <button onclick="document.getElementById('changeAvar').click()" name="changeAvar" type="button">Change</button>
                    <input style="display:none;" onchange="changeAvar(event)" type="file" accept="image/*" id="changeAvar" name="changeAvar"  />
                    <button onclick="deleteAvar()" type="button" name="deleteAvar">Delete</button>
                </div>

            </div>
            <div>
                <form name="infor" class="flex-container" action="/users" onsubmit="editUser(event)" method="POST" >@csrf
                    <p><strong>Full name:</strong></p>
                    <input type="text" name="fullname" value="{{json_decode($admin)->fullname}}" />
                    <p><strong>Username:</strong></p>
                    <input type="text" name="username" value="{{json_decode($admin)->username}}" />
                    <p><strong>Phone number:</strong></p>
                    <input type="text" name="phone" value="{{json_decode($admin)->phone}}" />
                    <p><strong>Email:</strong></p>
                    <input type="text" name="email" value="{{json_decode($admin)->email}}" />
                    <p><strong>Group:</strong></p>

                    <select name="group_id" />
                        @foreach($groups as $group)
                        @if($group->name == json_decode($admin)->group)
                        <option value="" selected>{{ $group->name }}</option>
                        @else
                        <option value="">{{ $group->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <p><strong>Password:</strong></p>
                    <input type="text" name="password" value="{{json_decode($admin)->password}}" />
                    <input type="text" style="display: none;" value="{{json_decode($admin)->id}}" name="user_id" />
                    <input type="submit" value="Save" />
                    <input type="button" onclick="discardChanges()" value="Cancel" />
                </form>
            </div>
            
        </div>
    </div>



</body>

<!-- javascript -->
<script>
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
                    //console.log(this.responseText);
                    if(JSON.parse(this.responseText).status == "Error"){
                        var userInforErr = JSON.parse(this.responseText).userInforErr;
                        // console.log(userInforErr);
                        alert(JSON.stringify(userInforErr, null, 4));
                        //alert(JSON.stringify(userInfor, null, 4));
                    }else{
                        // alert(this.responseText);
                        // add on the screen
                        var nodeLi = document.createElement("li");
                        nodeLi.className += "flex-container";
                        var nodeP = document.createElement("p");
                        nodeP.setAttribute('name', "name");
                        nodeP.onclick = function(){displayUserInfor(this, '{{ $userj[$user->id] }}')};
                        // nodeP.appendChild(document.createTextNode(JSON.parse(this.responseText).fullname);
                        nodeP.innerHTML = JSON.parse(this.responseText).fullname;
                        var nodeBtn = document.createElement("button");
                        nodeBtn.setAttribute('name', "{{$user->name}}");
                        nodeBtn.onclick=function(){deleteUser(this)};
                        nodeBtn.appendChild(document.createTextNode("Delete"));
                        nodeLi.appendChild(nodeP);
                        nodeLi.appendChild(nodeBtn);
                        document.querySelector("ul[id=list-of-users]").appendChild(nodeLi);
                        document.getElementById('id01').style.display='none';
                    }
        

                }
                // else{
                //     alert(this.responseText);
                // }
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

    // function for validation 
    function checkInput(src){
        var regex = /^[a-zA-Z0-9]+$/;
        var bool = src.match(regex);
        if(bool == null){
            return false;
        }else{
            return true;
        }


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
        // console.log(this.dataset);



        // console.log(av);
        // currentItem.classList.add("active");
        infor = JSON.parse(infor);
        document.querySelector("form[name=infor] input[name=username]").value = infor.username;
        document.querySelector("form[name=infor] input[name=password]").value = infor.password;
        document.querySelector("form[name=infor] input[name=fullname]").value = infor.fullname;
        document.querySelector("form[name=infor] input[name=email]").value = infor.email;
        document.querySelector("form[name=infor] input[name=phone]").value = infor.phone;
        // document.querySelector("form[name=infor] select[name=group_id]").selectedIndex = infor.group_id;
        var sel = document.querySelector("form[name=infor] select[name=group_id]");
        for(var i = 0, j = sel.options.length; i < j; ++i) {
            if(sel.options[i].innerHTML === infor.group) {
                sel.selectedIndex = i;
                break;
            }
        }
        // console.log(infor.group_id);
        document.querySelector("form[name=infor] input[name=user_id]").value = infor.id;

       

    };

    // testing
    function editUser(event){
        event.preventDefault();
        var form = document.querySelector("form[name=infor]");
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
                    //console.log(this.responseText);
                    if(JSON.parse(this.responseText).status == "Error"){

                        var userInforErr = JSON.parse(this.responseText).userInforErr;
                        // console.log(userInforErr);
                        alert(JSON.stringify(userInforErr, null, 4));
                        //alert(JSON.stringify(userInfor, null, 4));
                    }
                    else{
                        alert(JSON.parse(this.responseText).status);
                    }
        

                }
                // else{
                //     alert(this.responseText);
                // }
            }
            xmlhttp.open("POST", "/users/edit", true);
            xmlhttp.send(formData);

            } 
    };

    function changeAvar(event) {
        var output = document.getElementById('avatar');
        output.src = URL.createObjectURL(event.target.files[0]);
        // console.log(output.src);
    };

    function deleteAvar(event) {
        document.getElementById('avatar').src = "#";
        document.querySelector("input[id=changeAvar]").value = "";    };

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

</script>

</html>



