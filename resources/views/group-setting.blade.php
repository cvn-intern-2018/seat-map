@extends("layouts.app")

@section("title", "Group setting")
@section("big-title", "Group setting")
@section("scripts")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section("content")
<link rel="stylesheet" href="{{ cssLink("group-setting") }}">
<script src="{{ jsLink("group-setting") }}"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="row">
                <div class="col-xs-12">
                    <h4>Groups</h4>
                </div>
                <div class="col-xs-12 group-list">
                    <div class="row">
                        <form class="col-xs-12 add-group-item" method="POST" action="{{ route("createNewGroup") }}">
                            {{ csrf_field() }}
                            <div class="group-display">
                                <input type="text" name="group_name" placeholder="Type new group name" required>
                            </div>
                            <div class="group-button add-button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                        </form>
                        @foreach ($groups as $group)         
                        <div class="col-xs-12 group-item
                        @if ($group->id == $active_id)
                        active
                        @endif
                        " data-group="{{ $group->id }}">
                            <div class="group-display">
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <input type="text" name="group_name" value="{{ $group->name }}">
                                <label for="group-name"> {{ $group->name }}</label>
                            </div>
                            <div class="group-button edit-button">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </div>
                            <div class="group-button save-button">
                                <span class="glyphicon glyphicon-floppy-disk"></span>
                            </div>
                            <form class="group-button delete-button delete-group-item"
                            method="POST" action="{{ route("deleteGroup") }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <span class="glyphicon glyphicon-trash"></span>
                            </form>
                            <div class="group-button cancel-button">
                                <span class="glyphicon glyphicon-remove"></span>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-xs-12 group-item" data-group="{{ $unassigned_group->id }}">
                            <div class="group-display">
                                <label for="group-name"> {{ $unassigned_group->name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="group-title">{{ $groups->get($active_id)->name }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <select name="member_users" id="member_users" multiple>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" data-group="{{ $user->user_group_id }}"
                        @if ($user->user_group_id != $active_id)
                        hidden
                        @endif
                        >
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <div class="arrows">
                        <div class="add-user">
                            Add
                        </div>
                        <div class="remove-user">
                            Remove
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <select name="non_member_users" id="non_member_users" multiple>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" data-group="{{ $user->user_group_id }}"
                            @if ($user->user_group_id == $active_id)
                            hidden
                            @endif
                            >
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <form class="row user-group-setting" method="POST" action="{{ route("updateUserGroup") }}">
                {{ csrf_field() }}
                <input type="hidden" name="user_group_id" id="user_group_id" value="{{ $active_id }}">
                <input type="hidden" name="user_group_data" id="user-group-data">
                <div class="col-xs-12">
                    <button class="btn btn-success save-group-setting" type="button">Save</button>
                    <button class="btn btn-primary reset-group-setting" type="button">Reset</button>
                    <a href="{{ route("home") }}"><button class="btn btn-default" type="button">Cancel</button></a>
                </div>
            </form>
        </div>
    </div>
</div>
@component("components.modal", [
    "id" => "changeGroupModal"
])
    @slot("title")
        Setting changed
    @endslot
    @slot("message")
        You has made some change on the current group, do you want to discard all change
        and move to this groups
    @endslot
    @slot("buttons")
        <button type="button" class="btn btn-danger discard-group-setting">
            Discard
        </button>
        <button type="button" class="btn btn-primary save-group-setting">
            Save changes
        </button>
    @endslot
@endcomponent
@component("components.modal", [
    "id" => "addGroupModal"
])
    @slot("title")
        Setting changed
    @endslot
    @slot("message")
        You has made some change on the current group, do you want to save the 
        change or discard all change and create new group?
    @endslot
    @slot("buttons")
        <button type="button" class="btn btn-danger discard-group-setting">
            Discard
        </button>
        <button type="button" class="btn btn-primary save-group-setting">
            Save changes
        </button>
    @endslot
@endcomponent
@component("components.modal", [
    "id" => "deleteGroupModal"
])
    @slot("title")
        Setting changed
    @endslot
    @slot("message")
        <p>You has made some change on the current group, do you want to save the 
        change or discard all change and delete group?</p>
        <p>Users in the deleted group will be moved to <strong>Unassigned group.</strong></p>
    @endslot
    @slot("buttons")
        <button type="button" class="btn btn-danger discard-group-setting">
            Discard
        </button>
        <button type="button" class="btn btn-primary save-group-setting">
            Save changes
        </button>
    @endslot
@endcomponent
@endsection
