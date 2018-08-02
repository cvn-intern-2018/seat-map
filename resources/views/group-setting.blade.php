@extends("layouts.app")

@section("title", "Group setting")
@section("big-title", "Group setting")
@section("content")
<link rel="stylesheet" href="{{ cssLink("group-setting") }}">
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="row">
                <div class="col-xs-12">
                    <h4>Groups</h4>
                </div>
                <div class="col-xs-12 group-list">
                    <div class="row">
                        @foreach ($groups as $group)         
                        <div class="col-xs-12 group-item">
                            <div class="row">
                                <div class="col-xs-8 group-display">
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="text" value="{{ $group->name }}">
                                    <label for="group-name"> {{ $group->name }}</label>
                                </div>
                                <div class="col-xs-2 group-button edit-button">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </div>
                                <div class="col-xs-2 group-button save-button">
                                    <span class="glyphicon glyphicon glyphicon-floppy-disk"></span>
                                </div>
                                <div class="col-xs-2 group-button delete-button">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-5">
                    <h4>Group's member</h4>
                    <select name="member_users" id="selected_users" multiple>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" data-group="{{ $user->user_group_id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    Action arrow
                </div>
                <div class="col-sm-5">
                    <h4>Unselected users</h4>
                    <select name="non_member_users" id="selected_users" multiple>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" data-group="{{ $user->user_group_id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn btn-default">Cancel</div>
                    <div class="btn btn-success">Save</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
