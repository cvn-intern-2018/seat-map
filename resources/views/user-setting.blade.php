@extends('layouts.app')
@section('home-active','active')
@section('title','Home')
@section('big-title','Cybozu VN')
@section('content')
    <link href="css/user-setting.css" rel="stylesheet" type="text/css">
    <script src="js/user-setting.js"></script>
    <div id="id01" class="modal">
            <form name="inforPopup" class="modal-content animate" onsubmit="addUser(event)" action="/users/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                      <p><b>Full name:</b></p>
                      <input name="fullname" value="le van duc" type="text" placeholder="Enter full name" />
                      <p><b>Short name:</b></p>
                      <input name="short_name" value="duc" type="text" placeholder="Enter short name" />                  
                      <p><b>Username:</b></p>
                      <input name="username" value="levanduc" type="text" placeholder="Enter username" />
                      <p><b>Phone number:</b></p>
                      <input name="phone" value="123" type="text" placeholder="Enter phone number" />
                      <p><b>Email:</b></p>
                      <input name="email" value="levanduc@gmail.com" type="text" placeholder="Enter email" />
                      <p><b>Group:</b></p>
                      <select name="group_id" >
                            @foreach($groups as $group)
                            <option value="{{$group->id}}">{{ $group->name }}</option>
                            @endforeach
                      </select>
                      <p><b>Password:</b></p>
                      <input name="password" value="123" type="password" placeholder="Enter password" />
                      <div >
                          <input name="inptSubmitPopup" type="submit" value="Save" readonly/>
                          <input onclick="hidePopup()" name="inptCancelPopup" value="Cancel" readonly/>
                      </div>
                    </div>
          </form>

    </div>
    <div class="flex-container">
        <!-- display all users -->
        <div id="left">
            <ul id="list-of-users" data-old="{{session('old')}}" data-info="{{ session('user_id') }}" data-old="{{session('mark')}}">
                <li class="flex-container">
                    <p onclick="document.getElementById('id01').style.display='block'" name="addUser">Add a new user</p>
                    <button type="button"></button>
                </li>
                <li class="flex-container">
                    <p name="name" onclick="displayUser(this)" data-info="{{ $admin }}">Admin</p>
                    <button style="visibility: hidden;" name="admin" type="button" ></button>
                </li>
                @foreach($users as $user)
                @if($user->permission == 0)
                <li class="flex-container">
                    <p name="name" onclick="displayUser(this)" data-info="{{ $userj[$user->id] }}">{{ $user->name }}</p>
                    <button name="{{ $user->name }}" onclick="deleteUser(this)" type="button" ><img src="{{asset('images/remove.png')}}" alt="delete"/></button>
                </li>
                @endif
                @endForeach

            </ul>
        </div>

        <!-- display information of a user -->
        <div id="right" class="flex-container">
                <form name="infor" class="flex-container" action="/users/edit" method="POST" enctype="multipart/form-data">@csrf
                    <div name="avatar" id="avatarContainer" class="flex-container">
                        <img name="ava" id="avatar" src="{{asset('images/user/'.json_decode($admin)->username.json_decode($admin)->avatar)}}" alt="avatar" />
                        <div class=flex-container>
                            <button onclick="document.getElementById('changeAvar').click()" name="changeAvar" type="button">Change</button>
                            <input style="display:none;" onchange="changeAva(event)" type="file" accept="image/*" id="changeAvar" name="avatar" value="{{asset('images/user/'.json_decode($admin)->username.json_decode($admin)->avatar)}}"  />
                            <button onclick="deleteAva()" type="button" name="deleteAvar">Delete</button>
                        </div>

                    </div>
                    <div id="userinformation"> 
                        <p><strong>Full name:</strong></p>
                        <input type="text" name="fullname" value="" />
                        <?php if(isset(session('uv')['fullnameErr'])){echo "<p name=\"Error\">".(session('uv'))['fullnameErr']."</p>";} ?>
                        <p><strong>Phone number:</strong></p>
                        <input type="text" name="phone" value="{{json_decode($admin)->phone}}" />
                        <?php if(isset(session('uv')['phoneErr'])){echo "<p name=\"Error\">".(session('uv'))['phoneErr']."</p>";} ?>
                        <p><strong>Email:</strong></p>
                        <input type="text" name="email" value="{{json_decode($admin)->email}}" />
                        <?php if(isset(session('uv')['emailErr'])){echo "<p name=\"Error\">".(session('uv'))['emailErr']."</p>";} ?>
                        <p><strong>Group:</strong></p>
                        <select name="group_id" />
                            @foreach($groups as $group)
                            @if($group->name == json_decode($admin)->group)
                            <option value="{{$group->id}}" selected>{{ $group->name }}</option>
                            @else
                            <option value="{{$group->id}}">{{ $group->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        <p><strong>Short name:</strong></p>
                        <input type="text" name="short_name" value="{{json_decode($admin)->shortname}}" />
                        <input type="text" style="display: none;" value="{{json_decode($admin)->username}}" name="username" />
                        <input type="text" style="display: none;" value="{{json_decode($admin)->password}}" name="password" />                        
                        <input type="text" style="display: none;" value="{{json_decode($admin)->id}}" name="user_id" />
                        <div>
                          <input name="submit" type="submit" value="Save" />
                          <input name="cancel" type="button" onclick="discardChanges()" value="Cancel" />
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    
@endsection




