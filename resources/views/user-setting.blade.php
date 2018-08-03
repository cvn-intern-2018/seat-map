@extends('layouts.app')
@section('home-active','active')
@section('title','Home')
@section('big-title','Cybozu VN')
@section('content')
    <link href="css/user-setting.css" rel="stylesheet" type="text/css">
    <script src="js/user-setting.js"></script>
    <div id="id01" class="modal">
            <form name="inforPopup" class="modal-content animate" action="/users/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div name="avatar" id="avatarPopup" class="flex-container">
                        <img id="imagePopup" src="#" alt="avatar" />
                        <div class=flex-container>
                            <button onclick="document.getElementById('changeAvarPopup').click()" name="changeAvarPopup" type="button">Change</button>
                            <input style="display:none;" onchange="changeAvaPopup()" type="file" accept="image/*" id="changeAvarPopup" name="changeAvarPopup"  />
                            <button onclick="deleteAvaPopup()" type="button" name="deleteAvar">Delete</button>
                      </div>
                </div>
                <div class="container">
                      <p><b>Full name:</b></p>
                      <input name="fullname" value="" type="text" placeholder="Enter full name" />
                      <p><b>Short name:</b></p>
                      <input name="shortname" value="" type="text" placeholder="Enter short name" />                      
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
                          <input onclick="hidePopup()" name="inptCancelPopup" value="Cancel"/>
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
                <form name="infor" class="flex-container" action="/users/edit" method="POST" enctype="multipart/form-data">@csrf
                    <div name="avatar" id="avatarContainer" class="flex-container">
                        <img id="avatar" src="{{asset('images/user/'.json_decode($admin)->username.json_decode($admin)->avatar)}}" alt="avatar" />
                        <div class=flex-container>
                            <button onclick="document.getElementById('changeAvar').click()" name="changeAvar" type="button">Change</button>
                            <input style="display:none;" onchange="changeAva(event)" type="file" accept="image/*" id="changeAvar" name="changeAvar"  />
                            <button onclick="deleteAva()" type="button" name="deleteAvar">Delete</button>
                        </div>

                    </div>
                    <div id="userinformation"> 
                        <p><strong>Full name:</strong></p>
                        <input type="text" name="fullname" value="{{json_decode($admin)->fullname}}" />
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
                        <p><strong>Short name:</strong></p>
                        <input type="text" name="shortname" value="{{json_decode($admin)->shortname}}" />
                        <input type="text" style="display: none;" value="{{json_decode($admin)->id}}" name="user_id" />
                        <input name="submit" type="submit" value="Save" />
                        <input name="save" type="button" onclick="discardChanges()" value="Cancel" />
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    
@endsection



