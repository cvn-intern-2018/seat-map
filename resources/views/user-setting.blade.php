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
                <div class="container_">
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
    <div class="flex-container_">
        <!-- display all users -->
        <div id="left">
            <ul id="list-of-users" data-prv_data="{{session('prv_data')}}" data-info="{{ session('user_id') }}" >
                <li class="flex-container_">
                    <p onclick="document.getElementById('id01').style.display='block'" name="addUser">Add a new user</p>
                    <button type="button"></button>
                </li>
                <li class="flex-container_">
                    <p name="name" onclick="displayUser(this)" data-info="{{ $admin }}"><strong>Admin</strong></p>
                    <button style="visibility: hidden;" name="admin" type="button"></button>
                </li>
                @foreach($users as $user)
                @if($user->permission == 0)
                <li class="flex-container_">
                    <p name="name" onclick="displayUser(this)" data-info="{{ $arr_users[$user->id] }}"><strong>{{ $user->name }}</strong></p>
                    <button  type="button" ><img name="{{ $user->name }}" onclick="deleteUser(this)" src="{{asset('images/remove.png')}}" alt="delete"/></button>
                </li>
                @endif
                @endForeach

            </ul>
        </div>

        <!-- display information of a user -->
        <div id="right" class="flex-container_">
                <form name="infor" class="flex-container_" action="/users/edit" method="POST" enctype="multipart/form-data">@csrf
                    <div name="avatar" id="avatarcontainer_" class="flex-container_">
                        <img name="ava" id="avatar" src="{{asset('images/user/'.json_decode($admin)->username.json_decode($admin)->avatar)}}" alt="avatar"/>
                        <div class=flex-container_>
                            <button onclick="document.getElementById('changeAvar').click()" name="changeAvar" type="button">Change</button>
                            <input type="hidden" value="0" name="checkAvatar" />
                            <input style="" onchange="changeAvatar(event)" type="file" accept="image/*" id="changeAvar" name="avatar" value="{{asset('images/user/'.json_decode($admin)->username.json_decode($admin)->avatar)}}"  />
                            <button onclick="deleteAvatar()" type="button" name="deleteAvar">Delete</button>
                        </div>

                    </div>
                    <div id="userinformation"> 
                        <p><strong>Full name:</strong></p>
                        <input type="text" name="fullname" value="" />
                        <?php if(isset(session('prv_error')['fullnameErr'])){echo "<p name=\"Error\">".(session('prv_error'))['fullnameErr']."</p>";} ?>
                        <p><strong>Phone number:</strong></p>
                        <input type="text" name="phone" value="{{json_decode($admin)->phone}}" />
                        <?php if(isset(session('prv_error')['phoneErr'])){echo "<p name=\"Error\">".(session('prv_error'))['phoneErr']."</p>";} ?>
                        <p><strong>Email:</strong></p>
                        <input type="text" name="email" value="{{json_decode($admin)->email}}" />
                        <?php if(isset(session('prv_error')['emailErr'])){echo "<p name=\"Error\">".(session('prv_error'))['emailErr']."</p>";} ?>
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
                            <input type="text" name="short_name" value="{{json_decode($admin)->shortname}}"/>
                            <input type="text" style="display: none;" value="{{json_decode($admin)->username}}"
                                   name="username"/>
                            <input type="text" style="display: none;" value="{{json_decode($admin)->password}}"
                                   name="password"/>
                            <input type="text" style="display: none;" value="{{json_decode($admin)->id}}"
                                   name="user_id"/>
                            <div>
                                <input name="submit" type="submit" value="Save"/>
                                <input name="cancel" type="button" onclick="discardChanges()" value="Cancel"/>
                            </div>
                </div>
            </form>
        </div>

    </div>
    </div>

@endsection




