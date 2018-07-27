

<div>
	<input type="text" name="name" placeholder="Enter a name here" value="" />
	<input type="text" value="save"  onkeyup="adduser(this.value)" />
</div>
<div>
	<ul id="tetete">@foreach($users as $user)
				<li onclick="myFunction( '{{ $userj[$user->id] }}')">{{ $user->name }}</li>
				@endForeach
        </ul>
</div>
<form action="/users" method="POST" redirect="{{ route('getusers') }}">@csrf
    <input id="demo2" name="email" type="text" value="" />
    <input id="demo3" name="name" type="text" value="" />
    <input id="demo4" name="phonenumber" type="text" value="" />
    <input id="demo5" name="group" type="text" value="" />
	<button type="submit" value="Save">Save</button>
</form>


<script>
function myFunction(av) {
	console.log(av);
	av = JSON.parse(av);

                    document.getElementById("demo2").value = av.name;
                    document.getElementById("demo3").value = av.email;
                    // document.getElementById("demo4").value = av;
                    // document.getElementById("demo5").value = av;
}
function adduser(str) {
    if (str.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tetete").innerHTML = JSON.parse(this.responseText).data.name;
            }
        };
        xmlhttp.open("GET", "/add?q=" + str, true);
        xmlhttp.send();
    }
}
</script>

