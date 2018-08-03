@extends('layouts.app')
@section('home-active','active')
@section('title','Home')
@section('big-title','Cybozu VN')
@section('scripts')  <script src="{{ asset('js/home.js') }}"> </script>
<script src="{{ asset('js/deleteSeatmap.js') }}"> </script>
@endsection
@section('content')



    <link href="{{asset('css/home.css')}}" rel="stylesheet" type="text/css">
    <!-- <input name="_token" type="hidden" value="{{ csrf_token() }}"> -->
    <div class="container home">
        {{--Add map modal form--}}
        <div class="modal fade" id="delete-map-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

        <div class="row search-box">

            <form role="form" action="/" method="get" class="">

                <!--end of col-->
                <div class=" col-md-offset-2 col-md-7">
                    <input maxlength="100" onClick="this.select();"
                           class="form-control form-control-lg form-control-borderless" type="search" name="search"
                           placeholder="Search topics or keywords" value="@isset($search){{$search}}@endisset">


                </div>
                <!--end of col-->
                <div class="col-md-1">
                    <button class="btn btn-md btn-success" type="submit">Search</button>
                </div>

                <!--end of col-->
            </form>
            @auth
                {{--Add map button--}}
                <div class="col-md-offset-1 col-md-1 centered text-center">
                    <button
                            class="btn btn-md btn-primary add-map-button" type="button" data-toggle="modal"
                            data-target="#add-map-form">Add map
                    </button>
                </div>
                {{-------------------}}
                {{--Add map modal form--}}
                <div class="modal fade" id="add-map-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <form role="form" class="modal-content animate" action="/seat-map/add" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Remove user from map</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="sm-form">

                                        <label for="SeatmapName"><b>Seat map's name: </b></label>
                                        <input maxlength="100"
                                               oninvalid="this.setCustomValidity('Please input the Seat map\'s name here!!!')"
                                               oninput="this.setCustomValidity('')" type="text"
                                               class="form-control sm-name"
                                               placeholder="Enter Seatmap's name" name="SeatmapName" required>
                                        <label for="SeatmapPic"><b>Image (Accept .jpg, .png or .gif) : </b></label>
                                        <input oninvalid="this.setCustomValidity('Hey dude, you forgot to upload the map\'s image!!!')"
                                               oninput="this.setCustomValidity('')" onchange="loadFile(event)"
                                               type="file"
                                               name="SeatmapPic"
                                               accept=".png, .jpg, .gif" required>
                                        <img id="img-preview">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button class="addbtn btn btn-md btn-success " type="submit"> Add map</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            {{----------------------}}
        @endauth
        <!--end of col-->
        </div>
        @if($maps->count()!=0)
            @isset($search)
                <div class="col-md-8 col-md-offset-2"
                     style="text-align:center; margin-bottom: 20px;  font-size: 15px; color: blue;">
                    {{$maps->total()}} results have been found for key words: "{{$search}}"
                </div>
            @endisset
        @endif
        <div class="row">
            @isset($maps)
                @if($maps->count()==0)
                    <div class="row">
                        <div class="centered text-center text big-notify">
                            <h1> No SeatMap </h1>
                        </div>
                    </div>
                @else
                    @foreach ($maps as $map)
                        <div class="col-md-3">
                            <div class="panel panel-info">
                                <div class="panel-heading clearfix">
                                    <a href="/seat-map/{{$map->id}}">
                                        <div class="panel-title pull-left ">{{$map->name}}</div>
                                    </a>
                                    @auth
                                        <img data-id="{{$map->id}}" data-name="{{$map->name}}"
                                             class="seatmap-button pull-right delete-seatmap" data-toggle="modal"
                                             data-target="#delete-map-modal"
                                             src="{{asset('images/remove.png')}}">
                                        <a href="/seat-map/edit/{{$map->id}}"> <img class="seatmap-button pull-right"
                                                                                    src="{{asset('images/edit.png')}}">
                                        </a>
                                        {{--"Delete seat map"Hidden form --}}
                                        <form role="form" id="frmDeleteSM" action="/seat-map/delete" method="post">
                                            @csrf
                                            <input type="hidden" name="SeatmapID" id="deleteID">
                                            <input type="hidden" name="SeatmapName" id="deleteName">
                                        </form>
                                        {{---------------------------------}}
                                    @endauth
                                </div>
                                <a href="/seat-map/{{$map->id}}">
                                    <div class="panel-body">

                                        <img alt="{{$map->name}}" class="center-block"
                                             src="{{asset('images/seat-map/'.$map->id.$map->img)}}">
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
        </div>
        <div class="row">
            <div class="centered text-center">
                {{$maps->links()}}
            </div>
        </div>
        @endif
        @else
            <div class="row">
                <div class="centered text-center text big-notify">
                    <h1> No SeatMap </h1>
                </div>
            </div>
        @endisset
    </div>
    </div>




@endsection


