@extends('layouts.app')
@section('title','Home')
@section('big-title','Cybozu VN')
@section('scripts')
    <script src="{{ asset('js/deleteSeatmap.js') }}"></script>
    <script src="{{ asset("/js/detail.js") }}"></script>
@endsection

@section('content')
<link href="{{ asset("/css/detail.css") }}" rel="stylesheet">
    <div class="container-fluid">
        @auth
            <div class="delete-form row">
                {{--Delete and edit button--}}
                <div class="col-md-12">
                    <img data-id="{{$map->id}}" data-name="{{$map->name}}"
                         class="seatmap-button delete-seatmap pull-right" data-toggle="modal"
                         data-target="#delete-map-modal"
                         src="{{asset('images/remove.png')}}">
                    <a href="/seat-map/edit/{{$map->id}}"> <img class="seatmap-button pull-right"
                                                                src="{{asset('images/edit.png')}}">
                    </a>
                </div>

                {{-------------------------}}
                {{--"Delete seat map"Hidden form --}}
                <form role="form" id="frmDeleteSM" action="/seat-map/delete" method="post">
                    @csrf
                    <input type="hidden" name="returnHome" value="1">
                    <input type="hidden" name="SeatmapID" id="deleteID">
                    <input type="hidden" name="SeatmapName" id="deleteName">
                </form>

                {{--Add map modal form--}}
                <div class="modal fade" id="delete-map-modal" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Delete seat map</h4>
                            </div>
                            <div class="modal-body">
                                Do you really want to delete "<span id="delete-name"></span>"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="delete-confirm" class=" btn btn-danger " data-dismiss="modal"
                                        data-id="" data-name="">
                                    Delete
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                {{----------------------}}

                {{---------------------------------}}

            </div>


        @endauth
        @include("seat-map.map-viewport")

    </div>



@endsection

