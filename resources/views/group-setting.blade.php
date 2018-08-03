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
                        <div class="col-xs-12 add-group-item">
                            <div class="group-display">
                                <input type="text">
                            </div>
                            <div class="group-button add-button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                        </div>
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
                            <div class="group-button delete-button">
                                <span class="glyphicon glyphicon-trash"></span>
                            </div>
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
        <form class="col-sm-9">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="group-title">{{ $groups->get($active_id)->name }}</h4>
                    <input type="hidden" name="user_group_id" id="user_group_id" value="{{ $active_id }}">
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
                    Action arrow
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
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-success save-group-setting" type="button">Save</button>
                    <button class="btn btn-primary reset-group-setting" type="button">Reset</button>
                    <a href="{{ route("home") }}"><button class="btn btn-default" type="button">Cancel</button></a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" 
                aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Change group</h4>
            </div>
            <div class="modal-body">
                You has made some change on the current group, do you want to discard all change
                and move to this group?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger discard-group-setting">Discard</button>
                <button type="button" class="btn btn-primary save-group-setting">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
