<!DOCTYPE html>
<html>
<head>
    <title>
        User information
    </title>
    <link href="css/user-setting.css" rel="stylesheet" type="text/css">
</head>

<body>
<<<<<<< HEAD
    <div id="id01" class="modal">
            <form name="inforPopup" class="modal-content animate" action="/users/add" onsubmit="addUser(event)" method="POST" >
                @csrf
                <div class="container">
                      <p><b>Username:</b></p>
                      <input name="username" value="levannn" type="text" placeholder="Enter username" required>
                      <p for="fname"><b>Fullname:</b></p>
                      <input name="fullname" value="levannn"type="text" placeholder="Enter fullname" required>
                      <p><b>Email:</b></p>
                      <input name="email" value="levannn@gmail.com" type="text" placeholder="Enter email" required>
                      <p><b>Group:</b></p>
                      <input name="group_id" value="1" type="text" placeholder="Enter group" required>
                      <p><b>Password:</b></p>
                      <input name="password" value="123" type="password" placeholder="Enter password" required>
                      <div >
                          <input name="inptSubmitPopup" type="submit" />
                          <input onclick="document.getElementById('id01').style.display='none'" name="inptCancelPopup">CANCEL</name>
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
                @foreach($users as $user)
                <li class="flex-container">
                    <p name="name" onclick="displayUserInfor(this, '{{ $userj[$user->id] }}')">{{ $user->name }}</p>
                    <button name="{{ $user->name }}" onclick="deleteUser(this)" type="button">Delete</button>
                </li>
            @endForeach

        </ul>
    </div>

    <!-- display information of a user -->
    <div id="right" class="flex-container">
        <div class="flex-container">
            <div>
                <form name="infor" class="flex-container" action="/users" onsubmit="editUser(event)" method="POST" >@csrf
                    <p><strong>Full name:</strong></p>
                    <input type="text" name="name" value="" required/>
                    <p><strong>Username:</strong></p>
                    <input type="text" name="username" value="" required/>
                    <p><strong>Phone number:</strong></p>
                    <input type="text" name="phone" value="" required/>
                    <p><strong>Email:</strong></p>
                    <input type="text" name="email" value="" required/>
                    <p><strong>Group:</strong></p>
                    <select name="group_id" required/>
                        <option value=1>Cybozu</option>
                        <option value=2>Cyboz</option>
                        <option value=3>Cyb</option>
                    </select>
                    <p><strong>Password:</strong></p>
                    <input type="text" name="password" value="" required/>
                    <input type="submit" value="Save" />
                    <input type="reset" value="Cancel" />
                </form>
            </div>
            <div class=flex-container>
                <button type="button" name="changeAvar">Change</button>
                <button type="button" name="deleteAvar">Delete</button>
            </div>

        </div>
        <div>
            <form class="flex-container" action="/users" onsubmit="editUser(event)" method="POST">@csrf
                <p><strong>Full name:</strong></p>
                <input type="text" name="name" value=""/>
                <p><strong>Username:</strong></p>
                <input type="text" name="username" value=""/>
                <p><strong>Phone number:</strong></p>
                <input type="text" name="phone" value=""/>
                <p><strong>Email:</strong></p>
                <input type="text" name="email" value=""/>
                <p><strong>Group:</strong></p>
                <select name="group_id">
                    <option value=1>Cybozu</option>
                    <option value=2>Cyboz</option>
                    <option value=3>Cyb</option>
                </select>
                <p><strong>Password:</strong></p>
                <input type="text" name="password" value=""/>
                <input type="submit" value="Save"/>
                <input type="reset" value="Cancel"/>
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
        if(confirm("Sure?")){


            // check if existed in the database
            // from the database
            // event.preventDefault();
            // if (currentItem.name.length == 0) {
 
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // var abc = JSON.parse(this.responseText);
                    //console.log(this.responseText);
                    alert(this.responseText);
                    // alert("successful");

                    // add on the screen
                    var nodeLi = document.createElement("li");
                    nodeLi.className += "flex-container";
                    var nodeP = document.createElement("p");
                    nodeP.setAttribute('name', "name");
                    nodeP.onclick = function(){displayUserInfor(this, '{{ $userj[$user->id] }}')};
                    nodeP.appendChild(document.createTextNode("{{$user->name}}"));
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
            xmlhttp.open("POST", "/users/add", true);
            xmlhttp.send(formData);

            } 

    // function to delete a user
    function deleteUser(currentItem) {
        //confirm
        if (confirm("Sure?")) {
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
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // var abc = JSON.parse(this.responseText);
                        //console.log(this.responseText);
                        alert(this.responseText);
                        // alert("successful");
                    }
                }
                xmlhttp.open("GET", "/users/delete/{name}?name=" + currentItem.name, true);
                xmlhttp.send();

            }
        } else {

        }
    };

    // function for validation 
    function checkInput(src) {
        var regex = /^[a-zA-Z0-9]+$/;
        var bool = src.match(regex);
        if (bool == null) {
            return false;
        } else {
            return true;
        }


    };

    // function to display information of a user
    function displayUserInfor(currentItem, infor = 'default') {
        //reset backgroundColor
        var items = document.querySelectorAll("p[name=name]");
        for (i = 0; i < items.length; i++) {
            items[i].style.backgroundColor = "white";
            items[i].style.color = "black";
        }
        // change backgroundColor

        currentItem.style.backgroundColor = "red";
        currentItem.style.color = "black";
        // console.log(av);

        if (infor == "default") {
            document.querySelector("input[name=name]").value = "";
            document.querySelector("input[name=password]").value = "";
            document.querySelector("input[name=username]").value = "";
            document.querySelector("input[name=email]").value = "";
            document.querySelector("input[name=phone]").value = "";
            document.querySelector("select[name=group_id]").value = 0;

        } else {
            infor = JSON.parse(infor);
            document.querySelector("input[name=username]").value = infor.name;
            document.querySelector("input[name=password]").value = infor.password;
            document.querySelector("input[name=name]").value = infor.name;
            document.querySelector("input[name=email]").value = infor.email;
            document.querySelector("input[name=phone]").value = infor.phone;
            document.querySelector("select[name=group_id]").value = infor.groupid;

        }

    };

    // testing
    function editUser(event) {
        event.preventDefault();
        var form = document.querySelector("form[name=infor]");
        var formData = new FormData(form);
        if (formData.length == 0) {
            return;
        } else {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var result = JSON.parse(this.responseText);
                    if (result.status == "Error") {
                        alert(this.responseText);
                    } else {
                        alert(result.status);
                    }
                    //console.log(this.responseText);
                }

            };
            xmlhttp.open("POST", "/users/edit", true);
            xmlhttp.send(formData);
        }
    };

</script>

</html>



