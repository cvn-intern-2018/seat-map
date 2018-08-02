@extends('layouts.app')
@section('title','Home')
@section('big-title','Cybozu VN')
@section('content')
    <div class="container">
        @include("seat-map.map-viewport")
    </div>

@endsection

